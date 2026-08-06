<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan SLA</title>
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
        <h1>Laporan SLA Tiket</h1>
        <p>Dicetak pada {{ $exportedAt->format('d/m/Y H:i') }} &nbsp;|&nbsp; Jumlah Tiket: {{ $tickets->count() }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Judul</th>
                <th>Klien</th>
                <th>Prioritas</th>
                <th>Status</th>
                <th>SLA</th>
                <th>Resp. SLA</th>
                <th>Res. SLA</th>
                <th>Resp. Deadline</th>
                <th>Res. Deadline</th>
                <th>First Resp</th>
                <th>Resolved</th>
                <th>Sisa</th>
                <th>Teknisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tickets as $ticket)
                @php
                    $ruleLog = $ticket->ruleLogs->first();
                    $now = \Carbon\Carbon::now();

                    $responseDeadline = $ruleLog?->response_deadline;
                    $responseStatus = $ruleLog?->first_response_at
                        ? ($ruleLog->first_response_at->greaterThan($responseDeadline) ? 'Breach' : 'On Time')
                        : ($responseDeadline && $now->greaterThan($responseDeadline) ? 'Breach'
                            : ($responseDeadline && $now->diffInSeconds($responseDeadline, false) > 0
                                && ($now->diffInSeconds($responseDeadline) / max(1, $responseDeadline->diffInSeconds($ticket->created_at))) <= 0.2
                                ? 'Warning' : 'On Time'));

                    $resolutionDeadline = $ruleLog?->resolution_deadline;
                    $resolutionStatus = $ruleLog?->resolved_at
                        ? ($ruleLog->resolved_at->greaterThan($resolutionDeadline) ? 'Breach' : 'On Time')
                        : ($resolutionDeadline && $now->greaterThan($resolutionDeadline) ? 'Breach'
                            : ($resolutionDeadline && $now->diffInSeconds($resolutionDeadline, false) > 0
                                && ($now->diffInSeconds($resolutionDeadline) / max(1, $resolutionDeadline->diffInSeconds($ticket->created_at))) <= 0.2
                                ? 'Warning' : 'On Time'));

                    $overallStatus = $ruleLog?->status ?? 'on_time';
                    $statusLabel = match ($overallStatus) {
                        'on_time' => 'On Time',
                        'warning' => 'Warning',
                        'breach'  => 'Breach',
                        default   => 'On Time',
                    };

                    $remainingText = '-';
                    $remainingSeconds = null;
                    if ($responseDeadline && $now->lessThan($responseDeadline)) {
                        $remainingSeconds = $now->diffInSeconds($responseDeadline);
                    }
                    if ($resolutionDeadline && $now->lessThan($resolutionDeadline)) {
                        $resSecs = $now->diffInSeconds($resolutionDeadline);
                        if ($remainingSeconds === null || $resSecs < $remainingSeconds) {
                            $remainingSeconds = $resSecs;
                        }
                    }
                    if ($remainingSeconds !== null) {
                        $hours = floor($remainingSeconds / 3600);
                        $minutes = floor(($remainingSeconds % 3600) / 60);
                        $remainingText = $hours > 0 ? "{$hours}j {$minutes}m" : "{$minutes}m";
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $ticket->kode_ticket }}</td>
                    <td>{{ $ticket->judul }}</td>
                    <td>{{ $ticket->client?->nama ?? '-' }}</td>
                    <td>{{ ucfirst($ticket->priority) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $ticket->status)) }}</td>
                    <td>{{ $statusLabel }}</td>
                    <td>{{ $responseStatus }}</td>
                    <td>{{ $resolutionStatus }}</td>
                    <td>{{ $responseDeadline?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $resolutionDeadline?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $ruleLog?->first_response_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $ruleLog?->resolved_at?->format('d/m/Y H:i') ?? '-' }}</td>
                    <td>{{ $remainingText }}</td>
                    <td>{{ $ticket->assignedTo?->name ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="15" style="text-align:center; padding:14px;">Tidak ada data SLA.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dibuat menggunakan sistem Ticketing Smart</div>
</body>
</html>
