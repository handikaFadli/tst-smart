@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<main>
    <div class="pt-5 flex items-center justify-between mb-5">
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">Daftar User</h1>
        <a href="{{ route('users.create') }}"
        class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah
        </a>
    </div>

    <div class="flex flex-wrap items-center justify-between gap-4 mb-2">
        <div class="flex items-center gap-3">
                    {{-- Dropdown Per Page --}}
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

                    {{-- Filter Role --}}
                    <div class="relative inline-block">
                        <button
                            id="roleButton"
                            data-dropdown-toggle="roleDropdown"
                            class="flex items-center justify-between min-w-37 h-11 px-4
                                bg-white border border-gray-200 rounded-xl shadow-sm
                                text-sm font-medium text-gray-700
                                hover:border-primary-400 hover:shadow-md
                                focus:ring-4 focus:ring-primary-100
                                transition-all cursor-pointer">

                            <span>
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

                        <div id="roleDropdown"
                            class="hidden z-20 w-40 mt-2 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden cursor-pointer">

                            @foreach (['semua', 'admin', 'leader', 'support', 'viewer'] as $role)
                                <button
                                    onclick="filterRole('{{ $role }}')"
                                    class="w-full px-4 py-2.5 flex items-center justify-between
                                        hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                        {{ request('role', 'semua') === $role ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">

                                    <span>{{ $roleLabels[$role] }}</span>

                                </button>
                            @endforeach

                        </div>
                    </div>

                    {{-- Filter Status --}}
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
                                @php
                                    $statusLabels = [
                                        'semua'    => 'Semua Status',
                                        'active'   => 'Aktif',
                                        'inactive' => 'Nonaktif',
                                    ];
                                @endphp
                                {{ $statusLabels[request('status', 'semua')] ?? 'Semua Status' }}
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

                            @foreach (['semua', 'active', 'inactive'] as $status)
                                <button
                                    onclick="filterStatus('{{ $status }}')"
                                    class="w-full px-4 py-2.5 flex items-center justify-between
                                        hover:bg-primary-50 hover:text-primary-600 transition cursor-pointer
                                        {{ request('status', 'semua') === $status ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-gray-700' }}">

                                    <span>{{ $statusLabels[$status] }}</span>

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

    <div class="flex flex-col mt-4">
        <div class="overflow-x-auto">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden shadow relative bg-neutral-primary-soft">
                    <table class="w-full text-sm text-left">
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
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">
                <div class="text-sm text-gray-500">
                    Menampilkan
                    <span class="font-semibold">{{ $users->firstItem() ?? 0 }}</span>
                    -
                    <span class="font-semibold">{{ $users->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold">{{ $users->total() }}</span>
                    data
                </div>

                <div>
                    {{ $users->withQueryString() }}
                </div>
            </div>
        @else
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mt-6">
                <div class="text-sm text-gray-500">
                    Menampilkan
                    <span class="font-semibold">{{ $users->firstItem() ?? 0 }}</span>
                    -
                    <span class="font-semibold">{{ $users->lastItem() ?? 0 }}</span>
                    dari
                    <span class="font-semibold">{{ $users->total() }}</span>
                    data
                </div>
            </div>
        @endif
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

    function filterRole(role) {

        const url = getUrl();

        if (role === '' || role === 'semua') {
            url.searchParams.delete('role');
        } else {
            url.searchParams.set('role', role);
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

    function filterStatus(status) {

        const url = getUrl();

        if (status === '' || status === 'semua') {
            url.searchParams.delete('status');
        } else {
            url.searchParams.set('status', status);
        }

        url.searchParams.set('page', 1);

        window.location.href = url.toString();
    }

</script>
@endpush
@endsection
