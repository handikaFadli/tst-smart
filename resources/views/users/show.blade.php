@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <a href="{{ route('users.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail User</h1>
        </div>
        <div class="flex items-center gap-3 text-sm">
            @if ($user->avatar)
                <img class="w-10 h-10 rounded-full" src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
            @else
                <div class="w-10 h-10 rounded-full bg-primary-600 flex items-center justify-center text-white font-bold text-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <span class="font-semibold text-gray-900 dark:text-white">{{ $user->name }}</span>
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
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeMap[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $roleLabelMap[$user->role] ?? ucfirst($user->role) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- Informasi User --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi User</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Nama</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</span>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Email</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</span>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Telepon</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->phone ?: '—' }}</span>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Status</label>
                    @if ($user->is_active)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-green-100 text-green-800 rounded">
                            Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium bg-red-100 text-red-800 rounded">
                            Nonaktif
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Informasi Akun --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                    <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Akun</h2>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Role</label>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleBadgeMap[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ $roleLabelMap[$user->role] ?? ucfirst($user->role) }}
                    </span>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Login Terakhir</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->last_login_at ? $user->last_login_at->format('d M Y, H:i') : '—' }}
                    </span>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Dibuat</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->created_at ? $user->created_at->format('d M Y, H:i') : '—' }}
                    </span>
                </div>

                <div>
                    <label class="block text-xs text-gray-500 uppercase mb-1">Diperbarui</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $user->updated_at ? $user->updated_at->format('d M Y, H:i') : '—' }}
                    </span>
                </div>
            </div>
        </div>

    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('users.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition">
            Kembali
        </a>
        <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit
        </a>
    </div>

</div>
@endsection
