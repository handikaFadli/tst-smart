@extends('layouts.app')

@section('title', 'Edit Ticket')

@section('content')
<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Tiket</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            Edit tiket untuk melaporkan kendala atau permintaan bantuan.
        </p>
    </div>

    <form action="{{ route('tickets.update', $ticket) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 xl:grid-cols-12 gap-6">

            {{-- LEFT CONTENT --}}
            <div class="xl:col-span-9 space-y-5">

                {{-- INFORMASI TIKET --}}
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xs">

                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/20">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Informasi Tiket
                                </h2>
                                <p class="text-xs text-gray-400">
                                    Detail utama laporan tiket
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                            <div class="md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Judul Tiket <span class="text-red-500">*</span>
                                </label>

                                <input type="text"
                                       name="judul"
                                       value="{{ $ticket->judul ?? old('judul') }}"
                                       placeholder="Contoh: Login aplikasi gagal setelah update"
                                       class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">

                                @error('judul')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Deskripsi <span class="text-red-500">*</span>
                                </label>

                                <textarea name="deskripsi"
                                          rows="8"
                                          placeholder="Jelaskan detail kendala yang terjadi..."
                                          class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition resize-none">{{ $ticket->deskripsi ?? old('deskripsi') }}</textarea>

                                @error('deskripsi')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kategori <span class="text-red-500">*</span>
                                </label>

                                <select name="category_id"
                                        class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">

                                    <option value="">Pilih Kategori</option>

                                    @foreach(\App\Models\TicketCategory::where('is_active', true)->get() as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id',$ticket->category_id)==$category->id)>
                                            {{ $category->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block mb-1.5 text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Prioritas <span class="text-red-500">*</span>
                                </label>

                                <select name="priority" class="block w-full px-3 py-2.5 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white transition">
                                    <option value="low" @selected($ticket->priority=='low')>Low</option>
                                    <option value="medium" @selected($ticket->priority=='medium')>Medium</option>
                                    <option value="high" @selected($ticket->priority=='high')>High</option>
                                </select>

                                @error('priority')
                                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            

                        </div>

                    </div>
                </div>

                {{-- ATTACHMENT --}}
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xs">

                    <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-3">

                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-violet-50">
                                <svg class="w-5 h-5 text-violet-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828L18 9.828"/>
                                </svg>
                            </div>

                            <div>
                                <h2 class="text-sm font-semibold text-gray-900 dark:text-white">
                                    Lampiran
                                </h2>

                                <p class="text-xs text-gray-400">
                                    Lampiran baru akan ditambahkan, bukan mengganti lampiran lama.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="p-6">

                        <input
                            type="file"
                            name="attachments[]"
                            multiple
                            accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.zip"
                            class="block w-full text-sm text-gray-500
                                file:mr-4
                                file:py-2.5
                                file:px-4
                                file:rounded-xl
                                file:border-0
                                file:bg-blue-50
                                file:text-blue-700
                                hover:file:bg-blue-100">

                        <p class="mt-2 text-xs text-gray-400">
                            Maksimal 5 file.
                            Ukuran maksimal 10MB per file.
                        </p>

                        @error('attachments.*')
                            <p class="mt-2 text-sm text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>

                </div>

                {{-- ACTION --}}
                <div class="flex items-center justify-end gap-3">

                    <a href="{{ route('tickets.index') }}"
                       class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition">

                        <svg class="w-4 h-4"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>
                        </svg>

                        Simpan Tiket
                    </button>

                </div>

            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="xl:col-span-3 space-y-5">

                {{-- INFORMASI --}}
                <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 shadow-xs">

                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-5">
                        Informasi Pengguna
                    </h3>

                    <div class="space-y-4 text-sm">

                        <div>
                            <p class="text-gray-500 mb-1">Dibuat Oleh</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $ticket->createdBy->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 mb-1">Ditugaskan kepada</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $ticket->assignedTo->name ?? 'N/A' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 mb-1">Tanggal</p>
                            <p class="font-medium text-gray-900 dark:text-white">
                                {{ $ticket->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        <div>
                            <p class="text-gray-500 mb-1">Status Awal</p>

                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>

                    </div>

                </div>
            </div>

        </div>

    </form>

</div>
@endsection

