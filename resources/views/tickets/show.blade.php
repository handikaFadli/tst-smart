@extends('layouts.app')

@section('title', 'Detail Tiket')

@section('content')


<div class="px-4 pt-6 pb-10 max-w-7xl mx-auto w-full min-w-0">


    <div class="flex flex-wrap items-center gap-3 mb-5">

        {{-- Status --}}
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-medium border {{ $ticket->status_class }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <path d="M9 12l2 2 4-4"/>
            </svg>

            {{ ucwords(str_replace('_',' ', $ticket->status)) }}
        </span>

        {{-- Priority --}}
        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-medium border {{ $ticket->priority_class }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>

            {{ ucfirst($ticket->priority) }} Priority
        </span>

    </div>

    <div class="grid grid-cols-3 gap-4 mb-5">
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                Tim Teknis
            </p>
            <p class="font-semibold text-gray-800 text-sm">{{ $ticket->assignedTo?->name ?? '-' }}</p>
        </div>
        {{-- <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                Pesan
            </p>
            <p class="font-semibold text-gray-800 text-sm">{{ $ticket->ticket_messages_count }}</p>
        </div> --}}
        <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
            <p class="text-xs text-gray-400 mb-1 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                Aktivitas
            </p>
            <p class="font-semibold text-gray-800 text-sm">{{ $ticket->ticket_logs_count }}</p>
        </div>
    </div>

    {{-- Main Content + Sidebar --}}
    <div class="flex gap-5 items-start">

        {{-- Left Column --}}
        <div class="flex-1 min-w-0 flex flex-col gap-5">

            {{-- Ticket Details --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 17 20 12 15 7"/><polyline points="9 7 4 12 9 17"/></svg>
                    Detail Tiket
                </h2>

                <div class="border border-gray-200 rounded-lg p-4 mb-4 min-h-[90px]">
                    <p class="text-xs text-gray-400 mb-2">Judul</p>
                    <p class="text-sm text-gray-700">{{ $ticket->judul ?? '-' }}</p>
                </div>

                <div class="border border-gray-200 rounded-lg p-4 mb-4 min-h-[90px]">
                    <p class="text-xs text-gray-400 mb-2">Deskripsi</p>
                    <p class="text-sm text-gray-700">{{ $ticket->deskripsi ?? '-' }}</p>
                </div>

            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
                    File Lampiran
                </h2>

                @forelse($ticket->ticketAttachments as $attachment)
                    <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">

                        <div>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $attachment->file_name }}
                            </p>

                            <p class="text-xs text-gray-400">
                                {{ $attachment->created_at->format('d M Y H:i') }}
                            </p>
                        </div>

                        <div class="flex gap-2">

                            <a href="{{ Storage::disk('public')->url($attachment->file_path) }}"
                            target="_blank"
                            class="p-1.5 rounded-md border border-blue-200 text-blue-600 hover:bg-blue-50">
                                View
                            </a>

                            <a href="{{ route('ticket.attachments.download',$attachment) }}"
                            class="p-1.5 rounded-md border border-gray-200 text-gray-700 hover:bg-gray-100">
                                Download
                            </a>

                        </div>

                    </div>
                    @empty
                    <div class="py-3 text-sm text-gray-400">
                        Tidak ada file.
                    </div>
                @endforelse
            </div>

            {{-- <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-4">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="14" rx="2"/><polyline points="3 9 12 13 21 9"/></svg>
                    Pesan
                </h2>

                <div class="min-h-[80px] mb-4 space-y-3">
                    @forelse($ticket->messages ?? [] as $message)
                    <div class="bg-gray-50 rounded-lg px-4 py-3">
                        <div class="flex justify-between items-center mb-1">
                            <p class="text-sm font-semibold text-gray-800">{{ $message->sender->name }}</p>
                            <p class="text-xs text-gray-400">{{ $message->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-sm text-gray-600">{{ $message->body }}</p>
                    </div>
                    @empty
                    <div class="flex items-center justify-center h-16 text-sm text-gray-400">
                        Tidak ada pesan.
                    </div>
                    @endforelse
                </div>

                <div class="flex items-center gap-3">
                    <input
                        type="text"
                        placeholder="Tulis pesan..."
                        class="flex-1 rounded-lg border border-gray-200 px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2.5 rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
                        Kirim
                    </button>
                </div>
            </div> --}}

            <div class="bg-white rounded-xl border border-gray-200 p-6">

                <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                    Timeline
                </h2>

                <div class="relative">

                    <div class="absolute left-3 top-0 bottom-0 w-px bg-gray-200"></div>

                    <div class="space-y-5">

                        @forelse($ticket->ticketLogs as $log)

                            <div class="relative flex gap-4">

                                <div class="relative z-10 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center">

                                    <svg class="w-3 h-3 text-white"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2.5"
                                        viewBox="0 0 24 24">
                                        <polyline points="20 6 9 17 4 12"/>
                                    </svg>

                                </div>

                                <div class="flex-1">

                                    <div class="flex justify-between items-center">

                                        <h4 class="text-sm font-semibold text-gray-800">
                                            {{ $log->activity }}
                                        </h4>

                                        <span class="text-xs text-gray-400">
                                            {{ $log->created_at->diffForHumans() }}
                                        </span>

                                    </div>

                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $log->description }}
                                    </p>

                                    @if($log->user)
                                        <p class="text-xs text-gray-400 mt-1">
                                            oleh {{ $log->user->name }}
                                        </p>
                                    @endif

                                </div>

                            </div>

                        @empty

                            <div class="text-center py-8 text-gray-400 text-sm">
                                Belum ada aktivitas.
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

       
        <div class="w-72 shrink-0">
            {{-- SLA Info Card --}}
            @php
                $ruleLog = $ticket->ruleLogs->first();
            @endphp

            @if($ruleLog)
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-5">
                <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    SLA
                </h2>

                {{-- SLA Status Badge --}}
                @php
                    $slaColors = [
                        'on_time' => 'bg-green-100 text-green-700 border-green-200',
                        'warning' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                        'breach'  => 'bg-red-100 text-red-700 border-red-200',
                        'pending' => 'bg-gray-100 text-gray-700 border-gray-200',
                    ];
                    $slaColor = $slaColors[$ruleLog->status] ?? $slaColors['pending'];
                @endphp
                <div class="mb-5">
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium border {{ $slaColor }}">
                        @if($ruleLog->status === 'breach')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        @elseif($ruleLog->status === 'warning')
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        @else
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        @endif
                        {{ ucwords(str_replace('_', ' ', $ruleLog->status)) }}
                    </span>
                </div>

                {{-- Response Deadline --}}
                <div class="border-l-4 border-blue-400 bg-blue-50/50 rounded-r-lg p-3 mb-3">
                    <p class="text-xs text-gray-500 font-medium mb-1 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 17 20 12 15 7"/><polyline points="9 7 4 12 9 17"/></svg>
                        Response Deadline
                    </p>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $ruleLog->response_deadline->isoFormat('D MMMM') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $ruleLog->response_deadline->isoFormat('HH:mm') }}
                        @if($ruleLog->first_response_at)
                            <span class="text-green-600 ml-2">✓ {{ $ruleLog->first_response_at->isoFormat('D MMM HH:mm') }}</span>
                        @endif
                    </p>

                    <div
                        id="responseCountdown"
                        class="mt-2 text-sm font-semibold text-blue-600">
                        --
                    </div>
                </div>

                {{-- Resolution Deadline --}}
                <div class="border-l-4 border-purple-400 bg-purple-50/50 rounded-r-lg p-3">
                    <p class="text-xs text-gray-500 font-medium mb-1 flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 17 20 12 15 7"/><polyline points="9 7 4 12 9 17"/></svg>
                        Resolution Deadline
                    </p>
                    <p class="text-sm font-semibold text-gray-800">
                        {{ $ruleLog->resolution_deadline->isoFormat('D MMMM') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $ruleLog->resolution_deadline->isoFormat('HH:mm') }}
                        @if($ruleLog->resolved_at)
                            <span class="text-green-600 ml-2">✓ {{ $ruleLog->resolved_at->isoFormat('D MMM HH:mm') }}</span>
                        @endif
                    </p>
                    <div
                        id="resolutionCountdown"
                        class="mt-2 text-sm font-semibold text-blue-600">
                        --
                    </div>
                </div>
            </div>
            @endif

            {{-- Actions Card --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 sticky top-6">
                <h2 class="text-base font-semibold text-gray-800 flex items-center gap-2 mb-5">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Actions
                </h2>

                @if ($user->isAdmin())
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                            Dipindahkan ke
                        </h3>
                        <span class="text-xs text-gray-400">Support</span>
                    </div>
                    <form action="{{ route('tickets.assign',$ticket) }}" method="POST">
                        @csrf

                        <select
                            name="assigned_to"
                            class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-700 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white cursor-pointer">
                            @foreach($supports as $support)
                                <option
                                    value="{{ $support->id }}"
                                    @selected($ticket->assigned_to == $support->id)>

                                    {{ $support->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Update Tim Teknis
                        </button>
                    </form>
                </div>
                @endif

                @if ($user->isAdmin() || $user->isSupport())
                <div class="border border-gray-200 rounded-lg p-4 mb-4">
                    <h3 class="text-sm font-semibold text-gray-700 flex items-center gap-1.5 mb-3">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        Update Status
                    </h3>
                    <form action="{{ route('tickets.changeStatus',$ticket) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <select class="w-full rounded-lg border border-gray-200 px-3 py-2.5 text-sm text-gray-700 mb-3 focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none bg-white cursor-pointer" name="status">
                            <option value="open" {{ ($ticket->status ?? 'open') === 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ ($ticket->status ?? '') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="pending" {{ ($ticket->status ?? '') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="resolved" {{ ($ticket->status ?? '') === 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="cancelled" {{ ($ticket->status ?? '') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>

                        <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2.5 rounded-lg transition-colors cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            Update Status
                        </button>
                    </form>
                </div>
                @endif

                @if ($user->isAdmin() || $user->isSupport())
                    @if($ticket->status !== 'closed')
                        <div class="border border-red-100 bg-red-50 rounded-lg p-4">

                            <form action="{{ route('tickets.close', $ticket) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menutup tiket ini?')">
                                @csrf

                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white text-sm font-medium py-2.5 rounded-lg">
                                    Tutup Tiket
                                </button>
                            </form>

                            <p class="text-xs text-red-500 text-center mt-2">
                                Tiket akan ditutup dan tidak dapat diproses kembali.
                            </p>

                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
    <script>

    const responseDeadline = @json(optional($ruleLog)->response_deadline);

    const resolutionDeadline = @json(optional($ruleLog)->resolution_deadline);

    function updateCountdown(deadline, elementId){

        if(!deadline) return;

        const end = new Date(deadline);

        const now = new Date();

        let diff = end - now;

        if(diff <= 0){

            document.getElementById(elementId).innerHTML = "Expired";

            return;
        }

        const totalSeconds = Math.floor(diff / 1000);

        const days = Math.floor(totalSeconds / 86400);

        const hours = Math.floor((totalSeconds % 86400) / 3600);

        const minutes = Math.floor((totalSeconds % 3600) / 60);

        const seconds = totalSeconds % 60;

        const hh = String(hours).padStart(2, '0');
        const mm = String(minutes).padStart(2, '0');
        const ss = String(seconds).padStart(2, '0');

        let text = `${hh}:${mm}:${ss}`;

        if (days > 0) {
            text = `${days}d ${text}`;
        }

        document.getElementById(elementId).textContent = text;
    }
    setInterval(function(){

            updateCountdown(
                responseDeadline,
                "responseCountdown"
            );

            updateCountdown(
                resolutionDeadline,
                "resolutionCountdown"
            );

        },1000);
    </script>
@endpush