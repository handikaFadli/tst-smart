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
                    <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'open']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'open' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Open</a></li>
                    <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'in_progress']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'in_progress' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">In Progress</a></li>
                    <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'pending']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'pending' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Pending</a></li>
                    <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'resolved']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'resolved' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Resolved</a></li>
                    <li><a href="?{{ http_build_query(request()->except('status') + ['status' => 'closed']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('status') === 'closed' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Closed</a></li>
                </ul>
            </div>

            {{-- Filter Kategori --}}
            <button id="filter-kategori" data-dropdown-toggle="dropdown-kategori"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ request('category_id') ? 'ring-2 ring-blue-200' : '' }}">
                @php
                    $selectedCategory = $categories->firstWhere('id', request('category_id'));
                @endphp
                {{ $selectedCategory ? $selectedCategory->nama : 'Semua Kategori' }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="dropdown-kategori" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-48 dark:bg-gray-700">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                    <li><a href="?{{ http_build_query(request()->except('category_id') + ['category_id' => 'semua']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ !request('category_id') || request('category_id') === 'semua' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Semua Kategori</a></li>
                    @foreach($categories as $cat)
                        <li><a href="?{{ http_build_query(request()->except('category_id') + ['category_id' => $cat->id]) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('category_id') == $cat->id ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">{{ $cat->nama }}</a></li>
                    @endforeach
                </ul>
            </div> 

            {{-- Filter Produk --}}
            <button id="filter-produk" data-dropdown-toggle="dropdown-produk"
                class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ request('product') ? 'ring-2 ring-blue-200' : '' }}">
                @php
                    $selectedProduct = $products->firstWhere('id', request('product'));
                @endphp
                {{ $selectedProduct ? $selectedProduct->nama : 'Semua Produk' }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div id="dropdown-produk" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-48 dark:bg-gray-700">
                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                    <li><a href="?{{ http_build_query(request()->except('product') + ['product' => 'semua']) }}" class="block px-4 py-2 hover:bg-gray-100 {{ !request('product') || request('product') === 'semua' ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">Semua Produk</a></li>
                    @foreach($products as $prod)
                        <li><a href="?{{ http_build_query(request()->except('product') + ['product' => $prod->id]) }}" class="block px-4 py-2 hover:bg-gray-100 {{ request('product') == $prod->id ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">{{ $prod->nama }}</a></li>
                    @endforeach
                </ul>
            </div>

        </div>

        <div class="flex items-center gap-2">

            @if ($user->isAdmin() || $user->isSupport())
            <a href="{{ route('tickets.create') }}"
                class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-full hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Tiket
            </a>
            @endif

            <button type="button"
                class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-full hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download
            </button>

        </div>

    </div>

    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft ">
                    <table class="w-full text-sm text-left" id="data-table">
                        <thead>
                            <tr>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Ticket ID
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Judul
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Klien
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Prioritas
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Tim
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-gray-500 uppercase">
                                    Dibuat
                                </th>
                                <th class="px-6 py-4 text-xs font-semibold tracking-wider text-center text-gray-500 uppercase">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
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

                                <td class="">
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
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</main>
@endsection
