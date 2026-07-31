@extends('layouts.app')

@section('title', 'Daftar Kategori Tiket')

@section('content')
<main>
    <div class="pt-5 flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar Kategori Tiket</h1>
        @if ($user->isAdmin() || $user->isSupport())
        <a href="{{ route('ticket-categories.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-full hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </a>
        @endif
    </div>

    <div class="flex flex-col mt-4">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft">
                    <table class="w-full text-sm text-left" id="data-table">
                        <thead>
                            <tr class="bg-slate-200 dark:bg-gray-700">
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider w-12">#</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                @if ($user->isAdmin() || $user->isSupport())
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $i => $ticketCategory)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3 text-xs text-gray-400">{{ $categories->firstItem() + $i }}</td>

                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $ticketCategory->nama }}</div>
                                </td>

                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-600">{{ $ticketCategory->deskripsi ? \Illuminate\Support\Str::limit($ticketCategory->deskripsi, 60) : '-' }}</span>
                                </td>

                                <td class="px-4 py-3">
                                    @if ($ticketCategory->is_active == true)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                @if ($user->isAdmin() || $user->isSupport())
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('ticket-categories.edit', $ticketCategory->id) }}"
                                           class="p-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">
                                            ✏️
                                        </a>

                                        <form action="{{ route('ticket-categories.destroy', $ticketCategory->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori tiket ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 rounded border border-red-200 text-red-600 hover:bg-red-50">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                </svg>
                                            </button>
                                        </form>
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

