@extends('layouts.app')

@section('title', 'Detail Client')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <a href="{{ route('clients.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Client</h1>
        </div>
        <div class="flex items-center gap-3 text-sm">
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $client->kode_client }}</span>
            <span class="font-semibold text-gray-900 dark:text-white">{{ $client->nama }}</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- ── SECTION 1: Informasi Utama ── --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Client</h2>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 uppercase mb-1">
                            Produk
                        </label>

                        @php
                            $product = $client->app?->product;
                        @endphp

                        @if($product)
                            <span class="inline-flex px-3 py-1 rounded-full text-sm
                                @switch($product->kode)
                                    @case('EDL')
                                        bg-violet-100 text-violet-700
                                        @break

                                    @case('CBT')
                                        bg-green-100 text-green-700
                                        @break

                                    @case('KP')
                                        bg-blue-100 text-blue-700
                                        @break

                                    @default
                                        bg-gray-100 text-gray-700
                                @endswitch
                            ">
                                {{ $product->nama }}
                            </span>
                        @else
                            —
                        @endif
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 uppercase mb-1">
                            Tipe Client
                        </label>

                        <span class="text-sm font-medium">
                            {{ $client->clientType?->nama }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-xs text-gray-500 uppercase mb-1">
                            PIC Internal
                        </label>

                        {{ $client->picTim?->name }}
                    </div>

                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tipe</label>
                    <span class="inline-flex px-2.5 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        {{ $client->clientType?->nama }}
                    </span>
                </div>
            </div>
        </div>

        {{-- ── SECTION 2: Status & Expired ── --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Status Aktif</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Status</label>
                    @php
                        $appStatus = $client->app->status ?? 'inactive';
                        $statusMap = [
                            'active'   => ['Aktif', 'text-green-800 bg-green-100', 'bg-green-500'],
                            'expired'  => ['Expired', 'text-red-800 bg-red-100', 'bg-red-500'],
                        ];
                        [$label, $badgeClass, $dotClass] = $statusMap[$appStatus] ?? $statusMap['expired'];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-sm font-medium {{ $badgeClass }}">
                        <span class="w-2 h-2 rounded-full {{ $dotClass }}"></span>
                        {{ $label }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Jumlah Siswa</label>
                        <span class="font-mono text-lg font-bold text-gray-900 dark:text-white">{{ $client->app->jumsis ? number_format($client->app->jumsis, 0, ',', '.') : 0 }}</span>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Server</label>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->app->server?->nama ?? '—' }}</span>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Aktivasi App</label>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $client->app->aktivasi_aplikasi?->format('d M Y') ?? '—' }}</span>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Expired App</label>
                        @if($client->app?->expired_aplikasi)
                            @php $sisaApp = $client->sisa_hari_aplikasi @endphp
                            <div class="text-sm {{ $sisaApp < 0 ? 'text-red-600 font-medium' : ($sisaApp <= 30 ? 'text-amber-600 font-medium' : 'text-gray-900 dark:text-white') }}">
                                {{ $client->app->expired_aplikasi->format('d M Y') }}
                                <span class="ml-1 text-xs">({{ $sisaApp >= 0 ? $sisaApp.' lagi' : 'expired' }})</span>
                            </div>
                        @else
                            <span class="text-sm text-gray-500">—</span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Expired Domain</label>
                        @if($client->app?->expired_domain)
                            @php $sisaDom = $client->sisa_hari_domain @endphp
                            <div class="text-sm {{ $sisaDom < 0 ? 'text-red-600 font-medium' : ($sisaDom <= 30 ? 'text-amber-600 font-medium' : 'text-gray-900 dark:text-white') }}">
                                {{ $client->app->expired_domain->format('d M Y') }}
                                <span class="ml-1 text-xs">({{ $sisaDom >= 0 ? $sisaDom.' lagi' : 'expired' }})</span>
                            </div>
                        @else
                            <span class="text-sm text-gray-500">—</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- ── SECTION 3: Fitur ── --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs lg:col-span-2">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-900/30">
                    <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Fitur Aktif ({{ $client->app->features->count() ?? 0 }})</h2>
            </div>

            @if($client->app?->features && $client->app->features->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($client->app->features as $feature)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border">
                            <h4 class="font-medium text-sm text-gray-900 dark:text-white mb-1">{{ $feature->nama_fitur }}</h4>
                            <span class="inline-flex px-2 py-0.5 text-xs bg-gray-100 text-gray-700 rounded-full">{{ $feature->kode }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-4.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 002.586 13H2"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Tidak ada fitur aktif</h3>
                    <p class="text-sm text-gray-500">Client ini belum memiliki fitur yang diaktifkan.</p>
                </div>
            @endif
        </div>

        {{-- ── SECTION 4: Informasi Tambahan ── --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 lg:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Tambahan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">URL Aplikasi</label>
                    @if($client->app->url_aplikasi)
                        <a href="{{ $client->app->url_aplikasi }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 truncate max-w-md">
                            {{ $client->app->url_aplikasi }}
                        </a>
                    @else
                        <span class="text-sm text-gray-500">—</span>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Kode ExaMol</label>
                    <span class="font-mono text-sm text-gray-900 dark:text-white">{{ $client->app->kode_examol ?? '—' }}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Link Presensi</label>
                    @if($client->app->link_presensi)
                        <a href="{{ $client->app->link_presensi }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                            Presensi
                        </a>
                    @else
                        <span class="text-sm text-gray-500">—</span>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Akun Login</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->app->accounts()->count() }}</span>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Catatan</label>
                    @if($client->app->catatan)
                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">{{ $client->app->catatan }}</p>
                    @else
                        <p class="text-sm text-gray-500 italic">Tidak ada catatan</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

{{-- ── SECTION 5: Kontrak ── --}}
    @php $contract = $client->contracts->first(); @endphp
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6 shadow-xs">
        <div class="flex items-center gap-2 mb-5">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Kontrak</h2>
        </div>

        @if($contract)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Nomor Kontrak</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $contract->nomor_kontrak ?? '—' }}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal Mulai</label>
                    <span class="text-sm text-gray-900 dark:text-white">{{ $contract->tanggal_mulai ? \Carbon\Carbon::parse($contract->tanggal_mulai)->format('d M Y') : '—' }}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tanggal Berakhir</label>
                    <span class="text-sm text-gray-900 dark:text-white">{{ $contract->tanggal_berakhir ? \Carbon\Carbon::parse($contract->tanggal_berakhir)->format('d M Y') : '—' }}</span>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">File Kontrak</label>
                    @if($contract->file)
                        <a href="{{ asset('storage/'.$contract->file) }}" target="_blank"
                           class="inline-flex items-center gap-2 text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Lihat File Kontrak
                        </a>
                    @else
                        <span class="text-sm text-gray-500">—</span>
                    @endif
                </div>
            </div>
        @else
            <p class="text-sm text-gray-500 italic">Belum ada data kontrak untuk client ini.</p>
        @endif
    </div>

    {{-- ── Action Buttons ── --}}
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('clients.index') }}"
           class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition">
            ← Kembali ke Daftar
        </a>
        <a href="{{ route('clients.edit', $client) }}"
           class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Client
        </a>
    </div>

</div>
@endsection
