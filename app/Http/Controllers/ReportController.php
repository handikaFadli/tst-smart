<?php

namespace App\Http\Controllers;

use App\Exports\ClientReportExport;
use App\Exports\SlaReportExport;
use App\Exports\TechnicianPerformanceExport;
use App\Exports\TicketReportExport;
use App\Models\Product;
use App\Models\TicketCategory;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
	public function index()
	{
		$categories = TicketCategory::where('is_active', true)->orderBy('nama')->get();
		$products = Product::orderBy('nama')->get();

		return view('reports.index', compact('categories', 'products'));
	}

	public function exportTickets(Request $request)
	{
		return Excel::download(
			new TicketReportExport(
				$request->status,
				$request->category_id,
				$request->priority
			),
			'laporan-tiket-' . now()->format('Y-m-d-H-i') . '.xlsx'
		);
	}

	public function exportSla(Request $request)
	{
		return Excel::download(
			new SlaReportExport($request->sla_status),
			'laporan-sla-' . now()->format('Y-m-d-H-i') . '.xlsx'
		);
	}

	public function exportTechnicianPerformance()
	{
		return Excel::download(
			new TechnicianPerformanceExport(),
			'laporan-performa-teknisi-' . now()->format('Y-m-d-H-i') . '.xlsx'
		);
	}

	public function exportClients()
	{
		return Excel::download(
			new ClientReportExport(),
			'laporan-klien-' . now()->format('Y-m-d-H-i') . '.xlsx'
		);
	}

	public function exportTicketsPdf(Request $request)
	{
		$query = Ticket::query()
			->with([
				'client',
				'category',
				'assignedTo',
				'createdBy',
				'ruleLogs',
			]);

		if ($request->status && $request->status !== 'semua') {
			$query->where('status', $request->status);
		}

		if ($request->category_id && $request->category_id !== 'semua') {
			$query->where('category_id', $request->category_id);
		}

		if ($request->priority && $request->priority !== 'semua') {
			$query->where('priority', $request->priority);
		}

		$tickets = $query->latest()->get();

		$pdf = Pdf::loadView('reports.pdf.tickets', [
			'tickets' => $tickets,
			'exportedAt' => now(),
		])->setPaper('a4', 'landscape');

		return $pdf->download('laporan-tiket-' . now()->format('Y-m-d-H-i') . '.pdf');
	}

	public function exportSlaPdf(Request $request)
	{
		$query = Ticket::query()
			->with([
				'client',
				'category',
				'assignedTo',
				'ruleLogs.rule',
			])
			->whereIn('status', ['open', 'in_progress', 'pending', 'resolved']);

		if ($request->sla_status && in_array($request->sla_status, ['on_time', 'warning', 'breach'])) {
			$query->whereHas('ruleLogs', function ($q) use ($request) {
				$q->where('status', $request->sla_status);
			});
		}

		$tickets = $query->latest()->get();

		$pdf = Pdf::loadView('reports.pdf.sla', [
			'tickets' => $tickets,
			'exportedAt' => now(),
		])->setPaper('a4', 'landscape');

		return $pdf->download('laporan-sla-' . now()->format('Y-m-d-H-i') . '.pdf');
	}

	public function exportTechnicianPerformancePdf()
	{
		$technicians = User::query()
			->whereIn('role', ['support', 'leader'])
			->withCount([
				'assignedTickets as total_ticket',
				'assignedTickets as solved_ticket' => function ($q) {
					$q->whereIn('status', ['resolved', 'closed']);
				},
				'assignedTickets as open_ticket' => function ($q) {
					$q->whereIn('status', ['open', 'in_progress', 'pending']);
				},
				'assignedTickets as breach_ticket' => function ($q) {
					$q->whereHas('latestRuleLog', function ($sla) {
						$sla->where('status', 'breach');
					});
				},
			])
			->get()
			->map(function ($item) {
				$item->success_rate = $item->total_ticket > 0
					? round(($item->solved_ticket / $item->total_ticket) * 100, 1)
					: 0;
				return $item;
			});

		$pdf = Pdf::loadView('reports.pdf.technician', [
			'technicians' => $technicians,
			'exportedAt' => now(),
		])->setPaper('a4', 'landscape');

		return $pdf->download('laporan-performa-teknisi-' . now()->format('Y-m-d-H-i') . '.pdf');
	}

	public function exportClientsPdf()
	{
		$clients = Client::query()
			->with([
				'clientType',
				'picTim',
				'app.product',
				'app.server',
				'contacts',
			])
			->orderBy('nama')
			->get();

		$pdf = Pdf::loadView('reports.pdf.clients', [
			'clients' => $clients,
			'exportedAt' => now(),
		])->setPaper('a4', 'landscape');

		return $pdf->download('laporan-klien-' . now()->format('Y-m-d-H-i') . '.pdf');
	}
}
