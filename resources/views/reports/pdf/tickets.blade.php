<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tiket</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 9px; color: #111; margin: 0; }
        .header { border-bottom: 3px solid #2563EB; padding-bottom: 8px; margin-bottom: 12px; }
        .header h1 { margin: 0; font-size: 18px; color: #2563EB; }
        .header p { margin: 2px 0 0; color: #555; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        table th {
            background: #2563EB; color: #fff; text-align: left;
            padding: 6px 4px; font-size: 8px; text-transform: uppercase;
            border: 1px solid #2563EB;
        }
        table td { padding: 5px 4px; border: 1px solid #ddd; vertical-align: top; }
        table tr:nth-child(even) td { background: #f3f6ff; }
        .footer { margin-top: 14px; font-size: 9px; color: #666; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Tiket</h1>
        <p>Dicetak pada {{ $exportedAt->format('d/m/Y H:i') }} &nbsp;|&nbsp; Jumlah Tiket: {{ $tickets->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Tiket</th>
                <th>Judul</th>
                <th>Klien</th>
                <th>Kategori</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>Teknisi</th>
                <th>Dibuat Oleh</th>
                <th>SLA</th>
                <th>Dibuat</th>
                <th>Resolved</th>
                <th>Closed</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                @php
                    $ruleLog = $ticket->ruleLogs->first();
                    $slaStatus = $ruleLog?->status ?? '-';
                    $slaLabel = match ($slaStatus) {
                        'on_time' => 'On Time',
                        'warning' => 'Warning',
                        'breach' => 'Breach',
                        default => '-',
                    };
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->kode_ticket }}</td>
                    <td>{{ $ticket->judul }}</td>
                    <td>{{ $ticket->client?->nama ?? '-' }}</td>
                    <td>{{ $ticket->category?->nama ?? '-' }}</td>
                    <td>{{ ucfirst($ticket->priority) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</td>
                    <td>{{ $ticket->assignedTo?->name ?? '-' }}</td>
                    <td>{{ $ticket->createdBy?->name ?? '-' }}</td>
                    <td>{{ $slaLabel }}</td>
                    <td>{{ $ticket->created_at?->format('d/m/Y H:i') }}</td>
                    <td>{{ $ticket->resolved_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $ticket->closed_at?->format('d/m/Y H:i') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="13" style="text-align:center; padding:14px;">Tidak ada data tiket.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dibuat menggunakan sistem Ticketing Smart</div>
</body>
</html>
