@extends('layouts.app')

@section('title', 'Tambah Klien')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-5xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Klien Baru</h1>
    </div>

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-5 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Klien</h2>
                    <p class="text-xs text-gray-400">Data identitas utama klien</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div class="md:col-span-3">
                    <label for="nama" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Nama Klien <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama"
                           value="{{ old('nama') }}"
                           placeholder="Sekolah/Bimbel/Instansi"
                           class="block w-full px-3 py-2.5 text-sm text-gray-900 border-gray-300 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                    @error('nama')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="client_type_id" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Tipe Klien <span class="text-red-500">*</span>
                    </label>
                    <select name="client_type_id" id="client_type_id"
                            class="block w-full px-3 py-2.5 text-sm text-gray-900 border-gray-300 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">
                        @foreach( $clientType as $type)
                            <option value="{{ $type->id }}"
                                {{ old('client_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('client_type_id')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="product_id" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Produk<span class="text-red-500">*</span>
                    </label>
                    <select name="product_id" id="product_id"
                            class="block w-full px-3 py-2.5 text-sm text-gray-900 border-gray-300 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">
                        <option value="">Pilih</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="pic_tim_id" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        PIC Internal <span class="text-red-500">*</span>
                    </label>
                    <select name="pic_tim_id" id="pic_tim_id"
                            class="block w-full px-3 py-2.5 text-sm text-gray-900 border-gray-300 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">
                        <option value="">Pilih</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('pic_tim_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('pic_tim_id')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-5 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-violet-50 dark:bg-violet-900/30">
                    <svg class="w-4 h-4 text-violet-600 dark:text-violet-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Aplikasi</h2>
                    <p class="text-xs text-gray-400">Konfigurasi paket dan fitur yang digunakan</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="paket_fitur" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Paket Fitur <span class="text-red-500">*</span>
                    </label>

                    <select name="fitur_ids[]" id="fitur_ids" multiple
                        class="block w-full px-0 py-0 text-sm text-gray-900 border-gray-300 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">

                        @foreach($features as $feature)
                            <option value="{{ $feature->id }}"
                                {{ collect(old('fitur_ids'))->contains($feature->id) ? 'selected' : '' }}>
                                {{ $feature->nama_fitur }}
                            </option>
                        @endforeach
                    </select>
                    @error('fitur_ids')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="url_aplikasi" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">URL Aplikasi</label>
                    <input type="url" name="url_aplikasi" id="url_aplikasi"
                           value="{{ old('url_aplikasi') }}"
                           placeholder="https://..."
                           class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                    @error('url_aplikasi')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="jumsis" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Jumlah Siswa <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumsis" id="jumsis"
                           value="{{ old('jumsis', 0) }}"
                           min="0"
                           placeholder="0"
                           class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">
                    @error('jumsis')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="kode_examol" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Kode eXamol</label>
                    <input type="text" name="kode_examol" id="kode_examol"
                           value="{{ old('kode_examol') }}"
                           class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                     @error('kode_examol')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="link_presensi" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Link Presensi</label>
                    <input type="url" name="link_presensi" id="link_presensi"
                           value="{{ old('link_presensi') }}"
                           placeholder="https://..."
                           class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                    @error('link_presensi')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="fitur_ujian" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Server <span class="text-red-500">*</span>
                    </label>
                   <select name="server_id" id="server_id"
                            class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">
                        <option value="">Pilih</option>
                        @foreach($servers as $server)
                            <option value="{{ $server->id }}" {{ old('server_id') == $server->id ? 'selected' : '' }}>
                                {{ $server->nama }} - {{ $server->catatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('server_id')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-5 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/30">
                    <svg class="w-4 h-4 text-amber-600 dark:text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Status & Masa Aktif</h2>
                    <p class="text-xs text-gray-400">Status langganan dan tanggal kedaluwarsa</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label for="status" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                            class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">
                        <option value="active"   {{ old('status') == 'aktif'   ? 'selected' : '' }}>Aktif</option>
                        <option value="expired"  {{ old('status') == 'expired'  ? 'selected' : '' }}>Expired</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div>
                    <label for="aktivasi_aplikasi" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Aktivasi Aplikasi</label>
                        <input 
                               type="date" name="aktivasi_aplikasi" id="aktivasi_aplikasi"
                               value="{{ old('aktivasi_aplikasi') }}"
                               placeholder="Pilih tanggal"
                               class="block w-full  pr-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                        @error('aktivasi_aplikasi')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                </div>

                <div>
                    <label for="expired_aplikasi" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Expired Aplikasi</label>
                        <input 
                               type="date" name="expired_aplikasi" id="expired_aplikasi"
                               value="{{ old('expired_aplikasi') }}"
                               placeholder="Pilih tanggal"
                               class="block w-full  pr-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                        @error('expired_aplikasi')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                </div>

                <div>
                    <label for="expired_domain" class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">Expired Domain</label>
                        <input 
                               type="date" name="expired_domain" id="expired_domain"
                               value="{{ old('expired_domain') }}"
                               placeholder="Pilih tanggal"
                               class="block w-full  pr-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition">
                        @error('expired_domain')
                            <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                {{ $message }}
                            </p>
                        @enderror
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 dark:bg-gray-700">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Catatan</h2>
                    <p class="text-xs text-gray-400">Informasi tambahan tentang client ini</p>
                </div>
            </div>

            <textarea name="catatan" id="catatan" rows="3"
                      placeholder="Tulis catatan internal mengenai client ini..."
                      class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 transition resize-none">{{ old('catatan') }}</textarea>
            @error('catatan')
                <p class="mt-1 text-xs text-red-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('clients.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition cursor-pointer">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan
            </button>
        </div>

    </form>
</div>
@endsection