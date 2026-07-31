<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TechnicianPerformanceExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
	public function collection()
	{
		return User::query()
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
	}

	public function headings(): array
	{
		return [
			'No',
			'Nama Teknisi',
			'Role',
			'Total Tiket',
			'Solved',
			'Open',
			'Breach',
			'Success Rate (%)',
		];
	}

	public function map($tech): array
	{
		static $no = 0;
		$no++;

		return [
			$no,
			$tech->name,
			ucfirst($tech->role),
			$tech->total_ticket ?? 0,
			$tech->solved_ticket ?? 0,
			$tech->open_ticket ?? 0,
			$tech->breach_ticket ?? 0,
			$tech->success_rate,
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
