@extends('layouts.app')

@section('title', 'Edit Kategori Tiket')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Kategori Tiket</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Update kategori ticket.</p>
    </div>

    <form action="{{ route('ticket-categories.update', $ticketCategory) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

            <div class="xl:col-span-9 space-y-5">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xs">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-yellow-50 dark:bg-yellow-900/20">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Kategori</h2>
                                <p class="text-xs text-gray-400">Perbarui detail kategori tiket.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama" value="{{ old('nama', $ticketCategory->nama) }}" placeholder="Contoh: Sekolah" 
                                       class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition" required>

                                @error('nama')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
                                <textarea name="deskripsi" rows="5" placeholder="Opsional: deskripsi kategori"
                                          class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition resize-none">{{ old('deskripsi', $ticketCategory->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ old('is_active', $ticketCategory->is_active) ? 'checked' : '' }}>
                                    Aktif
                                </label>
                                @error('is_active')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-6">
                            <a href="{{ route('ticket-categories.index') }}"
                               class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Update
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="xl:col-span-3 space-y-5">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xs">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Informasi</h3>
                    <div class="text-sm text-gray-600 space-y-2">
                        <div>
                            <span class="text-gray-500">Dibuat:</span>
                            <span class="font-semibold text-gray-900">{{ $ticketCategory->created_at?->format('d M Y') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">ID:</span>
                            <span class="font-semibold text-gray-900">{{ $ticketCategory->id }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

