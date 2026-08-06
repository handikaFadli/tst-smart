<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Klien</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 8px; color: #111; margin: 0; }
        .header { border-bottom: 3px solid #2563EB; padding-bottom: 8px; margin-bottom: 12px; }
        .header h1 { margin: 0; font-size: 18px; color: #2563EB; }
        .header p { margin: 2px 0 0; color: #555; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        table th {
            background: #2563EB; color: #fff; text-align: left;
            padding: 5px 3px; font-size: 7px; text-transform: uppercase;
            border: 1px solid #2563EB;
        }
        table td { padding: 4px 3px; border: 1px solid #ddd; vertical-align: top; }
        table tr:nth-child(even) td { background: #f3f6ff; }
        .footer { margin-top: 14px; font-size: 9px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Klien</h1>
        <p>Dicetak pada {{ $exportedAt->format('d/m/Y H:i') }} &nbsp;|&nbsp; Jumlah Klien: {{ $clients->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Klien</th>
                <th>Tipe</th>
                <th>PIC Tim</th>
                <th>Produk</th>
                <th>Server</th>
                <th>URL Aplikasi</th>
                <th>Status</th>
                <th>Exp. Aplikasi</th>
                <th>Sisa Hari Aplikasi</th>
                <th>Exp. Domain</th>
                <th>Sisa Hari Domain</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
                @php $app = $client->app; @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $client->kode }}</td>
                    <td>{{ $client->nama }}</td>
                    <td>{{ $client->clientType?->nama ?? '-' }}</td>
                    <td>{{ $client->picTim?->name ?? '-' }}</td>
                    <td>{{ $app?->product?->nama ?? '-' }}</td>
                    <td>{{ $app?->server?->nama ?? '-' }}</td>
                    <td>{{ $app?->url_aplikasi ?? '-' }}</td>
                    <td>{{ $app?->status ?? '-' }}</td>
                    <td>{{ $app?->expired_aplikasi?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $app ? ($app->sisa_hari_aplikasi !== null ? $app->sisa_hari_aplikasi . ' hari' : '-') : '-' }}</td>
                    <td>{{ $app?->expired_domain?->format('d/m/Y') ?? '-' }}</td>
                    <td>{{ $app ? ($app->sisa_hari_domain !== null ? $app->sisa_hari_domain . ' hari' : '-') : '-' }}</td>
                    <td>{{ $client->created_at->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="14" style="text-align:center; padding:14px;">Tidak ada data klien.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dibuat menggunakan sistem Ticketing Smart</div>
</body>
</html>
