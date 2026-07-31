<?php

namespace App\Exports;

use App\Models\Ticket;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SlaReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
	protected ?string $slaStatus;

	public function __construct(?string $slaStatus = null)
	{
		$this->slaStatus = $slaStatus;
	}

	public function collection()
	{
		$query = Ticket::query()
			->with([
				'client',
				'category',
				'assignedTo',
				'ruleLogs.rule',
			])
			->whereIn('status', ['open', 'in_progress', 'pending', 'resolved']);

		if ($this->slaStatus && in_array($this->slaStatus, ['on_time', 'warning', 'breach'])) {
			$query->whereHas('ruleLogs', function ($q) {
				$q->where('status', $this->slaStatus);
			});
		}

		return $query->latest()->get();
	}

	public function headings(): array
	{
		return [
			'No',
			'Kode Tiket',
			'Judul',
			'Klien',
			'Prioritas',
			'Status Tiket',
			'Status SLA',
			'Response SLA',
			'Resolution SLA',
			'Response Deadline',
			'Resolution Deadline',
			'First Response At',
			'Resolved At',
			'Sisa Waktu',
			'Teknisi',
		];
	}

	public function map($ticket): array
	{
		$ruleLog = $ticket->ruleLogs->first();
		$now = Carbon::now();

		// Response SLA
		$responseDeadline = $ruleLog?->response_deadline;
		$responseStatus = $ruleLog?->first_response_at
			? ($ruleLog->first_response_at->greaterThan($responseDeadline) ? 'Breach' : 'On Time')
			: ($responseDeadline && $now->greaterThan($responseDeadline) ? 'Breach'
				: ($responseDeadline && $now->diffInSeconds($responseDeadline, false) > 0
					&& ($now->diffInSeconds($responseDeadline) / max(1, $responseDeadline->diffInSeconds($ticket->created_at))) <= 0.2
					? 'Warning' : 'On Time'));

		// Resolution SLA
		$resolutionDeadline = $ruleLog?->resolution_deadline;
		$resolutionStatus = $ruleLog?->resolved_at
			? ($ruleLog->resolved_at->greaterThan($resolutionDeadline) ? 'Breach' : 'On Time')
			: ($resolutionDeadline && $now->greaterThan($resolutionDeadline) ? 'Breach'
				: ($resolutionDeadline && $now->diffInSeconds($resolutionDeadline, false) > 0
					&& ($now->diffInSeconds($resolutionDeadline) / max(1, $resolutionDeadline->diffInSeconds($ticket->created_at))) <= 0.2
					? 'Warning' : 'On Time'));

		$overallStatus = $ruleLog?->status ?? 'on_time';
		$statusLabel = match ($overallStatus) {
			'on_time' => 'On Time',
			'warning' => 'Warning',
			'breach'  => 'Breach',
			default   => 'On Time',
		};

		// Remaining time
		$remainingText = '-';
		$remainingSeconds = null;
		if ($responseDeadline && $now->lessThan($responseDeadline)) {
			$remainingSeconds = $now->diffInSeconds($responseDeadline);
		}
		if ($resolutionDeadline && $now->lessThan($resolutionDeadline)) {
			$resSecs = $now->diffInSeconds($resolutionDeadline);
			if ($remainingSeconds === null || $resSecs < $remainingSeconds) {
				$remainingSeconds = $resSecs;
			}
		}
		if ($remainingSeconds !== null) {
			$hours = floor($remainingSeconds / 3600);
			$minutes = floor(($remainingSeconds % 3600) / 60);
			$remainingText = $hours > 0 ? "{$hours}j {$minutes}m" : "{$minutes}m";
		}

		static $no = 0;
		$no++;

		return [
			$no,
			$ticket->kode_ticket,
			$ticket->judul,
			$ticket->client?->nama ?? '-',
			ucfirst($ticket->priority),
			ucfirst(str_replace('_', ' ', $ticket->status)),
			$statusLabel,
			$responseStatus,
			$resolutionStatus,
			$responseDeadline?->format('d/m/Y H:i') ?? '-',
			$resolutionDeadline?->format('d/m/Y H:i') ?? '-',
			$ruleLog?->first_response_at?->format('d/m/Y H:i') ?? '-',
			$ruleLog?->resolved_at?->format('d/m/Y H:i') ?? '-',
			$remainingText,
			$ticket->assignedTo?->name ?? '-',
		];
	}

	public function styles(Worksheet $sheet)
	{
		return [
			1 => [
				'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
				'fill' => [
					'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
					'startColor' => ['rgb' => '2563EB'],
				],
			],
		];
	}
}
