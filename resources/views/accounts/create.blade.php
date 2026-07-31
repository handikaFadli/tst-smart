@extends('layouts.app')

@section('title', 'Tambah Akun')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-5xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tambah Akun</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Isi data lengkap akun sekolah yang akan didaftarkan ke sistem</p>
    </div>

    <form action="{{ route('accounts.store') }}" method="POST">
        @csrf

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6 shadow-xs">
            <div class="flex items-center gap-2 mb-5">
                <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                    <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Klien</h2>
            </div>
            <select name="client_app_id" id="client_app_id" required class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition @error('client_app_id') border-red-400 bg-red-50 @else border-gray-300 @enderror">
                <option value="">Pilih Klien</option>
                @foreach($clientApps as $clientApp)
                    <option value="{{ $clientApp->id }}" {{ old('client_app_id') == $clientApp->id ? 'selected' : '' }}>
                        {{ $clientApp->client->nama }}
                    </option>
                @endforeach
            </select>
            @error('client_app_id')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        {{-- Akun List --}}
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl p-6 mb-6 shadow-xs">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-2">
                    <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Akun</h2>
                </div>
                <button type="button" id="addAkun" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </button>
            </div>

            <div id="akunContainer">
                <!-- Dynamic akun fields will be here -->
                <div class="akun-group mb-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                            <input type="text" name="accounts[0][username]" class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 border-gray-300 transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                            <input type="password" name="accounts[0][password]" class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400 border-gray-300 transition" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Akun <span class="text-red-500">*</span></label>
                            <div class="space-y-1">
                                <label class="flex items-center">
                                    <input type="radio" name="accounts[0][tipe_akun]" value="sekolah" class="mr-2 border-gray-300" checked>
                                    Sekolah
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="accounts[0][tipe_akun]" value="support" class="mr-2 border-gray-300">
                                    Support
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="mt-3 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm remove-akun">
                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- ── Action Buttons ── --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('accounts.index') }}"
               class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition">
                Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Akun
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
let akunCount = 1;

document.getElementById('addAkun').onclick = () => {
    const container = document.getElementById('akunContainer');
    const newGroup = container.firstElementChild.cloneNode(true);
    
    // Update names
    newGroup.querySelectorAll('[name]').forEach(field => {
        const oldName = field.name;
        field.name = oldName.replace(/\[(\d+)\]/, `[${akunCount}]`);
    });
    
    newGroup.classList.remove('border-red-400');
    
    container.appendChild(newGroup);
    akunCount++;
};

document.addEventListener('click', e => {
    if (e.target.classList.contains('remove-akun')) {
        if (document.querySelectorAll('.akun-group').length > 1) {
            e.target.closest('.akun-group').remove();
        }
    }
});
</script>
@endpush
@endsection

