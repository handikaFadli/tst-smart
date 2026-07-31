@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<main>
    <div class="pt-5 block sm:flex items-center justify-between">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Daftar User</h1>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div class="flex flex-wrap items-center gap-2">
                    {{-- Filter Role --}}
                    <button id="filter-role" data-dropdown-toggle="dropdown-role"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ request('role') && request('role') !== 'semua' ? 'ring-2 ring-blue-200' : '' }}">
                        @php
                            $roleLabels = [
                                'semua'   => 'Semua Role',
                                'admin'   => 'Admin',
                                'leader'  => 'Leader',
                                'support' => 'Support',
                                'viewer'  => 'Viewer',
                            ];
                        @endphp
                        {{ $roleLabels[request('role', 'semua')] ?? 'Semua Role' }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="dropdown-role" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 dark:bg-gray-700">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            @foreach (['semua', 'admin', 'leader', 'support', 'viewer'] as $role)
                                <li>
                                    <a href="?{{ http_build_query(request()->except('role') + ['role' => $role]) }}"
                                       class="block px-4 py-2 hover:bg-gray-100 {{ request('role', 'semua') === $role ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">
                                        {{ $roleLabels[$role] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Filter Status --}}
                    <button id="filter-status" data-dropdown-toggle="dropdown-status"
                        class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 {{ request('status') && request('status') !== 'semua' ? 'ring-2 ring-blue-200' : '' }}">
                        @php
                            $statusLabels = [
                                'semua'    => 'Semua Status',
                                'active'   => 'Aktif',
                                'inactive' => 'Nonaktif',
                            ];
                        @endphp
                        {{ $statusLabels[request('status', 'semua')] ?? 'Semua Status' }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="dropdown-status" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-44 dark:bg-gray-700">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200">
                            @foreach (['semua', 'active', 'inactive'] as $status)
                                <li>
                                    <a href="?{{ http_build_query(request()->except('status') + ['status' => $status]) }}"
                                       class="block px-4 py-2 hover:bg-gray-100 {{ request('status', 'semua') === $status ? 'bg-blue-50 font-medium' : '' }} dark:hover:bg-gray-600">
                                        {{ $statusLabels[$status] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('users.create') }}"
                       class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-full hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="flex flex-col mt-4">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft">
                    <table class="w-full text-sm text-left" id="data-table">
                        <thead>
                            <tr class="bg-slate-200 dark:bg-gray-700">
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider w-12">#</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider min-w-40">Nama</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Role</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Telepon</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-xs font-medium text-gray-600 uppercase tracking-wider text-center min-w-35">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $i => $user)
                            @php
                                $roleBadgeMap = [
                                    'admin'   => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'leader'  => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                    'support' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'viewer'  => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                ];
                                $roleLabelMap = [
                                    'admin'   => 'Admin',
                                    'leader'  => 'Leader',
                                    'support' => 'Support',
                                    'viewer'  => 'Viewer',
                                ];
                            @endphp
                            <tr class="border-b border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3 text-xs text-gray-400">{{ $users->firstItem() + $i }}</td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        @if ($user->avatar)
                                            <img class="w-8 h-8 rounded-full" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                            <div class="w-8 h-8 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-xs">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $user->name }}</div>
                                    </div>
                                </td>

                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-600 dark:text-gray-300">{{ $user->email }}</span>
                                </td>

                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeMap[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ $roleLabelMap[$user->role] ?? ucfirst($user->role) }}
                                    </span>
                                </td>

                                <td class="px-4 py-3">
                                    <span class="text-xs text-gray-600">{{ $user->phone ?: '-' }}</span>
                                </td>

                                <td class="px-4 py-3">
                                    @if ($user->is_active)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-1">
                                        <a href="{{ route('users.show', $user->id) }}"
                                           class="p-1.5 rounded border border-blue-200 text-blue-600 hover:bg-blue-50">
                                            👁
                                        </a>

                                        <a href="{{ route('users.edit', $user->id) }}"
                                           class="p-1.5 rounded border border-gray-300 text-gray-700 hover:bg-gray-100">
                                            ✏️
                                        </a>

                                        @if ($user->id !== Auth::id())
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded border border-red-200 text-red-600 hover:bg-red-50">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
                                    Tidak ada data user ditemukan.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($users->hasPages())
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</main>
@endsection
