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

		// Team Performance: total tiket closed per teknisi support
		$teamPerformance = User::query()
			->where('role', 'support')
			->where('is_active', true)
			->withCount([
				'assignedTickets as total_closed' => function ($query) {
					$query->where('status', 'closed');
				},
			])
			->orderByDesc('total_closed')
			->orderBy('name')
			->get();


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
