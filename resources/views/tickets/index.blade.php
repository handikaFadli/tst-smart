@extends('layouts.app')

@section('title', 'Helpdesk Tickets')

@section('content')
<main>
    <div class="pt-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Daftar Tiket
        </h1>
    </div>

    <div class="grid grid-cols-1 gap-4 pt-4 mb-5 sm:grid-cols-2 xl:grid-cols-5">

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Open
            </div>

            <div class="mt-2 text-2xl font-bold text-gray-800">
                {{ $stats['open'] ?? 0 }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                In Progress
            </div>

            <div class="mt-2 text-2xl font-bold text-blue-600">
                {{ $stats['in_progress'] ?? 0 }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Pending
            </div>

            <div class="mt-2 text-2xl font-bold text-yellow-500">
                {{ $stats['pending'] ?? 0 }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Resolved
            </div>

            <div class="mt-2 text-2xl font-bold text-green-600">
                {{ $stats['resolved'] ?? 0 }}
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm">
            <div class="text-sm text-gray-500">
                Closed
            </div>

            <div class="mt-2 text-2xl font-bold text-red-600">
                {{ $stats['closed'] ?? 0 }}
            </div>
        </div>

    </div>

    <div class="flex justify-end mb-5 gap-3">

            @if ($user->isAdmin() || $user->isSupport())
            <a href="{{ route('tickets.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Tiket
            </a>
            @endif

            <button type="button"
                class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download
            </button>

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
                            'open' => 'Open',
                            'in_progress' => 'In Progress',
                            'pending' => 'Pending',
                            'resolved' => 'Resolved',
                            'closed' => 'Closed',
                            'cancelled' => 'Cancelled'
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
                    id="kategoriButton"
                    data-dropdown-toggle="kategoriDropdown"
                    class="flex items-center justify-between min-w-40 h-11 px-4
                        bg-white border border-gray-200 rounded-xl shadow-sm
                        text-sm font-medium text-gray-700
                        hover:border-primary-400 hover:shadow-md
                        focus:ring-4 focus:ring-primary-100
                        transition-all cursor-pointer">

                    <span>
                        {{ optional($selectedCategory)->nama ?: 'Semua Kategori' }}
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

                <div id="kategoriDropdown"
                    class="hidden z-20 w-45 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden cursor-pointer">
                    <button
                        onclick="filterKategori('')"
                        class="w-full px-4 py-2.5 flex items-center justify-between
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                ">
                        Semua Kategori
                    </button>

                    @foreach($categories as $category)

                        <button
                            onclick="filterKategori('{{ $category->id }}')"
                            class="w-full px-4 py-2.5 flex items-center justify-between
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                {{ request('kategori') == $category->id ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">

                            <span>{{ $category->nama }}</span>

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
                                hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                {{ !request('jenis') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">
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
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    Ticket ID
                                </th>
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    Judul
                                </th>
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    Klien
                                </th>
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    Prioritas
                                </th>
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    Tim
                                </th>
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-gray-500 uppercase">
                                    Dibuat
                                </th>
                                <th class="px-6 py-4 text-xs font-bold tracking-wider text-center text-gray-500 uppercase">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($tickets as $ticket)
                            <tr class="border-t border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700/40">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-blue-600">
                                        #{{ $ticket->kode_ticket }}
                                    </div>

                                    <div class="mt-1 text-xs text-gray-400">
                                        {{ $ticket->category?->nama }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-900 dark:text-white text-sm">
                                        {{ $ticket->judul }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">
                                    <div class="font-medium text-gray-700 dark:text-gray-200">
                                        {{ $ticket->client->nama }}
                                    </div>
                                </td>

                                <td class="px-6 py-4">

                                    @if($ticket->priority == 'high')
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full">
                                            High
                                        </span>
                                    @elseif($ticket->priority == 'medium')
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full">
                                            Medium
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 text-xs font-medium text-gray-700 bg-gray-100 rounded-full">
                                            Low
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">

                                    @if($ticket->status == 'open')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">
                                            Open
                                        </span>
                                    @elseif($ticket->status == 'in_progress')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full">
                                            In Progress
                                        </span>
                                    @elseif($ticket->status == 'pending')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-orange-700 bg-orange-100 rounded-full">
                                            Pending
                                        </span>
                                    @elseif($ticket->status == 'resolved')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                            Resolved
                                        </span>
                                    @elseif($ticket->status == 'cancelled')
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-gray-700 bg-gray-200 rounded-full">
                                            Cancelled
                                        </span>
                                    @else
                                        <span class="inline-flex px-2.5 py-1 text-xs font-medium text-gray-700 bg-gray-200 rounded-full">
                                            Closed
                                        </span>
                                    @endif

                                </td>

                                <td class="px-6 py-4">
                                    @if($ticket->assignedTo)
                                        <div class="font-medium text-gray-700 dark:text-gray-200">
                                            {{ $ticket->assignedTo->name }}
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">
                                            -
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 dark:text-gray-200">
                                        {{ $ticket->created_at->format('d M Y') }}
                                    </div>

                                    <div class="mt-1 text-xs text-gray-400">
                                        {{ $ticket->created_at->format('H:i') }}
                                    </div>
                                </td>

                                <td class="items-center justify-center text-center">
                                    <button id="dropdownDelay{{ $ticket->id }}Button" data-dropdown-toggle="dropdownDelay{{ $ticket->id }}" data-dropdown-delay="500" data-dropdown-trigger="click" class="inline-flex items-center justify-center text-white bg-brand box-border border border-transparent text-sm cursor-pointer" type="button">
                                            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01"/>
                                            </svg>
                                    </button>

                                    <div id="dropdownDelay{{ $ticket->id }}" class="absolute right-0 mt-2 z-50 hidden bg-white dark:bg-gray-800 bg-neutral-primary-medium border border-gray-200 dark:border-gray-700 border-default-medium rounded-lg rounded-base shadow-lg w-44">
                                        <ul class="p-2 text-sm text-gray-700 dark:text-gray-200 text-body font-medium" aria-labelledby="dropdownDelay{{ $ticket->id }}Button">
                                            <li>
                                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center gap-1 w-full p-1 hover:bg-gray-100 dark:hover:bg-gray-700 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-width="1" d="M21 12c0 1.2-4.03 6-9 6s-9-4.8-9-6c0-1.2 4.03-6 9-6s9 4.8 9 6Z"/>
                                                        <path stroke="currentColor" stroke-width="1" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                    </svg>
                                                    Detail
                                                </a>
                                            </li>
                                            @if ($user->isAdmin() || $user->isSupport())
                                            <li>
                                                <a href="{{ route('tickets.edit', $ticket->id) }}" class="inline-flex items-center gap-1 w-full p-1 hover:bg-gray-100 dark:hover:bg-gray-700 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M10.779 17.779 4.36 19.918 6.5 13.5m4.279 4.279 8.364-8.643a3.027 3.027 0 0 0-2.14-5.165 3.03 3.03 0 0 0-2.14.886L6.5 13.5m4.279 4.279L6.499 13.5m2.14 2.14 6.213-6.504M12.75 7.04 17 11.28"/>
                                                    </svg>
                                                    Edit
                                                </a>
                                            </li>
                                            
                                            <li>
                                                <a href="#" class="inline-flex items-center gap-1 w-full p-1 hover:bg-gray-100 dark:hover:bg-gray-700 hover:bg-neutral-tertiary-medium hover:text-heading rounded">
                                                    <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                    </svg>
                                                    Hapus
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada data tiket
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
            <span class="font-semibold">{{ $tickets->firstItem() ?? 0 }}</span>
            -
            <span class="font-semibold">{{ $tickets->lastItem() ?? 0 }}</span>
            dari
            <span class="font-semibold">{{ $tickets->total() }}</span>
            data
        </div>

        {{-- Pagination --}}
        <div>
            {{ $tickets->withQueryString() }}
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
    function filterKategori(id) {

        const url = getUrl();

        if (id === '') {
            url.searchParams.delete('kategori');
        } else {
            url.searchParams.set('kategori', id);
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
