<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Performa Teknisi</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #111; margin: 0; }
        .header { border-bottom: 3px solid #2563EB; padding-bottom: 8px; margin-bottom: 12px; }
        .header h1 { margin: 0; font-size: 18px; color: #2563EB; }
        .header p { margin: 2px 0 0; color: #555; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        table th {
            background: #2563EB; color: #fff; text-align: left;
            padding: 6px 5px; font-size: 9px; text-transform: uppercase;
            border: 1px solid #2563EB;
        }
        table td { padding: 5px 5px; border: 1px solid #ddd; }
        table tr:nth-child(even) td { background: #f3f6ff; }
        .footer { margin-top: 14px; font-size: 9px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Performa Teknisi</h1>
        <p>Dicetak pada {{ $exportedAt->format('d/m/Y H:i') }} &nbsp;|&nbsp; Jumlah Teknisi: {{ $technicians->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Teknisi</th>
                <th>Role</th>
                <th>Total Tiket</th>
                <th>Solved</th>
                <th>Open</th>
                <th>Breach</th>
                <th>Success Rate (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($technicians as $tech)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $tech->name }}</td>
                    <td>{{ ucfirst($tech->role) }}</td>
                    <td>{{ $tech->total_ticket ?? 0 }}</td>
                    <td>{{ $tech->solved_ticket ?? 0 }}</td>
                    <td>{{ $tech->open_ticket ?? 0 }}</td>
                    <td>{{ $tech->breach_ticket ?? 0 }}</td>
                    <td>{{ $tech->success_rate }}</td>
                </tr>
            @empty
                <tr><td colspan="8" style="text-align:center; padding:14px;">Tidak ada data teknisi.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dibuat menggunakan sistem Ticketing Smart</div>
</body>
</html>
