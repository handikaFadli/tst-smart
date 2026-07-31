<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ClientReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
	public function collection()
	{
		return Client::query()
			->with([
				'clientType',
				'picTim',
				'app.product',
				'app.server',
			])
			->orderBy('nama')
			->get();
	}

	public function headings(): array
	{
		return [
			'No',
			'Kode',
			'Nama Klien',
			'Tipe Klien',
			'PIC Tim',
			'Produk Aplikasi',
			'Server',
			'URL Aplikasi',
			'Status Aplikasi',
			'Expired Aplikasi',
			'Sisa Hari Aplikasi',
			'Expired Domain',
			'Sisa Hari Domain',
			'Dibuat',
		];
	}

	public function map($client): array
	{
		static $no = 0;
		$no++;

		$app = $client->app;
		$mainContact = $client->contacts->first();

		return [
			$no,
			$client->kode,
			$client->nama,
			$client->clientType?->nama ?? '-',
			$client->picTim?->name ?? '-',
			$app?->product?->nama ?? '-',
			$app?->server?->nama ?? '-',
			$app?->url_aplikasi ?? '-',
			$app?->status ?? '-',
			$app?->expired_aplikasi?->format('d/m/Y') ?? '-',
			$app ? ($app->sisa_hari_aplikasi !== null ? $app->sisa_hari_aplikasi . ' hari' : '-') : '-',
			$app?->expired_domain?->format('d/m/Y') ?? '-',
			$app ? ($app->sisa_hari_domain !== null ? $app->sisa_hari_domain . ' hari' : '-') : '-',

			$client->created_at->format('d/m/Y'),
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
