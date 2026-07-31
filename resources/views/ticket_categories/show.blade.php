@extends('layouts.app')

@section('title', 'Ticket Category Detail')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $ticketCategory->nama }}</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Detail ticket category.</p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('ticket-categories.edit', $ticketCategory) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-yellow-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-yellow-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z" />
                </svg>
                Edit
            </a>

            <a href="{{ route('ticket-categories.index') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 border border-gray-200 hover:bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 xl:grid-cols-12 gap-6">
        <div class="xl:col-span-9 space-y-5">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xs">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <div class="text-sm font-medium text-gray-700">Deskripsi</div>
                        <div class="mt-2 text-sm text-gray-800">{{ $ticketCategory->deskripsi ?? '-' }}</div>
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <div class="text-sm font-medium text-gray-700">Status</div>
                                <div class="mt-1 text-xs text-gray-500">Aktif atau tidak untuk digunakan ticket</div>
                            </div>

                            @if($ticketCategory->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full border border-green-200 bg-green-50 text-green-700 text-xs font-semibold">Active</span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full border border-gray-200 bg-gray-50 text-gray-700 text-xs font-semibold">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-3 space-y-5">
            <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xs">
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Metadata</h3>
                <div class="text-sm text-gray-600 space-y-2">
                    <div>
                        <span class="text-gray-500">ID:</span>
                        <span class="font-semibold text-gray-900">{{ $ticketCategory->id }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Dibuat:</span>
                        <span class="font-semibold text-gray-900">{{ $ticketCategory->created_at?->format('d M Y H:i') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Update:</span>
                        <span class="font-semibold text-gray-900">{{ $ticketCategory->updated_at?->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

