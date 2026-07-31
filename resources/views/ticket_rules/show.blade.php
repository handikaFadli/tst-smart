@extends('layouts.app')

@section('title', 'Detail SLA Rule')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail SLA Rule</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Informasi lengkap aturan SLA.</p>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

        <div class="xl:col-span-9 space-y-5">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xs">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">{{ $ticketRule->nama_rule }}</h2>
                            <p class="text-xs text-gray-400">ID: {{ $ticketRule->id }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Kategori</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $ticketRule->category?->nama ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Priority</p>
                            @php
                                $priorityColor = match ($ticketRule->priority) {
                                    'high' => 'bg-red-100 text-red-800',
                                    'medium' => 'bg-yellow-100 text-yellow-800',
                                    'low' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded {{ $priorityColor }}">
                                {{ ucfirst($ticketRule->priority) }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Response Time</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $ticketRule->response_time }} menit</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Resolution Time</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $ticketRule->resolution_time }} menit</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Status</p>
                            @if ($ticketRule->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded">
                                    Nonaktif
                                </span>
                            @endif
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Dibuat</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $ticketRule->created_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500 mb-1">Diperbarui</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $ticketRule->updated_at?->format('d M Y H:i') ?? '-' }}</p>
                        </div>

                    </div>

                    <div class="flex items-center gap-3 mt-6">
                        <a href="{{ route('ticket-rules.edit', $ticketRule->id) }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-yellow-500 rounded-xl hover:bg-yellow-600 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                            Edit
                        </a>

                        <a href="{{ route('ticket-rules.index') }}"
                           class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-3 space-y-5">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xs">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Ringkasan</h3>
                <div class="text-sm text-gray-600 space-y-3">
                    <div class="border-l-4 border-blue-400 pl-3">
                        <p class="text-xs text-gray-500">Response Deadline</p>
                        <p class="font-semibold text-gray-900">{{ $ticketRule->response_time }} menit</p>
                    </div>
                    <div class="border-l-4 border-purple-400 pl-3">
                        <p class="text-xs text-gray-500">Resolution Deadline</p>
                        <p class="font-semibold text-gray-900">{{ $ticketRule->resolution_time }} menit</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

