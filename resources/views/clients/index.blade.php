@extends('layouts.app')

@section('title', 'Daftar Klien')

@section('content')
<main>
    <div class="pt-5 block sm:flex items-center justify-between ">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar Klien</h1>
            </div>
            <div class="flex items-center justify-between gap-3">
    
                <div class="flex items-center gap-2">
                    {{-- Filter Status --}}
                    <button id="filter-status" data-dropdown-toggle="dropdown-status"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ request('status') ? 'ring-2 ring-blue-200' : '' }}">
                        {{ request('status', 'semua') === 'semua' ? 'Semua Status' : ucfirst(str_replace('_', ' ', request('status'))) }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="dropdown-status" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 dark:bg-gray-700">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'semua']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'semua' || !request('status') ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Semua</a></li>
                            <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'active']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'active' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Aktif</a></li>
                            <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'expired']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'expired' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Expired</a></li>
                            <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'trial']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'trial' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Trial</a></li>
                            <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'inactive']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'inactive' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Inactive</a></li>
                        </ul>
                    </div>

                    {{-- Filter Tipe --}}
                    <button id="filter-tipe" data-dropdown-toggle="dropdown-tipe"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ request('tipe') ? 'ring-2 ring-blue-200' : '' }}">
                        {{ request('tipe', 'semua') === 'semua' ? 'Semua Tipe' : ucfirst(request('tipe')) }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="dropdown-tipe" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-36 dark:bg-gray-700">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li><a href="?{{ http_build_query(request()->except('tipe') + ['tipe' => 'semua']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('tipe') === 'semua' || !request('tipe') ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Semua</a></li>
                            <li><a href="?{{ http_build_query(request()->except('tipe') + ['tipe' => 'sekolah']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('tipe') === 'sekolah' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Sekolah</a></li>
                            <li><a href="?{{ http_build_query(request()->except('tipe') + ['tipe' => 'bimbel']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('tipe') === 'bimbel' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Bimbel</a></li>
                        </ul>
                    </div> 

                    {{-- Filter Jenis --}}
                    <button id="filter-jenis" data-dropdown-toggle="dropdown-jenis"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ request('jenis') ? 'ring-2 ring-blue-200' : '' }}">
                        {{ request('jenis', 'semua') === 'semua' ? 'Semua Jenis' : ucfirst(request('jenis')) }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="dropdown-jenis" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 dark:bg-gray-700">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            <li><a href="?{{ http_build_query(request()->except('jenis') + ['jenis' => 'semua']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('jenis') === 'semua' || !request('jenis') ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Semua</a></li>
                            <li><a href="?{{ http_build_query(request()->except('jenis') + ['jenis' => 'edulink']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('jenis') === 'edulink' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">EduLink</a></li>
                            <li><a href="?{{ http_build_query(request()->except('jenis') + ['jenis' => 'ujiancbt']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('jenis') === 'ujiancbt' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Ujian CBT</a></li>
                        </ul>
                    </div>

                </div>

                @if ($user->isAdmin())
                <div class="flex items-center gap-2">

                    {{-- Tambah --}}
                    <a href="{{ route('clients.create') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-full hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </a>

                    {{-- Download --}}
                    <button type="button"
                        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        Download
                    </button>

                </div>
                @endif

            </div>
        </div>
    </div>
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft ">
                    <table class="w-full text-sm text-left" id="data-table">
                        <thead>
                            <tr class="bg-slate-200 dark:bg-gray-700">
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Klien</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Jumsis</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Fitur</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">AktiVasi</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider min-w-20">Expired</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                 @if ($user->isAdmin())
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Aksi</th>
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
                                    'trial'    => ['bg-yellow-100 text-yellow-700', 'bg-yellow-500', 'Trial'],
                                    'inactive' => ['bg-gray-100 text-gray-600', 'bg-gray-400', 'Inactive'],
                                ];

                                [$badgeClass, $dotClass, $label] =
                                    $statusMap[$app?->status ?? 'inactive'];
                            @endphp

                            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">

                                <td class="px-4 py-3 text-xs text-gray-400">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">
                                        {{ $client->nama }}
                                    </div>

                                    <div class="flex flex-wrap gap-1 items-start">

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
                                <td class="">
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
                                            <li>
                                                <a href="{{ route('clients.edit', $client->id) }}" class="inline-flex items-center gap-1 w-full p-1 hover:bg-gray-100 dark:hover:bg-gray-700 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <form id="delete-form-{{ $client->id }}" action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="button"
                                                            onclick="openDeleteModal('delete-form-{{ $client->id }}', '{{ $client->nama }}')"
                                                            class="inline-flex items-center gap-1 w-full p-1 text-sm text-gray-700 hover:bg-gray-100 hover:text-heading dark:text-gray-200 dark:hover:bg-gray-700 rounded transition-colors cursor-pointer">
                                                        <svg class="w-4 h-4 text-gray-800 dark:text-white shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </li>
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

</main>
@endsection

