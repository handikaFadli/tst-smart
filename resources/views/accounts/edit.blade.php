@extends('layouts.app')

@section('title', 'Edit Akun')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-5xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Akun - {{ $client->nama_client }}</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Kelola username, password, dan tipe akun untuk client ini</p>
    </div>

    <form action="{{ route('accounts.update', $account) }}" method="POST">
        @csrf
        @method('PATCH')

        <input type="hidden" name="client_id" value="{{ $clientApp->id }}">

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
                
                @php
                    $accounts = $client->app?->accounts ?? collect();
                    $akunCount = 0;
                @endphp

                @forelse($accounts as $akun)
                    @php $akunCount++; @endphp
                    <div class="akun-group mb-4" data-index="{{ $akunCount - 1 }}">
                        <input type="hidden" name="accounts[{{ $akunCount - 1 }}][client_account_id]" value="{{ $akun->id }}">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="accounts[{{ $akunCount - 1 }}][username]" value="{{ $akun->username }}"
                                       class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white border-gray-300 transition" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                                <input type="text" name="accounts[{{ $akunCount - 1 }}][password]" value="{{ $akun->password }}"
                                       class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white border-gray-300 transition" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipe Akun <span class="text-red-500">*</span></label>
                                <div class="space-y-1">
                                    <label class="flex items-center">
                                        <input type="radio" name="accounts[{{ $akunCount - 1 }}][tipe_akun]" value="sekolah" class="mr-2 border-gray-300"
                                            {{ $akun->tipe_akun === 'sekolah' ? 'checked' : '' }}>
                                        Sekolah
                                    </label>
                                    <label class="flex items-center">
                                        <input type="radio" name="accounts[{{ $akunCount - 1 }}][tipe_akun]" value="support" class="mr-2 border-gray-300"
                                            {{ $akun->tipe_akun === 'support' ? 'checked' : '' }}>
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
                @empty
                    <div class="akun-group mb-4" data-index="0">
                        <input type="hidden" name="accounts[0][client_account_id]" value="">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                                <input type="text" name="accounts[0][username]" class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white border-gray-300 transition" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                                <input type="text" name="accounts[0][password]" class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white border-gray-300 transition" required>
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
                @endforelse
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('accounts.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition cursor-pointer">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition cursor-pointer">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>

@push('scripts')
<script>
let akunCount = document.querySelectorAll('#akunContainer .akun-group').length;

function reindexNames() {
    const groups = Array.from(document.querySelectorAll('#akunContainer .akun-group'));
    groups.forEach((group, idx) => {
        group.dataset.index = idx;
        // Update all input/radio names containing accounts[old][...]
        group.querySelectorAll('input[name]').forEach(field => {
            field.name = field.name.replace(/accounts\[\d+\]/, 'accounts[' + idx + ']');
        });
    });
    akunCount = groups.length;
}

document.getElementById('addAkun').onclick = () => {
    const container = document.getElementById('akunContainer');
    const firstGroup = container.querySelector('.akun-group');
    const newGroup = firstGroup.cloneNode(true);

    // reset values
    newGroup.querySelectorAll('input').forEach(input => {
        if (input.type === 'hidden') {
            input.value = '';
        } else if (input.type === 'radio') {
            input.checked = input.value === 'sekolah';
        } else {
            input.value = '';
        }
    });

    container.appendChild(newGroup);
    reindexNames();
};

document.addEventListener('click', e => {
    if (e.target.closest('.remove-akun')) {
        const group = e.target.closest('.akun-group');
        const groups = document.querySelectorAll('#akunContainer .akun-group');
        if (groups.length > 1) {
            group.remove();
            reindexNames();
        }
    }
});
</script>
@endpush
@endsection

