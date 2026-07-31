<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TicketReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
	protected ?string $status;
	protected ?string $categoryId;
	protected ?string $priority;

	public function __construct(?string $status = null, ?string $categoryId = null, ?string $priority = null)
	{
		$this->status = $status;
		$this->categoryId = $categoryId;
		$this->priority = $priority;
	}

	public function collection()
	{
		$query = Ticket::query()
			->with([
				'client',
				'category',
				'assignedTo',
				'createdBy',
				'ruleLogs',
			]);

		if ($this->status && $this->status !== 'semua') {
			$query->where('status', $this->status);
		}

		if ($this->categoryId && $this->categoryId !== 'semua') {
			$query->where('category_id', $this->categoryId);
		}

		if ($this->priority && $this->priority !== 'semua') {
			$query->where('priority', $this->priority);
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
			'Kategori',
			'Prioritas',
			'Status',
			'Teknisi',
			'Dibuat Oleh',
			'SLA Status',
			'Dibuat',
			'Resolved At',
			'Closed At',
		];
	}

	public function map($ticket): array
	{
		static $no = 0;
		$no++;

		$ruleLog = $ticket->ruleLogs->first();
		$slaStatus = $ruleLog?->status ?? '-';
		$slaLabel = match ($slaStatus) {
			'on_time' => 'On Time',
			'warning' => 'Warning',
			'breach' => 'Breach',
			default => '-',
		};

		return [
			$no,
			$ticket->kode_ticket,
			$ticket->judul,
			$ticket->client?->nama ?? '-',
			$ticket->category?->nama ?? '-',
			ucfirst($ticket->priority),
			ucfirst(str_replace('_', ' ', $ticket->status)),
			$ticket->assignedTo?->name ?? '-',
			$ticket->createdBy?->name ?? '-',
			$slaLabel,
			$ticket->created_at->format('d/m/Y H:i'),
			$ticket->resolved_at?->format('d/m/Y H:i') ?? '-',
			$ticket->closed_at?->format('d/m/Y H:i') ?? '-',
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
