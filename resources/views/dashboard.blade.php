@extends('layouts.app')

@section('title', 'Dashboard - Helpdesk')

@section('content')
<div class="px-4 pt-6">
    {{-- ============================================================ --}}
    {{-- ROW 1: Statistik Tiket (6 cards)                             --}}
    {{-- ============================================================ --}}
    <div class="grid gap-4 mb-4 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
        {{-- Total --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Total Tiket</p>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $ticketStats->total ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Open --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Open</p>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $ticketStats->open ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- In Progress --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">In Progress</p>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $ticketStats->in_progress ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-yellow-100 rounded-full dark:bg-yellow-900">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Pending --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Pending</p>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $ticketStats->pending ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-orange-100 rounded-full dark:bg-orange-900">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Resolved --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Resolved</p>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $ticketStats->resolved ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-green-100 rounded-full dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- Closed --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-normal text-gray-500 dark:text-gray-400">Closed</p>
                    <span class="text-2xl font-bold leading-none text-gray-900 sm:text-3xl dark:text-white">{{ $ticketStats->closed ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-center w-12 h-12 bg-gray-200 rounded-full dark:bg-gray-700">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ROW 2: SLA MONITORING                                        --}}
    {{-- ============================================================ --}}
    <div class="mb-4">
        <h3 class="mb-3 text-lg font-semibold text-gray-900 dark:text-white">Monitoring SLA</h3>
        <div class="grid gap-4 sm:grid-cols-3">
            {{-- On Time --}}
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-base font-semibold text-green-600 dark:text-green-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            On Time
                        </span>
                    </h4>
                    <span class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $slaStats->on_time ?? 0 }}</span>
                </div>
                @php $slaTotal = ($slaStats->on_time ?? 0) + ($slaStats->warning ?? 0) + ($slaStats->breach ?? 0); @endphp
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $slaTotal > 0 ? round(($slaStats->on_time ?? 0) / $slaTotal * 100) : 0 }}%"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $slaTotal > 0 ? round(($slaStats->on_time ?? 0) / $slaTotal * 100) : 0 }}% dari total</p>
            </div>

            {{-- Warning --}}
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-base font-semibold text-yellow-600 dark:text-yellow-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            Warning
                        </span>
                    </h4>
                    <span class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $slaStats->warning ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-yellow-500 h-2.5 rounded-full" style="width: {{ $slaTotal > 0 ? round(($slaStats->warning ?? 0) / $slaTotal * 100) : 0 }}%"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $slaTotal > 0 ? round(($slaStats->warning ?? 0) / $slaTotal * 100) : 0 }}% dari total</p>
            </div>

            {{-- Breach --}}
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-base font-semibold text-red-600 dark:text-red-400">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                            Breach
                        </span>
                    </h4>
                    <span class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $slaStats->breach ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-red-500 h-2.5 rounded-full" style="width: {{ $slaTotal > 0 ? round(($slaStats->breach ?? 0) / $slaTotal * 100) : 0 }}%"></div>
                </div>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $slaTotal > 0 ? round(($slaStats->breach ?? 0) / $slaTotal * 100) : 0 }}% dari total</p>
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ROW 3: Grafik Tren Bulanan + Grafik Kategori/Prioritas       --}}
    {{-- ============================================================ --}}
    <div class="grid gap-4 mb-4 xl:grid-cols-3">
        {{-- Grafik Tren Bulanan (span 2 kolom) --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Tren Tiket per Bulan</h3>
            <div id="monthly-trend-chart"></div>
        </div>

        {{-- Grafik Tiket by Kategori --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Tiket berdasarkan Kategori</h3>
            <div id="category-chart"></div>
            <div class="mt-4 space-y-2">
                @forelse($ticketsByCategory as $cat)
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400 truncate">{{ $cat->nama }}</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $cat->total }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                    @php $maxCat = $ticketsByCategory->max('total') ?: 1; @endphp
                    <div class="bg-primary-600 h-1.5 rounded-full" style="width: {{ ($cat->total / $maxCat) * 100 }}%"></div>
                </div>
                @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ============================================================ --}}
    {{-- ROW 4: Prioritas Chart + Team Performance + Top Clients      --}}
    {{-- ============================================================ --}}
    <div class="grid gap-4 mb-4 xl:grid-cols-3">
        {{-- Grafik Prioritas --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Tiket berdasarkan Prioritas</h3>
            <div id="priority-chart"></div>
            <div class="mt-4 space-y-2">
                @php
                    $priorityLabels = ['high' => 'High', 'medium' => 'Medium', 'low' => 'Low'];
                    $priorityColors = ['high' => 'text-red-600', 'medium' => 'text-yellow-600', 'low' => 'text-green-600'];
                    $priorityBgColors = ['high' => 'bg-red-500', 'medium' => 'bg-yellow-500', 'low' => 'bg-green-500'];
                    $maxPrio = max($ticketsByPriority->toArray() ?: [1]);
                @endphp
                @forelse($ticketsByPriority as $prio => $count)
                <div class="flex items-center justify-between text-sm">
                    <span class="{{ $priorityColors[$prio] ?? 'text-gray-600' }} font-medium">{{ $priorityLabels[$prio] ?? ucfirst($prio) }}</span>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $count }}</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-1.5 dark:bg-gray-700">
                    <div class="{{ $priorityBgColors[$prio] ?? 'bg-gray-500' }} h-1.5 rounded-full" style="width: {{ ($count / $maxPrio) * 100 }}%"></div>
                </div>
                @empty
                <p class="text-sm text-gray-500 dark:text-gray-400">Belum ada data</p>
                @endforelse
            </div>
        </div>

        {{-- Team Performance --}}
        <div class="overflow-hidden bg-white border border-gray-200 shadow-sm rounded-2xl">
            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">
                    Team Performance
                </h2>

                {{-- <p class="mt-1 text-sm text-gray-500">
                    Total tiket yang berhasil diselesaikan oleh setiap teknisi.
                </p> --}}
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50">
                        <tr class="text-xs font-semibold tracking-wider text-gray-500 uppercase">
                            <th class="px-6 py-4 text-left">
                                Teknisi
                            </th>

                            <th class="px-6 py-4 text-center">
                                Total Tiket
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse($teamPerformance as $tech)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-10 h-10 font-semibold text-blue-700 bg-blue-100 rounded-full">
                                            {{ strtoupper(substr($tech->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-semibold text-gray-900">
                                                {{ $tech->name }}
                                            </p>

                                            <p class="text-xs text-gray-400">
                                                Teknisi Support
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex min-w-12 items-center justify-center rounded-full bg-green-100 px-4 py-1.5 text-sm font-bold text-green-700">
                                        {{ $tech->total_closed }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-10 text-center text-gray-500">
                                    Belum ada data teknisi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Clients --}}
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Top Client (Terbanyak Tiket)</h3>
            <ol class="space-y-3">
                @forelse($topClients as $index => $client)
                <li class="flex items-center space-x-3">
                    <span class="flex items-center justify-center w-7 h-7 text-xs font-bold text-white rounded-full {{ $index < 3 ? 'bg-primary-600' : 'bg-gray-400 dark:bg-gray-600' }}">
                        {{ $index + 1 }}
                    </span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">{{ $client->nama }}</p>
                        <p class="text-xs text-gray-500 truncate dark:text-gray-400">{{ $client->kode }}</p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-100 text-primary-800 dark:bg-primary-900 dark:text-primary-300">
                        {{ $client->total_tickets }} tiket
                    </span>
                </li>
                @empty
                <li class="text-sm text-gray-500 dark:text-gray-400">Belum ada data</li>
                @endforelse
            </ol>
        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- Data untuk charts --}}
<script>
    window._chartData = {
        months: @json(array_column($months, 'label')),
        monthlyTotals: @json(array_column($months, 'total')),
        categories: @json($ticketsByCategory->pluck('nama')),
        categoryTotals: @json($ticketsByCategory->pluck('total')),
        priorities: @json($ticketsByPriority->keys()),
        priorityTotals: @json($ticketsByPriority->values()),
        priorityLabels: { high: 'High', medium: 'Medium', low: 'Low' },
    };
</script>
@endpush

