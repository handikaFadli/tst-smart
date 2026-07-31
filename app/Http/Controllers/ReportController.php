<?php

namespace App\Http\Controllers;

use App\Exports\ClientReportExport;
use App\Exports\SlaReportExport;
use App\Exports\TechnicianPerformanceExport;
use App\Exports\TicketReportExport;
use App\Models\Product;
use App\Models\TicketCategory;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
}
