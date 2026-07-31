<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Ticket;
use App\Models\TicketRule;
use App\Models\TicketRuleLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TicketSlaService
{

	public function initializeForNewTicket(Ticket $ticket): TicketRuleLog
	{
		if ($ticket->ruleLogs()->exists()) {
			return $ticket->latestRuleLog;
		}

		return DB::transaction(function () use ($ticket) {
			$rule = $this->getActiveRuleByPriority($ticket->priority);

			$responseDeadline = $ticket->created_at->copy()->addMinutes((int) $rule->response_time);
			$resolutionDeadline = $ticket->created_at->copy()->addMinutes((int) $rule->resolution_time);

			return TicketRuleLog::query()->create([
				'ticket_id'            => $ticket->id,
				'ticket_rule_id'       => $rule->id,
				'response_deadline'    => $responseDeadline,
				'resolution_deadline'  => $resolutionDeadline,
				'first_response_at'    => null,
				'resolved_at'          => null,
				'status'               => 'on_time',
			]);
		});
	}

	public function markFirstResponse(Ticket $ticket, Carbon $occurredAt): void
	{
		DB::transaction(function () use ($ticket, $occurredAt) {

			$ruleLog = $this->getLatestRuleLogLocked($ticket);

			if (! $ruleLog) {
				return;
			}

			// First Response hanya dicatat sekali
			if ($ruleLog->first_response_at !== null) {
				return;
			}

			$ruleLog->first_response_at = $occurredAt;
			$ruleLog->save();

			// Hitung ulang status SLA
			$this->computeAndUpdateStatus($ruleLog);
		});
	}

	public function markResolved(Ticket $ticket, Carbon $occurredAt): void
	{
		DB::transaction(function () use ($ticket, $occurredAt) {
			$ruleLog = $this->getLatestRuleLogLocked($ticket);

			if (! $ruleLog || $ruleLog->resolved_at !== null) {
				return;
			}

			$ticket->update([
				'resolved_at' => $occurredAt
			]);
			$ruleLog->update(['resolved_at' => $occurredAt]);

			$this->computeAndUpdateStatus($ruleLog);
		});
	}

	public function refreshStatus(Ticket $ticket): void
	{
		$ruleLog = $this->getLatestRuleLogLocked($ticket);

		if (! $ruleLog) {
			return;
		}

		$this->computeAndUpdateStatus($ruleLog);
	}

	public function refreshAllOpenTickets(): int
	{
		$processed = 0;

		Ticket::query()
			->whereIn('status', [
				'open',
				'in_progress',
				'pending'
			])
			->chunkById(100, function ($tickets) use (&$processed) {

				foreach ($tickets as $ticket) {

					$this->refreshStatus($ticket);

					$processed++;
				}
			});

		return $processed;
	}

	public function computeSlaStatus(TicketRuleLog $ruleLog, Carbon $now): string
	{
		$ruleLog->loadMissing('rule');
		$rule = $ruleLog->rule;

		$responseTotalSeconds = $rule ? ((int) $rule->response_time) * 60 : 0;
		$resolutionTotalSeconds = $rule ? ((int) $rule->resolution_time) * 60 : 0;

		// Response SLA
		$responseStatus = $this->computeSingleSla(
			$ruleLog->first_response_at,
			$ruleLog->response_deadline,
			$now,
			$responseTotalSeconds
		);

		// Resolution SLA
		$resolutionStatus = $this->computeSingleSla(
			$ruleLog->resolved_at,
			$ruleLog->resolution_deadline,
			$now,
			$resolutionTotalSeconds
		);

		if ($responseStatus === 'breach' || $resolutionStatus === 'breach') {
			return 'breach';
		}

		if ($responseStatus === 'warning' || $resolutionStatus === 'warning') {
			return 'warning';
		}

		return 'on_time';
	}


	private function computeSingleSla(?Carbon $occurredAt, Carbon $deadline, Carbon $now, int $totalSeconds): string
	{
		// Jika event sudah terjadi, bandingkan dengan deadline
		if ($occurredAt !== null) {
			return $occurredAt->greaterThan($deadline) ? 'breach' : 'on_time';
		}

		// Jika event belum terjadi dan deadline sudah terlewati
		if ($now->greaterThan($deadline)) {
			return 'breach';
		}

		// Jika total SLA tidak valid, anggap on_time
		if ($totalSeconds <= 0) {
			return 'on_time';
		}

		// Hitung sisa waktu sebagai persentase dari total SLA
		// $remaining = max(0, $now->diffInSeconds($deadline));
		$remaining = max(
			0,
			$now->diffInSeconds($deadline)
		);

		$ratio = $remaining / $totalSeconds;

		return $ratio <= 0.2 ? 'warning' : 'on_time';
	}

	public function getActiveRuleByPriority(string $priority): TicketRule
	{
		return TicketRule::query()
			->where('is_active', true)
			->where('priority', $priority)
			->firstOrFail();
	}

	private function getLatestRuleLogLocked(Ticket $ticket): ?TicketRuleLog
	{
		return $ticket->ruleLogs()
			->orderByDesc('id')
			->lockForUpdate()
			->first();
	}

	private function computeAndUpdateStatus(TicketRuleLog $ruleLog): void
	{
		$now = Carbon::now();
		$newStatus = $this->computeSlaStatus($ruleLog, $now);

		if ($newStatus !== $ruleLog->status) {
			$ruleLog->update(['status' => $newStatus]);
			$ruleLog->refresh();
		}
	}
}
