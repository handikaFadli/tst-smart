@extends('layouts.app')

@section('title', 'Create SLA Rule')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create SLA Rule</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Tambah aturan SLA untuk tiket helpdesk.</p>
    </div>

    <form action="{{ route('ticket-rules.store') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

            <div class="xl:col-span-9 space-y-5">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xs">
                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Informasi Rule</h2>
                                <p class="text-xs text-gray-400">Isi detail aturan SLA tiket.</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Rule <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_rule" value="{{ old('nama_rule') }}" placeholder="Contoh: High Priority SLA"
                                       class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition" required>

                                @error('nama_rule')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kategori <span class="text-red-500">*</span>
                                </label>
                                <select name="category_id"
                                        class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition appearance-none cursor-pointer" required>
                                    <option value="">— Pilih Kategori —</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Priority <span class="text-red-500">*</span>
                                </label>
                                <select name="priority"
                                        class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition appearance-none cursor-pointer" required>
                                    <option value="">— Pilih Priority —</option>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Response Time (menit) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="response_time" value="{{ old('response_time') }}" placeholder="Contoh: 60"
                                       class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition" required min="1">
                                @error('response_time')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Resolution Time (menit) <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="resolution_time" value="{{ old('resolution_time') }}" placeholder="Contoh: 1440"
                                       class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition" required min="1">
                                @error('resolution_time')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                                    <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500" {{ old('is_active', true) ? 'checked' : '' }}>
                                    Active
                                </label>
                                @error('is_active')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 mt-6">
                            <a href="{{ route('ticket-rules.index') }}"
                               class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                                Batal
                            </a>

                            <button type="submit"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- RIGHT SIDEBAR (informasi) --}}
            <div class="xl:col-span-3 space-y-5">
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xs">
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Tips</h3>
                    <ul class="text-sm text-gray-600 space-y-2">
                        <li>• Nama rule akan dipakai sebagai label SLA.</li>
                        <li>• Response Time adalah batas waktu first response dalam menit.</li>
                        <li>• Resolution Time adalah batas waktu resolve dalam menit.</li>
                        <li>• Nonaktifkan rule jika tidak dipakai.</li>
                    </ul>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection

