@extends('layouts.app')

@section('title', 'Detail Akun')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <div class="flex items-center gap-3 mb-3">
            <a href="{{ route('accounts.index') }}" class="p-1.5 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Akun</h1>
        </div>

        <div class="flex items-center flex-wrap gap-3 text-sm">
            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-medium">{{ $client->kode_client }}</span>
            <span class="font-semibold text-gray-900 dark:text-white">{{ $client->nama_client }}</span>
            @if(!empty($account->tipe_akun))
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                    {{ $account->tipe_akun === 'sekolah' ? 'Sekolah' : 'Support' }}
                </span>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

        {{-- SECTION 1: Informasi Utama --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 2-2 3-4 3s-4-1-4-3 2-3 4-3 4 1 4 3zm8 0c0 2-2 3-4 3s-4-1-4-3 2-3 4-3 4 1 4 3z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 11v6a2 2 0 0 1-2 2h-2"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 11v6a2 2 0 0 0 2 2h2"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Akun</h2>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Username</label>
                        <span class="font-mono text-sm text-gray-900 dark:text-white">{{ $account->username ?? '—' }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Password</label>
                        <div class="flex items-center gap-2">
                            <span id="pw-visible" class="font-mono text-sm text-gray-800 dark:text-gray-200 hidden transition">{{ $account->password ?? '—' }}</span>
                            <span id="pw-hidden" class="font-mono text-sm text-gray-400 tracking-widest">••••••••</span>
                            <button type="button" onclick="togglePw()" class="text-gray-400 hover:text-gray-600 transition text-sm">
                                <svg id="eye" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Status</label>
                        @php
                            $isActive = isset($account->is_active) ? (bool)$account->is_active : false;
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-sm font-medium {{ $isActive ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            <span class="w-2 h-2 rounded-full {{ $isActive ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                            {{ $isActive ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 2: Informasi Client --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Client</h2>
            </div>

            <div class="space-y-4">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Jenis</label>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium {{ $client->jenis === 'edulink' ? 'bg-violet-100 text-violet-800' : 'bg-green-100 text-green-800' }}">
                            {{ $client->jenis === 'edulink' ? 'EduLink' : 'Ujian CBT' }}
                        </span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">PIC Internal</label>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $client->pic?->name ?? '—' }}</span>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Tipe</label>
                        <span class="inline-flex px-2.5 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                            {{ $client->tipe === 'sekolah' ? 'Sekolah' : 'Bimbel' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: Fitur --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs lg:col-span-2">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-900/30">
                    <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Fitur Aktif ({{ $client->app->features->count() ?? 0 }})</h2>
            </div>

            @if($client->app?->features && $client->app->features->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                    @foreach($client->app->features as $feature)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border">
                            <h4 class="font-medium text-sm text-gray-900 dark:text-white mb-1">{{ $feature->nama_fitur }}</h4>
                            <span class="inline-flex px-2 py-0.5 text-xs bg-gray-100 text-gray-700 rounded-full">{{ $feature->kode }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-4.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 002.586 13H2"/>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Tidak ada fitur aktif</h3>
                    <p class="text-sm text-gray-500">Client ini belum memiliki fitur yang diaktifkan.</p>
                </div>
            @endif
        </div>

        {{-- SECTION 4: Akun pada Client --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 shadow-xs lg:col-span-2">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Daftar Akun pada Client</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-xs uppercase tracking-wider text-gray-500">
                            <th class="py-2">Username</th>
                            <th class="py-2">Tipe</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($accounts as $a)
                            <tr class="border-t border-gray-200 dark:border-gray-700">
                                <td class="py-2">
                                    <span class="font-mono text-gray-900 dark:text-white text-sm">{{ $a->username }}</span>
                                    @if($a->id === $account->id)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 text-[11px] rounded-full bg-blue-100 text-blue-800">Ditampilkan</span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $a->tipe_akun === 'sekolah' ? 'Sekolah' : 'Support' }}
                                    </span>
                                </td>
                                <td class="py-2">
                                    @php $active = isset($a->is_active) ? (bool)$a->is_active : false; @endphp
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        <span class="w-2 h-2 rounded-full {{ $active ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                        {{ $active ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </td>
                                <td class="py-2">
                                    <a href="{{ route('accounts.show', $a) }}" class="text-sm font-medium text-blue-600 hover:underline">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                        @if($accounts->isEmpty())
                            <tr>
                                <td colspan="4" class="py-6 text-center text-sm text-gray-500">Client ini belum memiliki akun.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SECTION 5: Informasi Tambahan --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 lg:col-span-2">
            <div class="flex items-center gap-2 mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Tambahan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">URL Aplikasi</label>
                    @if($client->app->url_aplikasi)
                        <a href="{{ $client->app->url_aplikasi }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 truncate max-w-md">
                            {{ $client->app->url_aplikasi }}
                        </a>
                    @else
                        <span class="text-sm text-gray-500">—</span>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Kode ExaMol</label>
                    <span class="font-mono text-sm text-gray-900 dark:text-white">{{ $client->app->kode_examol ?? '—' }}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Link Presensi</label>
                    @if($client->app->link_presensi)
                        <a href="{{ $client->app->link_presensi }}" target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400">
                            Presensi
                        </a>
                    @else
                        <span class="text-sm text-gray-500">—</span>
                    @endif
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-1">Jumlah Akun</label>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->accounts()->count() }}</span>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wide mb-2">Catatan</label>
                    @if($client->app->catatan)
                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-wrap bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">{{ $client->app->catatan }}</p>
                    @else
                        <p class="text-sm text-gray-500 italic">Tidak ada catatan</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
        <a href="{{ route('accounts.index') }}"
           class="px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition">
            ← Kembali ke Daftar
        </a>
        <a href="{{ route('accounts.edit', $account->id) }}"
           class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Akun
        </a>
    </div>

</div>

<script>
function togglePw() {
    const visible = document.getElementById('pw-visible');
    const hidden = document.getElementById('pw-hidden');
    const eye = document.getElementById('eye');

    const isHidden = visible.classList.contains('hidden');
    if (isHidden) {
        visible.classList.remove('hidden');
        hidden.classList.add('hidden');
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0l.83.83M6.59 6.59L9.82 9.82m0 0L15.17 15.02l.83.83M15 15l4.96 4.97"/>';
    } else {
        visible.classList.add('hidden');
        hidden.classList.remove('hidden');
        eye.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>';
    }
}
</script>
@endsection

