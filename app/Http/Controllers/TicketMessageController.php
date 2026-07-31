<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketMessageRequest;
use App\Models\Ticket;
use App\Models\TicketLog;
use App\Models\TicketMessage;
use App\Services\TicketSlaService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class TicketMessageController extends Controller
{
    public function store(StoreTicketMessageRequest $request, Ticket $ticket, TicketSlaService $slaService): RedirectResponse
    {
        $validated = $request->validated();

        $message = TicketMessage::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'is_internal' => (bool) ($validated['is_internal'] ?? false),
        ]);

        if (auth()->user()->role === 'support') {
            $slaService->markFirstResponse($ticket, now());
        }

        TicketLog::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'activity' => 'ticket.message.sent',
            'description' => 'Pesan dikirim',
        ]);

        $user = $message->user;
        $occurredAt = Carbon::parse($message->created_at);

        if ($user && ($user->isSupport() || $user->isLeader()) && empty($ticket->latestRuleLog(true)?->first_response_at)) {
            $slaService->markFirstResponse($ticket, $occurredAt);

            TicketLog::query()->create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'activity' => 'sla.first_response',
                'description' => 'First response tercatat',
            ]);
        }

        return redirect()->route('tickets.show', $ticket)->with('success', 'Message sent');
    }
}
