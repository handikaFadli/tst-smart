@extends('layouts.app')

@section('title', 'Monitoring SLA')

@section('content')
<main>

    <div class="pt-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Monitoring SLA
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Pantau status SLA seluruh tiket aktif.</p>
    </div>

    {{-- ─── CARD STATISTIK SLA ─── --}}
    <div class="grid grid-cols-1 gap-4 pt-4 mb-5 sm:grid-cols-2 xl:grid-cols-5">

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Total Tiket Aktif
            </div>
            <div class="mt-2 text-2xl font-bold text-gray-800">
                {{ $totalActive }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                On Time
            </div>
            <div class="mt-2 text-2xl font-bold text-green-600">
                {{ $onTime }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Warning
            </div>
            <div class="mt-2 text-2xl font-bold text-yellow-500">
                {{ $warning }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Breach
            </div>
            <div class="mt-2 text-2xl font-bold text-red-600">
                {{ $breach }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Compliance
            </div>
            <div class="mt-2 text-2xl font-bold text-blue-600">
                {{ $compliance }}%
            </div>
            {{-- Progress bar --}}
            <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                <div class="h-2 rounded-full {{ $compliance >= 90 ? 'bg-green-500' : ($compliance >= 70 ? 'bg-yellow-500' : 'bg-red-500') }}"
                     style="width: {{ $compliance }}%"></div>
            </div>
        </div>

    </div>

    {{-- ─── FILTER ─── --}}
    <div class="flex items-center justify-between gap-3">

        <div class="flex items-center gap-2">
            <button id="filter-status" data-dropdown-toggle="dropdown-status"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ $slaStatus ? 'ring-2 ring-blue-200' : '' }}">
                {{ $slaStatus ? ucfirst(str_replace('_', ' ', $slaStatus)) : 'Semua Status' }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="dropdown-status" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 dark:bg-gray-700">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                    <li><a href="{{ route('tickets.monitoring-sla') }}" class="block px-4 py-2 hover:bg-gray-100 {{ !$slaStatus ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Semua</a></li>
                    <li><a href="{{ route('tickets.monitoring-sla', ['sla_status' => 'on_time']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ $slaStatus === 'on_time' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">On Time</a></li>
                    <li><a href="{{ route('tickets.monitoring-sla', ['sla_status' => 'warning']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ $slaStatus === 'warning' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Warning</a></li>
                    <li><a href="{{ route('tickets.monitoring-sla', ['sla_status' => 'breach']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ $slaStatus === 'breach' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Breach</a></li>
                </ul>
            </div>

            {{-- Tombol Download Excel --}}
            <a href="{{ route('tickets.monitoring-sla.export', $slaStatus ? ['sla_status' => $slaStatus] : []) }}"
               class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download
            </a>
        </div>

    </div>

    {{-- ─── TABLE ─── --}}
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft">
                    <table class="w-full text-sm text-left" id="data-table">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Tiket
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Klien
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Response SLA
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Resolution SLA
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Remaining
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-500 uppercase">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            @php
                                $ruleLog = $ticket->ruleLogs->first();
                                $now = \Carbon\Carbon::now();

                                // Response SLA
                                $responseDeadline = $ruleLog?->response_deadline;
                                $responseStatus = $ruleLog?->first_response_at
                                    ? ($ruleLog->first_response_at->greaterThan($responseDeadline) ? 'breach' : 'on_time')
                                    : ($responseDeadline && $now->greaterThan($responseDeadline) ? 'breach'
                                        : ($responseDeadline && $now->diffInSeconds($responseDeadline, false) > 0 && ($now->diffInSeconds($responseDeadline) / max(1, $responseDeadline->diffInSeconds($ticket->created_at))) <= 0.2 ? 'warning' : 'on_time'));

                                // Resolution SLA
                                $resolutionDeadline = $ruleLog?->resolution_deadline;
                                $resolutionStatus = $ruleLog?->resolved_at
                                    ? ($ruleLog->resolved_at->greaterThan($resolutionDeadline) ? 'breach' : 'on_time')
                                    : ($resolutionDeadline && $now->greaterThan($resolutionDeadline) ? 'breach'
                                        : ($resolutionDeadline && $now->diffInSeconds($resolutionDeadline, false) > 0 && ($now->diffInSeconds($resolutionDeadline) / max(1, $resolutionDeadline->diffInSeconds($ticket->created_at))) <= 0.2 ? 'warning' : 'on_time'));

                                // Overall status from ruleLog
                                $overallStatus = $ruleLog?->status ?? 'on_time';

                                // Remaining time — use the nearest deadline still in the future
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
                                    if ($hours > 0) {
                                        $remainingText = $hours . 'j ' . $minutes . 'm';
                                    } else {
                                        $remainingText = $minutes . 'm';
                                    }
                                }

                                $responseLabel = match($responseStatus) { 'on_time' => 'On Time', 'warning' => 'Warning', 'breach' => 'Breach', default => '-' };
                                $responseColor = match($responseStatus) { 'on_time' => 'text-green-700 bg-green-100', 'warning' => 'text-yellow-700 bg-yellow-100', 'breach' => 'text-red-700 bg-red-100', default => 'text-gray-700 bg-gray-100' };
                                $resolutionLabel = match($resolutionStatus) { 'on_time' => 'On Time', 'warning' => 'Warning', 'breach' => 'Breach', default => '-' };
                                $resolutionColor = match($resolutionStatus) { 'on_time' => 'text-green-700 bg-green-100', 'warning' => 'text-yellow-700 bg-yellow-100', 'breach' => 'text-red-700 bg-red-100', default => 'text-gray-700 bg-gray-100' };
                                $statusLabel = match($overallStatus) { 'on_time' => 'On Time', 'warning' => 'Warning', 'breach' => 'Breach', default => 'On Time' };
                                $statusColor = match($overallStatus) { 'on_time' => 'text-green-700 bg-green-100', 'warning' => 'text-yellow-700 bg-yellow-100', 'breach' => 'text-red-700 bg-red-100', default => 'text-green-700 bg-green-100' };
                            @endphp
                            <tr class="border-t border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-blue-600">
                                        #{{ $ticket->kode_ticket }}
                                    </div>
                                    <div class="mt-1 text-xs text-gray-400 line-clamp-1 max-w-[200px]">
                                        {{ $ticket->judul }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-700 dark:text-gray-200">
                                        {{ $ticket->client?->nama ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full {{ $responseColor }}">
                                        {{ $responseLabel }}
                                    </span>
                                    @if ($responseDeadline)
                                        <div class="mt-1 text-xs text-gray-400">
                                            {{ $responseDeadline->format('d M H:i') }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full {{ $resolutionColor }}">
                                        {{ $resolutionLabel }}
                                    </span>
                                    @if ($resolutionDeadline)
                                        <div class="mt-1 text-xs text-gray-400">
                                            {{ $resolutionDeadline->format('d M H:i') }}
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium {{ $remainingSeconds !== null && $remainingSeconds < 3600 ? 'text-red-600' : 'text-gray-700 dark:text-gray-200' }}">
                                        {{ $remainingText }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium rounded-full {{ $statusColor }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('tickets.show', $ticket->id) }}"
                                           class="inline-flex items-center justify-center w-9 h-9 text-blue-600 transition border border-blue-200 rounded-lg hover:bg-blue-50">
                                            👁
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-14 h-14 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                        </svg>
                                        <h3 class="mt-3 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                            Tidak ada data SLA
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-400">
                                            Belum ada tiket dengan data SLA yang tersedia
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ========================= --}}
    {{-- PERFORMA TEKNISI --}}
    {{-- ========================= --}}
    <div class="mt-5 overflow-hidden bg-white shadow rounded-2xl">

        <div class="flex items-center justify-between px-6 py-4 border-b">
            <div>
                <h2 class="text-lg font-semibold text-gray-800">
                    Performa Teknisi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Statistik penyelesaian tiket setiap teknisi.
                </p>
            </div>
        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full">

                <thead class="bg-gray-50">

                    <tr class="text-xs font-semibold tracking-wider text-gray-500 uppercase">

                        <th class="px-6 py-4 text-left">
                            Teknisi
                        </th>

                        <th class="px-4 py-4 text-center">
                            Total
                        </th>

                        <th class="px-4 py-4 text-center">
                            Solved
                        </th>

                        <th class="px-4 py-4 text-center">
                            Open
                        </th>

                        <th class="px-4 py-4 text-center">
                            Breach
                        </th>

                        <th class="px-6 py-4">
                            Success Rate
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-100">

                @foreach($technicianPerformance as $index => $tech)

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex items-center justify-center w-10 h-10 font-bold text-blue-600 bg-blue-100 rounded-full">

                                    {{ $index+1 }}

                                </div>

                                <div>

                                    <div class="font-semibold text-gray-800">
                                        {{ $tech->name }}
                                    </div>

                                    <div class="text-xs text-gray-400">
                                        Teknisi Support
                                    </div>

                                </div>

                            </div>

                        </td>

                        <td class="text-center">

                            <span class="font-semibold text-gray-700">
                                {{ $tech->total_ticket }}
                            </span>

                        </td>

                        <td class="text-center">

                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">

                                {{ $tech->solved_ticket }}

                            </span>

                        </td>

                        <td class="text-center">

                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold text-yellow-700 bg-yellow-100 rounded-full">

                                {{ $tech->open_ticket }}

                            </span>

                        </td>

                        <td class="text-center">

                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">

                                {{ $tech->breach_ticket }}

                            </span>

                        </td>

                        <td class="px-6 py-4">

                            <div class="flex items-center gap-3">

                                <div class="w-full h-2 bg-gray-200 rounded-full">

                                    <div
                                        class="h-2 rounded-full
                                        {{ $tech->success_rate >= 90 ? 'bg-green-500'
                                        : ($tech->success_rate >=70 ? 'bg-yellow-500' : 'bg-red-500') }}"
                                        style="width: {{ $tech->success_rate }}%">
                                    </div>

                                </div>

                                <div class="w-12 text-sm font-semibold text-right">
                                    {{ $tech->success_rate }}%
                                </div>

                            </div>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</main>
@endsection

