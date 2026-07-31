<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketRuleLog;
use App\Models\User;
use App\Models\Client;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	public function __invoke(Request $request)
	{
		// 1. Ticket Statistics by Status
		$ticketStats = Ticket::selectRaw("
            COUNT(*) as total,
            SUM(CASE WHEN status = 'open' THEN 1 ELSE 0 END) as open,
            SUM(CASE WHEN status = 'in_progress' THEN 1 ELSE 0 END) as in_progress,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'resolved' THEN 1 ELSE 0 END) as resolved,
            SUM(CASE WHEN status = 'closed' THEN 1 ELSE 0 END) as closed
        ")->first();

		// 2. SLA Monitoring berdasarkan status pada rule_log
		$slaStats = TicketRuleLog::selectRaw("
            SUM(CASE WHEN status = 'on_time' THEN 1 ELSE 0 END) as on_time,
            SUM(CASE WHEN status = 'warning' THEN 1 ELSE 0 END) as warning,
            SUM(CASE WHEN status = 'breach' THEN 1 ELSE 0 END) as breach
        ")->first();

		// 3. Monthly Ticket Trends (12 bulan terakhir)
		$tickets = Ticket::where('created_at', '>=', now()->subMonths(12))
			->get();

		$monthlyTrends = $tickets
			->groupBy(function ($ticket) {
				return $ticket->created_at->format('Y-m');
			})
			->map(function ($items) {
				return $items->count();
			});

		$months = [];
		for ($i = 11; $i >= 0; $i--) {
			$date = now()->subMonths($i);
			$key = $date->format('Y-m');
			$label = $date->format('M Y');
			$months[] = [
				'label' => $label,
				'total' => $monthlyTrends[$key] ?? 0,
			];
		}

		// 4. Tickets by Category
		$ticketsByCategory = TicketCategory::select('ticket_categories.nama', DB::raw('COUNT(tickets.id) as total'))
			->leftJoin('tickets', 'ticket_categories.id', '=', 'tickets.category_id')
			->groupBy('ticket_categories.id', 'ticket_categories.nama')
			->orderByDesc('total')
			->get();

		// 5. Tickets by Priority
		$ticketsByPriority = Ticket::selectRaw("
            priority,
            COUNT(*) as total
        ")
			->groupBy('priority')
			->orderByDesc('total')
			->pluck('total', 'priority');

		// 6. Team Performance (support & leader)

		$driver = DB::getDriverName();

		$teamPerformance = User::query()
			->whereIn('role', ['support', 'leader'])
			->where('users.is_active', true)
			->leftJoin('tickets', 'users.id', '=', 'tickets.assigned_to')
			->select([
				'users.id',
				'users.name',
				DB::raw('COUNT(DISTINCT tickets.id) as total_tickets'),
			])
			->groupBy('users.id', 'users.name')
			->orderByDesc('total_tickets')
			->get()
			->map(function ($user) use ($driver) {

				// ==========================
				// Average Resolution Time
				// ==========================
				if ($driver === 'pgsql') {

					$avgResolution = Ticket::query()
						->where('assigned_to', $user->id)
						->whereNotNull('resolved_at')
						->selectRaw("
                    ROUND(
                        AVG(
                            EXTRACT(
                                EPOCH FROM (
                                    resolved_at - created_at
                                )
                            ) / 60
                        ),
                    1) as avg
                ")
						->value('avg');
				} else {

					$avgResolution = Ticket::query()
						->where('assigned_to', $user->id)
						->whereNotNull('resolved_at')
						->selectRaw("
                    ROUND(
                        AVG(
                            TIMESTAMPDIFF(
                                MINUTE,
                                created_at,
                                resolved_at
                            )
                        ),
                    1) as avg
                ")
						->value('avg');
				}

				// ==========================
				// Average First Response
				// ==========================
				if ($driver === 'pgsql') {

					$avgResponse = TicketRuleLog::query()
						->whereHas('ticket', function ($q) use ($user) {
							$q->where('assigned_to', $user->id);
						})
						->whereNotNull('first_response_at')
						->selectRaw("
                    ROUND(
                        AVG(
                            EXTRACT(
                                EPOCH FROM (
                                    first_response_at - created_at
                                )
                            ) / 60
                        ),
                    1) as avg
                ")
						->value('avg');
				} else {

					$avgResponse = TicketRuleLog::query()
						->whereHas('ticket', function ($q) use ($user) {
							$q->where('assigned_to', $user->id);
						})
						->whereNotNull('first_response_at')
						->selectRaw("
                    ROUND(
                        AVG(
                            TIMESTAMPDIFF(
                                MINUTE,
                                created_at,
                                first_response_at
                            )
                        ),
                    1) as avg
                ")
						->value('avg');
				}

				$user->avg_resolution_minutes = round($avgResolution ?? 0, 1);
				$user->avg_response_minutes = round($avgResponse ?? 0, 1);

				return $user;
			});

		// 7. Top Clients
		$topClients = Client::select([
			'clients.id',
			'clients.nama',
			'clients.kode',
			DB::raw('COUNT(tickets.id) as total_tickets'),
		])
			->leftJoin('tickets', 'clients.id', '=', 'tickets.client_id')
			->groupBy('clients.id', 'clients.nama', 'clients.kode')
			->orderByDesc('total_tickets')
			->limit(10)
			->get();

		return view('dashboard', compact(
			'ticketStats',
			'slaStats',
			'months',
			'ticketsByCategory',
			'ticketsByPriority',
			'teamPerformance',
			'topClients'
		));
	}
}
