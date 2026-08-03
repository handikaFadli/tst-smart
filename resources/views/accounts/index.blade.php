@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
<main>
    <div class="pt-5 flex items-center justify-between mb-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Akun</h1>
        <a href="{{ route('accounts.create') }}"
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
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider border border-slate-300 w-12 text-center">#</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider border border-slate-300" style="min-width:200px">Nama Sekolah</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider border border-slate-300" style="min-width:260px">URL Aplikasi</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider border border-slate-300" style="min-width:200px">Username</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider border border-slate-300" style="min-width:160px">Password</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider border border-slate-300 text-center w-24">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                @php
                                    $accounts = $client->app->accounts;
                                    $rowspan  = $accounts->count() ?: 1;
                                @endphp

                                @if($accounts->isEmpty())
                                    {{-- Client tanpa akun --}}
                                    <tr class="border-t-2 border-slate-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-4 py-3 text-xs text-gray-400 text-center border border-slate-200 bg-gray-50 font-medium"
                                            rowspan="1">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border border-slate-200 bg-gray-50" rowspan="1">
                                            <div class="font-medium text-gray-900 dark:text-white text-sm">{{ $client->nama }}</div>
                                            <div class="flex flex-wrap gap-1 mt-1">
                                                <span class="text-[10px] font-mono bg-gray-100 px-1.5 py-0.5 rounded text-gray-500">{{ $client->kode }}</span>
                                                @if($client->jenis === 'edulink')
                                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-violet-100 text-violet-600">EduLink</span>
                                                @else
                                                    <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-green-100 text-green-600">Ujian CBT</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 border border-slate-200 bg-gray-50" rowspan="1">
                                            @if($client->app && $client->app->url_aplikasi)
                                                <a href="{{ $client->app->url_aplikasi }}" target="_blank"
                                                class="text-xs text-blue-600 hover:underline break-all">{{ $client->app->url_aplikasi }}</a>
                                            @else
                                                <span class="text-gray-300 text-xs">—</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 border border-slate-200" colspan="2">
                                            <span class="text-xs text-gray-400 italic">Belum ada akun</span>
                                        </td>
                                        <td class="px-4 py-3 border border-slate-200 text-center" rowspan="1">
                                            <a href="{{ route('clients.edit', $client) }}"
                                            class="inline-flex items-center px-2 py-1 text-xs border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50">
                                                Edit
                                            </a>
                                        </td>
                                    </tr>

                                @else
                                    @foreach($accounts as $ai => $akun)
                                        <tr class="{{ $ai === 0 ? 'border-t-2 border-slate-300' : 'border-t border-dashed border-slate-200' }} hover:bg-blue-50/30 dark:hover:bg-gray-700 transition-colors">

                                            {{-- No & Nama & URL hanya di baris pertama (rowspan) --}}
                                            @if($ai === 0)
                                                <td class="px-4 py-3 text-xs text-gray-500 text-center font-medium border border-slate-200 bg-gray-50 align-middle"
                                                    rowspan="{{ $rowspan }}">
                                                    {{ $loop->parent->iteration }}
                                                </td>
                                                <td class="px-4 py-3 border border-slate-200 bg-gray-50 align-middle"
                                                    rowspan="{{ $rowspan }}">
                                                    <div class="font-medium text-gray-900 dark:text-white text-sm">{{ $client->nama }}</div>
                                                    <div class="flex flex-wrap gap-1 mt-1.5">
                                                        <span class="text-[10px] font-mono bg-gray-100 px-1.5 py-0.5 rounded text-gray-500">{{ $client->kode }}</span>
                                                        @if($client->jenis === 'edulink')
                                                            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-violet-100 text-violet-600">EduLink</span>
                                                        @else
                                                            <span class="text-[10px] px-1.5 py-0.5 rounded-full bg-green-100 text-green-600">Ujian CBT</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 border border-slate-200 bg-gray-50 align-middle"
                                                    rowspan="{{ $rowspan }}">
                                                    @if($client->app && $client->app->url_aplikasi)
                                                        <a href="{{ $client->app->url_aplikasi }}" target="_blank"
                                                        class="text-xs text-blue-600 hover:underline break-all leading-relaxed">
                                                            {{ $client->app->url_aplikasi }}
                                                        </a>
                                                    @else
                                                        <span class="text-gray-300 text-xs">—</span>
                                                    @endif
                                                </td>
                                            @endif

                                            {{-- Username --}}
                                            <td class="px-4 py-3 border border-slate-200">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex items-center gap-1.5 cursor-pointer group" onclick="copyText('{{ $akun->username }}')">
                                                        <span class="font-mono text-xs text-gray-800 dark:text-gray-200 group-hover:text-gray-900 transition">{{ $akun->username }}</span>
                                                        
                                                    </div>
                                            </td>

                                            {{-- Password --}}
                                            <td class="px-4 py-3 border border-slate-200">
                                                <div class="flex items-center gap-2">
                                                    <div class="flex items-center gap-1.5">
                                                        <div class="flex items-center gap-1.5 cursor-pointer group" onclick="copyText('{{ $akun->password }}')">
                                                            <span id="pw-visible-{{ $akun->id }}" class="font-mono text-xs text-gray-800 dark:text-gray-200 hidden transition">{{ $akun->password }}</span>
                                                            <span id="pw-hidden-{{ $akun->id }}" class="font-mono text-xs text-gray-400 tracking-widest">••••••</span>
                                                            
                                                        </div>
                                                        <button onclick="togglePw({{ $akun->id }})" class="text-gray-400 hover:text-gray-600 transition text-sm">
                                                            <svg id="eye-{{ $akun->id }}" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                            </svg>
                                                        </button>
                                                    </div>
                                            </td>

                                            {{-- Aksi (hanya baris pertama) --}}
                                            @if($ai === 0)
                                            <td class="px-4 py-3 border border-slate-200 text-center align-middle"
                                                    rowspan="{{ $rowspan }}">
                                                    <div class="flex flex-col items-center gap-1.5">
                                                        <a href="{{ route('accounts.edit',$akun->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1 text-xs border border-blue-300 text-blue-600 rounded-md hover:bg-blue-50 w-full justify-center font-medium">
                                                            Edit
                                                        </a>

                                                        <form id="delete-form-{{ $akun->id }}" action="{{ route('accounts.destroy', $akun->id) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                    onclick="openDeleteModal('delete-form-{{ $akun->id }}', '{{ $client->nama }}')"
                                                                    class="inline-flex items-center gap-1 px-2.5 py-1 text-xs border border-red-300 text-red-600 rounded-md hover:bg-red-50 w-full justify-center font-medium cursor-pointer">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    
                                                    </div>
                                                </td>
                                            @endif

                                        </tr>
                                    @endforeach
                                @endif

                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-400 border border-slate-200">
                                        Tidak ada data klien
                                    </td>
                                </tr>
                            @endforelse
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
const shown = {};

function togglePw(id) {
    shown[id] = !shown[id];
    const el  = document.getElementById('pw-' + id);
    const btn = document.getElementById('eye-' + id);
    if (shown[id]) {
        el.textContent  = el.dataset.raw;
        el.style.color  = '#1e293b';
        el.style.letterSpacing = 'normal';
        btn.textContent = '🙈';
    } else {
        el.textContent  = '••••••';
        el.style.color  = '#94a3b8';
        el.style.letterSpacing = '2px';
        btn.textContent = '👁';
    }
}


function togglePw(id) {
    const visible = document.getElementById('pw-visible-' + id);
    const hidden = document.getElementById('pw-hidden-' + id);
    const eye = document.getElementById('eye-' + id);
    
    if (visible.classList.contains('hidden')) {
        visible.classList.remove('hidden');
        hidden.classList.add('hidden');
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0l.83.83M6.59 6.59L9.82 9.82m0 0L15.17 15.02l.83.83M15 15l4.96 4.97" />';
    } else {
        visible.classList.add('hidden');
        hidden.classList.remove('hidden');
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
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

