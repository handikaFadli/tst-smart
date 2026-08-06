@extends('layouts.app')

@section('title', 'Daftar Klien')

@section('content')
<main>
    <div class="pt-5 flex items-center justify-between mb-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Klien</h1>
        <a href="{{ route('clients.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </a>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
        <div class="flex items-center gap-3">
            <div class="relative inline-block">
                <button id="perPageButton"
                    data-dropdown-toggle="perPageDropdown"
                    class="flex items-center justify-between w-18 h-11 px-4
                        bg-white border border-gray-200 rounded-xl shadow-sm
                        text-sm font-medium text-gray-700
                        hover:border-primary-400 hover:shadow-md
                        focus:ring-4 focus:ring-primary-100
                        transition-all cursor-pointer">

                    <span>{{ request('per_page',10) }} </span>

                    <svg class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"/>
                    </svg>

                </button>

                <div id="perPageDropdown" class="hidden z-20 w-36 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden">
                    @foreach([10,25,50,100] as $size)
                        <button
                            onclick="updatePerPage({{ $size }})"
                            class="w-full px-4 py-2.5 text-left text-sm
                                hover:bg-primary-50
                                hover:text-primary-600
                                transition cursor-pointer
                                {{ request('per_page',10)==$size ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">
                            {{ $size }} 
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="relative inline-block">

                <button
                    id="statusButton"
                    data-dropdown-toggle="statusDropdown"
                    class="flex items-center justify-between min-w-37 h-11 px-4
                        bg-white border border-gray-200 rounded-xl shadow-sm
                        text-sm font-medium text-gray-700
                        hover:border-primary-400 hover:shadow-md
                        focus:ring-4 focus:ring-primary-100
                        transition-all cursor-pointer">

                    <span>
                        {{ request('status') ? ucfirst(request('status')) : 'Semua Status' }}
                    </span>

                    <svg class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"/>

                    </svg>

                </button>

                <div id="statusDropdown"
                    class="hidden z-20 w-40 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden cursor-pointer">

                    @php
                        $statuses = [
                            '' => 'Semua Status',
                            'active' => 'Aktif',
                            'expired' => 'Expired',
                        ];
                    @endphp

                    @foreach($statuses as $value => $label)

                        <button
                            onclick="filterStatus('{{ $value }}')"
                            class="w-full px-4 py-2.5 flex items-center justify-between
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                {{ request('status') == $value ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">

                            <span>{{ $label }}</span>

                            

                        </button>

                    @endforeach

                </div>

            </div>
            <div class="relative inline-block">

                <button
                    id="tipeButton"
                    data-dropdown-toggle="tipeDropdown"
                    class="flex items-center justify-between min-w-37 h-11 px-4
                        bg-white border border-gray-200 rounded-xl shadow-sm
                        text-sm font-medium text-gray-700
                        hover:border-primary-400 hover:shadow-md
                        focus:ring-4 focus:ring-primary-100
                        transition-all cursor-pointer">

                    <span>
                        {{ optional($selectedClientType)->nama ?: 'Semua Tipe' }}
                    </span>

                    <svg class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"/>

                    </svg>

                </button>

                <div id="tipeDropdown"
                    class="hidden z-20 w-40 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden cursor-pointer">
                    <button
                        onclick="filterTipe('')"
                        class="w-full px-4 py-2.5 flex items-center justify-between
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                ">
                        Semua Tipe
                    </button>

                    @foreach($clientTypes as $type)

                        <button
                            onclick="filterTipe('{{ $type->id }}')"
                            class="w-full px-4 py-2.5 flex items-center justify-between
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                {{ request('tipe') == $type->id ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">

                            <span>{{ $type->nama }}</span>

                        </button>

                    @endforeach

                </div>

            </div>
            <div class="relative inline-block">

                <button
                    id="jenisButton"
                    data-dropdown-toggle="jenisDropdown"
                    class="flex items-center justify-between min-w-37 h-11 px-4
                        bg-white border border-gray-200 rounded-xl shadow-sm
                        text-sm font-medium text-gray-700
                        hover:border-primary-400 hover:shadow-md
                        focus:ring-4 focus:ring-primary-100
                        transition-all cursor-pointer">

                    <span>
                        {{ optional($selectedProduct)->nama ?: 'Semua Jenis' }}
                    </span>

                    <svg class="w-4 h-4 text-gray-400"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"/>

                    </svg>

                </button>

                <div id="jenisDropdown"
                    class="hidden z-20 w-40 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden cursor-pointer">

                    <button
                        onclick="filterJenis('')"
                        class="w-full px-4 py-2.5 flex items-center justify-between
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer">
                        Semua Jenis
                        @if(request('jenis') == $value)
                                <svg class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"/>

                                </svg>
                            @endif
                    </button>

                    @foreach($products as $product)

                        <button
                             onclick="filterJenis('{{ $product->id }}')"
                            class="w-full px-4 py-2.5 flex items-center justify-between
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                {{ request('jenis') == $product->id ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">

                            <span>{{ $product->nama }}</span>

                        </button>

                    @endforeach

                </div>

            </div>
        </div>

        <div class="relative flex w-96">

            <div class="relative flex-1">

                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15Z"/>
                </svg>

                <input
                    id="search-input"
                    value="{{ request('search') }}"
                    placeholder="Cari..."
                    class="w-full h-11 rounded-l-xl border border-gray-300 border-r-0
                        pl-11 pr-4 text-sm
                        focus:outline-none
                        focus:border-primary-500
                        focus:ring-4 focus:ring-primary-100
                        transition-all duration-200"
                    onkeypress="if(event.key==='Enter') searchTable()">

            </div>

            <button
                onclick="searchTable()"
                class="h-11 px-6 rounded-r-xl
                    bg-primary-600 hover:bg-primary-700
                    border border-primary-600
                    text-white text-sm font-medium
                    transition-all duration-200 cursor-pointer">

                Cari

            </button>

        </div>

    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft ">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-200 dark:bg-gray-700">
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider min-w-25">Client</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Siswa</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Fitur</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider ">AktiVasi</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider min-w-25">Kontrak</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider min-w-25">Expired</th>
                                <th class="px-4 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider">Status</th>
                                 @if ($user->isAdmin())
                                <th class="pr-2 py-3 text-xs font-bold text-gray-600 uppercase tracking-wider text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $i => $client)
                            @php
                                $app = $client->app;

                                $statusMap = [
                                    'active'   => ['bg-green-100 text-green-700', 'bg-green-500', 'Aktif'],
                                    'expired'  => ['bg-red-100 text-red-700', 'bg-red-500', 'Expired'],
                                    
                                ];

                                [$badgeClass, $dotClass, $label] =
                                    $statusMap[$app?->status ?? 'expired'];
                            @endphp

                            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                <td class="px-4 py-3 text-xs text-gray-400">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">
                                        {{ $client->nama }}
                                    </div>

                                    <div class="flex flex-wrap gap-1 mt-1 items-start">

                                        <span class="text-[11px] font-mono bg-gray-100 px-2 py-0.5 rounded">
                                            {{ $client->kode }}
                                        </span>

                                        @if($client->app?->product)
                                            <span class="text-[11px] px-2 py-0.5 rounded-full {{ $client->app->product->badge_color }}">
                                                {{ $client->app->product->nama }}
                                            </span>
                                        @endif

                                    </div>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <div class="font-semibold text-gray-800">
                                        {{ number_format($app->jumsis ?? 0,0,',','.') }}
                                    </div>

                                    <div class="text-xs text-gray-500 mt-1 font-mono">
                                        {{ $app->server->nama ?? '-' }}
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    @if($app && $app->features->count())

                                        <div class="space-y-1">

                                            @foreach($app->features as $feature)

                                                @if($feature->kode == 'ujian')
                                                    <div class="flex flex-col">
                                                        <span class="inline-flex w-fit px-2 py-0.5 rounded-full text-xs bg-indigo-100 text-indigo-700">
                                                            Ujian
                                                        </span>

                                                        @if($app->kode_examol)
                                                            <span class="text-xs text-gray-500 mt-1 font-mono ml-1 mb-1">
                                                                {{ $app->kode_examol }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                @endif

                                                @if($feature->kode == 'presensi')
                                                    <div class="flex flex-col">
                                                        <span class="inline-flex w-fit px-2 py-0.5 rounded-full text-xs bg-cyan-100 text-cyan-700">
                                                            Presensi
                                                        </span>

                                                        @if($app->link_presensi)
                                                            <a href="{{ $app->link_presensi }}" class="text-xs text-gray-500 mt-1 font-mono" target="_blank">
                                                            Link
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif

                                                @if(!in_array($feature->kode,['ujian','presensi']))
                                                    <span class="inline-flex px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-700">
                                                        {{ $feature->nama_fitur }}
                                                    </span>
                                                @endif

                                            @endforeach

                                        </div>

                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak ada fitur</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-xs">
                                    @if($app?->aktivasi_aplikasi)
                                        {{ \Carbon\Carbon::parse($app->aktivasi_aplikasi)->format('d M Y') }}
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-xs">
                                    @php
                                        $contract = $client->contracts->first();
                                    @endphp

                                    @if($contract)
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $contract->nomor_kontrak ?? 'Tanpa Nomor' }}
                                        </div>

                                        @if($contract->tanggal_mulai)
                                            <div class="text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($contract->tanggal_mulai)->format('d M Y') }}
                                            </div>
                                        @endif

                                        @if($contract->tanggal_berakhir)
                                            <div class="text-gray-500 mt-1">
                                                sd. {{ \Carbon\Carbon::parse($contract->tanggal_berakhir)->format('d M Y') }}
                                            </div>
                                        @endif

                                        @if($contract->file)
                                            <a href="{{ asset('storage/'.$contract->file) }}" target="_blank"
                                               class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-500 dark:text-blue-400 mt-1">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                File
                                            </a>
                                        @endif
                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-xs align-top">

                                    @if($app)

                                        <div class="mb-2">
                                            <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded bg-blue-100 text-blue-700 mb-1">
                                                APP
                                            </span>

                                            @if($app->expired_aplikasi)
                                                <div class="{{ $app->sisa_hari_aplikasi < 0
                                                    ? 'text-red-600 font-semibold'
                                                    : ($app->is_aplikasi_warning
                                                        ? 'text-yellow-600 font-semibold'
                                                        : 'text-gray-700') }}">
                                                        
                                                    {{ \Carbon\Carbon::parse($app->expired_aplikasi)->format('d M Y') }}
                                                </div>

                                                <div class="text-[11px] text-gray-400">
                                                    @if($app->sisa_hari_aplikasi < 0)
                                                        Expired {{ abs($app->sisa_hari_aplikasi) }} hari lalu
                                                    @else
                                                        {{ $app->sisa_hari_aplikasi }} hari lagi
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-gray-300">-</div>
                                            @endif
                                        </div>

                                        <div>
                                            <span class="inline-block px-1.5 py-0.5 text-[10px] font-semibold rounded bg-purple-100 text-purple-700 mb-1">
                                                DOMAIN
                                            </span>

                                            @if($app->expired_domain)
                                                <div class="{{ $app->sisa_hari_domain < 0
                                                    ? 'text-red-600 font-semibold'
                                                    : ($app->is_domain_warning
                                                        ? 'text-yellow-600 font-semibold'
                                                        : 'text-gray-700') }}">
                                                        
                                                    {{ \Carbon\Carbon::parse($app->expired_domain)->format('d M Y') }}
                                                </div>

                                                <div class="text-[11px] text-gray-400">
                                                    @if($app->sisa_hari_domain < 0)
                                                        Expired {{ abs($app->sisa_hari_domain) }} hari lalu
                                                    @else
                                                        {{ $app->sisa_hari_domain }} hari lagi
                                                    @endif
                                                </div>
                                            @else
                                                <div class="text-gray-300">-</div>
                                            @endif
                                        </div>

                                    @else
                                        <span class="text-gray-300">-</span>
                                    @endif

                                </td>

                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $dotClass }}"></span>
                                        {{ $label }}
                                    </span>
                                </td>

                                @if ($user->isAdmin())
                                <td class="items-center justify-center text-center">
                                    <button id="dropdownDelay{{ $client->id }}Button" data-dropdown-toggle="dropdownDelay{{ $client->id }}" data-dropdown-delay="500" data-dropdown-trigger="click" class="inline-flex items-center justify-center text-white bg-brand box-border border border-transparent text-sm cursor-pointer" type="button">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01"/>
                                            </svg>
                                    </button>

                                    <div id="dropdownDelay{{ $client->id }}" class="absolute right-0 mt-2 z-50 hidden bg-white dark:bg-gray-800 bg-neutral-primary-medium border border-gray-200 dark:border-gray-700 border-default-medium rounded-lg rounded-base shadow-lg w-44">
                                        <ul class="p-2 text-sm text-gray-700 dark:text-gray-200 text-body font-medium" aria-labelledby="dropdownDelay{{ $client->id }}Button">
                                            <li>
                                                <a href="{{ route('clients.show', $client->id) }}" class="inline-flex items-center gap-1 w-full p-1 hover:bg-gray-100 dark:hover:bg-gray-700 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="1" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                        <path stroke="currentColor" stroke-width="1" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                    Detail
                                                </a>
                                            </li>
                                            @if ($user->isAdmin() || $user->isSupport())
                                            <li>
                                                <a href="{{ route('clients.edit', $client->id) }}" class="inline-flex items-center gap-1 w-full p-1 hover:bg-gray-100 dark:hover:bg-gray-700 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <form id="delete-form-{{ $client->id }}"
                                                    action="{{ route('clients.destroy', $client->id) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        type="button"
                                                        onclick="openDeleteModal('delete-form-{{ $client->id }}', '{{ $client->nama }}')"
                                                        class="inline-flex items-center gap-1 w-full p-1 hover:bg-gray-100 dark:hover:bg-gray-700 hover:bg-neutral-tertiary-medium hover:text-heading rounded cursor-pointer">

                                                        <svg class="w-4 h-4"
                                                            fill="none"
                                                            viewBox="0 0 24 24"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                stroke-width="1.8"
                                                                d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                        </svg>

                                                        <span>Hapus</span>

                                                    </button>

                                                </form>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>
                                @endif

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">

        {{-- Info --}}
        <div class="text-sm text-gray-500">
            Menampilkan
            <span class="font-semibold">{{ $clients->firstItem() ?? 0 }}</span>
            -
            <span class="font-semibold">{{ $clients->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold">{{ $clients->total() }}</span>
            data
        </div>

        {{-- Pagination --}}
        <div>
            {{ $clients->withQueryString() }}
        </div>

    </div>
</main>

@push('scripts')
<script>

    function getUrl() {
        return new URL(window.location.href);
    }

    function searchTable() {

        const url = getUrl();
        const search = document.getElementById('search-input').value;

        if (search !== '') {
            url.searchParams.set('search', search);
        } else {
            url.searchParams.delete('search');
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

    function updatePerPage(value) {

        const url = getUrl();

        url.searchParams.set('per_page', value);
        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

    function filterStatus(status) {

        const url = getUrl();

        if (status === '') {
            url.searchParams.delete('status');
        } else {
            url.searchParams.set('status', status);
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }
    function filterTipe(id) {

        const url = getUrl();

        if (id === '') {
            url.searchParams.delete('tipe');
        } else {
            url.searchParams.set('tipe', id);
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }
    function filterJenis(id) {

        const url = getUrl();

        if (id === '') {
            url.searchParams.delete('jenis');
        } else {
            url.searchParams.set('jenis', id);
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

</script>
@endpush
@endsection

