@extends('layouts.app')

@section('title', 'Daftar Fitur Aplikasi')

@section('content')
<main>
    <div class="pt-5 flex items-center justify-between mb-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Fitur Aplikasi</h1>
        <a href="{{ route('features.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </a>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-2">

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

    <div class="flex flex-col mt-4">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft">
                    <table class="w-full text-sm text-left">
                        <thead>
                            <tr class="bg-slate-200 dark:bg-gray-700">
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider w-12">#</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Kode</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($features as $i => $feature)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3 text-xs text-gray-400">{{ $features->firstItem() + $i }}</td>

                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-0.5 text-[12px] font-mono bg-gray-100 text-gray-700 rounded">
                                        {{ $feature->kode }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $feature->nama_fitur }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('features.edit', $feature->id) }}"
                                           class="p-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">
                                            <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                            </svg>
                                        </a>

                                        <form id="delete-form-{{ $feature->id }}" action="{{ route('features.destroy', $feature->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    onclick="openDeleteModal('delete-form-{{ $feature->id }}', '{{ $feature->nama_fitur }}')"
                                                    class="p-1.5 rounded border border-red-200 text-red-600 hover:bg-red-50 cursor-pointer">
                                                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
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
            <span class="font-semibold">{{ $features->firstItem() ?? 0 }}</span>
            -
            <span class="font-semibold">{{ $features->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold">{{ $features->total() }}</span>
            data
        </div>

        {{-- Pagination --}}
        <div>
            {{ $features->withQueryString() }}
        </div>

    </div>
</main>
@endsection

