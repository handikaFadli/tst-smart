@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
<main>

    <div class="pt-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Laporan
        </h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Download data dalam format Excel atau PDF.</p>
    </div>

    {{-- ─── LAPORAN TIKET ─── --}}
    <div class="mt-6 overflow-hidden bg-white shadow rounded-2xl dark:bg-gray-800">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Laporan Tiket
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Data seluruh tiket support dengan filter status, kategori, dan prioritas.
                </p>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('reports.tickets.export') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Status Tiket</label>
                    <select name="status" class="px-3 py-2 text-sm border text-gray-600 border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="semua">Semua Status</option>
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Kategori</label>
                    <select name="category_id" class="px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="semua">Semua Kategori</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Prioritas</label>
                    <select name="priority" class="px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="semua">Semua Prioritas</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>
<div class="flex items-center gap-2">
                    <button type="submit" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Excel
                    </button>
                    <button type="submit" formaction="{{ route('reports.tickets.export-pdf') }}" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── LAPORAN SLA ─── --}}
    <div class="mt-6 overflow-hidden bg-white shadow rounded-2xl dark:bg-gray-800">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Laporan SLA
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Data monitoring SLA tiket dengan status response dan resolution.
                </p>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('reports.sla.export') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div>
                    <label class="block mb-1 text-xs font-medium text-gray-600 dark:text-gray-400">Status SLA</label>
                    <select name="sla_status" class="px-3 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                        <option value="">Semua Status</option>
                        <option value="on_time">On Time</option>
                        <option value="warning">Warning</option>
                        <option value="breach">Breach</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
<button type="submit" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Excel
                    </button>
                    <button type="submit" formaction="{{ route('reports.sla.export-pdf') }}" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── LAPORAN PERFORMA TEKNISI ─── --}}
    <div class="mt-6 overflow-hidden bg-white shadow rounded-2xl dark:bg-gray-800">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Laporan Performa Teknisi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Statistik penyelesaian tiket setiap teknisi support.
                </p>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('reports.technician.export') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex items-center gap-2">
<button type="submit" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Excel
                    </button>
                    <button type="submit" formaction="{{ route('reports.technician.export-pdf') }}" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ─── LAPORAN KLIEN ─── --}}
    <div class="mt-6 overflow-hidden bg-white shadow rounded-2xl dark:bg-gray-800">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-white">
                    Laporan Klien
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Data seluruh klien, aplikasi, domain, dan kontak PIC utama.
                </p>
            </div>
        </div>
        <div class="p-6">
            <form action="{{ route('reports.clients.export') }}" method="GET" class="flex flex-wrap items-end gap-4">
                <div class="flex items-center gap-2">
<button type="submit" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600 rounded-lg hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Download Excel
                    </button>
                    <button type="submit" formaction="{{ route('reports.clients.export-pdf') }}" data-download
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-red-600 border border-red-600 rounded-lg hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Download PDF
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>
@endsection
