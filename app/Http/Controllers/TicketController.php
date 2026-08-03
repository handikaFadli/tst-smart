<?php

namespace App\Http\Controllers;

use App\Exports\SlaMonitoringExport;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Product;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketCategory;
use App\Models\TicketLog;
use App\Models\TicketRuleLog;
use App\Models\User;
use App\Services\TicketSlaService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::query()->with([
            'client',
            'category',
            'assignedTo',
            'createdBy',
            'ruleLogs',
        ]);

        // Filter by Search
        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('kode_ticket', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('category', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by Category
        $selectedCategory = null;

        if ($request->filled('kategori')) {
            $selectedCategory = TicketCategory::find($request->kategori);

            $query->where('category_id', $request->kategori);
        }

        // Filter by Product — filter tickets whose client has an app with the given product_id
        $selectedProduct = null;

        if ($request->filled('jenis')) {
            $selectedProduct = Product::find($request->jenis);

            $query->whereHas('client.app.product', function ($q) use ($request) {
                $q->where('products.id', $request->jenis);
            });
        }

        $perPage = $request->integer('per_page', 10);

        $tickets = $query->latest()->paginate($perPage)->withQueryString();

        // Statistik tiket per status
        $stats = [
            'open'        => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'pending'     => Ticket::where('status', 'pending')->count(),
            'resolved'    => Ticket::where('status', 'resolved')->count(),
            'closed'      => Ticket::where('status', 'closed')->count(),
        ];

        // Data untuk dropdown filter dinamis
        $categories = TicketCategory::where('is_active', true)->orderBy('nama')->get();
        $products   = Product::orderBy('nama')->get();

        $user = Auth::user();

        return view('tickets.index', [
            'tickets' => $tickets,
            'stats' => $stats,
            'categories' => $categories,
            'products' => $products,
            'user' => $user,
            'selectedCategory' => $selectedCategory,
            'selectedProduct' => $selectedProduct,
        ]);
    }

    /**
     * Monitoring SLA — menampilkan status SLA seluruh ticket.
     */
    public function monitoringSla(Request $request)
    {
        $tickets = Ticket::query()
            ->with([
                'client',
                'category',
                'assignedTo',
                'ruleLogs.rule',
            ])
            ->whereIn('status', ['open', 'in_progress', 'pending', 'resolved']);

        // Filter by Search
        if ($request->filled('search')) {

            $search = $request->search;

            $tickets->where(function ($q) use ($search) {

                $q->where('judul', 'like', "%{$search}%")
                    ->orWhere('kode_ticket', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q2) use ($search) {
                        $q2->where('nama', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by SLA status
        $slaStatus = $request->sla_status;
        if ($slaStatus && in_array($slaStatus, ['on_time', 'warning', 'breach'])) {
            $tickets->whereHas('ruleLogs', function ($q) use ($slaStatus) {
                $q->where('status', $slaStatus);
            });
        }

        $perPage = $request->integer('per_page', 10);

        $tickets = $tickets->latest()->paginate($perPage)->withQueryString();

        // Statistik SLA (overall, tidak terfilter)
        $totalActive = Ticket::whereIn('status', ['open', 'in_progress', 'pending', 'resolved'])->count();

        $slaCounts = TicketRuleLog::query()
            ->whereHas('ticket', function ($q) {
                $q->whereIn('status', ['open', 'in_progress', 'pending', 'resolved']);
            })
            ->selectRaw("
                COUNT(*) as total,
                SUM(CASE WHEN status = 'on_time' THEN 1 ELSE 0 END) as on_time,
                SUM(CASE WHEN status = 'warning' THEN 1 ELSE 0 END) as warning,
                SUM(CASE WHEN status = 'breach' THEN 1 ELSE 0 END) as breach
            ")
            ->first();

        $onTime  = (int) ($slaCounts->on_time ?? 0);
        $warning = (int) ($slaCounts->warning ?? 0);
        $breach  = (int) ($slaCounts->breach ?? 0);
        $total   = max(1, $onTime + $warning + $breach);
        $compliance = round(($onTime / $total) * 100, 1);

        $technicianPerformance = User::query()
            ->where('role', 'support')
            ->withCount([
                'assignedTickets as total_ticket',
                'assignedTickets as solved_ticket' => function ($q) {
                    $q->whereIn('status', ['resolved', 'closed']);
                },
                'assignedTickets as open_ticket' => function ($q) {
                    $q->whereIn('status', ['open', 'in_progress', 'pending']);
                },
                'assignedTickets as breach_ticket' => function ($q) {
                    $q->whereHas('latestRuleLog', function ($sla) {
                        $sla->where('status', 'breach');
                    });
                },
            ])
            ->get()
            ->map(function ($item) {
                $item->success_rate = $item->total_ticket > 0
                    ? round(($item->solved_ticket / $item->total_ticket) * 100, 1)
                    : 0;

                return $item;
            });

        return view('tickets.monitoring_sla', compact(
            'tickets',
            'totalActive',
            'onTime',
            'warning',
            'breach',
            'compliance',
            'technicianPerformance',
            'slaStatus'
        ));
    }

    /**
     * Export data monitoring SLA ke Excel.
     */
    public function exportSlaMonitoring(Request $request)
    {
        $slaStatus = $request->sla_status;

        return Excel::download(
            new SlaMonitoringExport($slaStatus),
            'monitoring-sla-' . now()->format('Y-m-d-H-i') . '.xlsx'
        );
    }

    public function create()
    {
        return view('tickets.create');
    }


    public function store(StoreTicketRequest $request, TicketSlaService $slaService): RedirectResponse
    {
        $validated = $request->validated();

        $ticket = Ticket::query()->create([
            'kode_ticket' => $this->generateTicketCode(),
            'client_id' => $validated['client_id'],
            'created_by' => Auth::id(), //contoh nantinya pake auth()->id()
            'assigned_to' => $validated['assigned_to'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'category_id' => $validated['category_id'],
            'priority' => $validated['priority'],
            'status' => 'open',
        ]);

        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $file) {

                $path = $file->store(
                    'tickets/' . $ticket->kode_ticket,
                    'public'
                );

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => Auth::id(), //contoh nantinya pake auth()->id()
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        $slaService->initializeForNewTicket($ticket);

        TicketLog::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), //contoh nantinya pake auth()->id()
            'activity' => 'ticket.created',
            'description' => sprintf('Ticket %s dibuat', $ticket->kode_ticket),
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket dibuat');
    }


    public function show(Ticket $ticket)
    {
        $ticket->load([
            'category',
            'createdBy',
            'assignedTo',
            'ticketMessages.user',
            'ticketLogs.user',
            'ticketAttachments',
            'ruleLogs.rule',
        ])->loadCount([
            'ticketMessages',
            'ticketLogs',
            'ticketAttachments'
        ]);

        $user = Auth::user();
        $supports = User::where('role', 'support')
            ->orderBy('name')
            ->get();

        return view('tickets.show', compact(
            'ticket',
            'supports',
            'user'
        ));
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', [
            'ticket' => $ticket->load(['client', 'createdBy', 'assignedTo']),
            'categories' => TicketCategory::where('is_active', true)->get(),
        ]);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket): RedirectResponse
    {
        $validated = $request->validated();

        $ticket->update([
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'],
            'category_id' => $validated['category_id'],
            'priority' => $validated['priority'],
        ]);

        if ($request->hasFile('attachments')) {

            foreach ($request->file('attachments') as $file) {

                $path = $file->store(
                    'tickets/' . $ticket->kode_ticket,
                    'public'
                );

                TicketAttachment::create([
                    'ticket_id' => $ticket->id,
                    'user_id' => Auth::id(), //contoh nantinya pake auth()->id()
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        TicketLog::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), //contoh nantinya pake auth()->id()
            'activity' => 'ticket.updated',
            'description' => 'Ticket diperbarui',
        ]);

        return redirect()->route('tickets.index', $ticket)->with('success', 'Ticket updated');
    }

    public function destroy(Ticket $ticket): RedirectResponse
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket deleted');
    }

    public function assign(Request $request, Ticket $ticket)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id'
        ]);

        $old = optional($ticket->assignedTo)->name;

        $ticket->update([
            'assigned_to' => $request->assigned_to
        ]);

        $new = optional($ticket->fresh()->assignedTo)->name;

        TicketLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), //contoh nantinya pake auth()->id()
            'activity' => 'ticket.assigned',
            'description' => "Tim support dipindahkan dari {$old} ke {$new}"
        ]);

        return back()->with('success', 'Assignment berhasil diubah');
    }

    public function changeStatus(Request $request, Ticket $ticket, TicketSlaService $slaService): RedirectResponse
    {
        $oldStatus = $ticket->status;

        $validated = $request->validate([
            'status' => ['required', 'in:open,in_progress,pending,resolved,closed,cancelled'],
        ]);

        $now = Carbon::now();

        if (
            $validated['status'] === 'in_progress'
            && $oldStatus === 'open'
        ) {
            $slaService->markFirstResponse($ticket, $now);
        }

        if (in_array($validated['status'], ['resolved', 'closed'])) {
            $slaService->markResolved($ticket, $now);
        }

        $ticket->update([
            'status' => $validated['status'],
            'resolved_at' => in_array($validated['status'], ['resolved', 'closed'], true) ? $now : $ticket->resolved_at,
            'closed_at' => $validated['status'] === 'closed' ? $now : $ticket->closed_at,
        ]);

        TicketLog::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), //contoh nantinya pake auth()->id()
            'activity' => 'ticket.status_changed',
            'description' => 'Status tiket diubah dari ' . $oldStatus . ' menjadi ' . $validated['status']
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Status updated');
    }

    public function close(Ticket $ticket): RedirectResponse
    {

        if ($ticket->status === 'closed') {
            return back()->with('info', 'Ticket sudah ditutup.');
        }

        $now = Carbon::now();

        $ticket->update([
            'status' => 'closed',
            'resolved_at' => $ticket->resolved_at ?? $now,
            'closed_at' => $now,
        ]);

        TicketLog::query()->create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(), //contoh nantinya pake auth()->id()
            'activity' => 'ticket.closed',
            'description' => 'Ticket ditutup oleh Tim' //.auth()->user()->name
        ]);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket closed');
    }

    private function generateTicketCode(): string
    {
        return 'TCKT-' . '' . Str::upper(Str::random(4));
    }

    public function download(TicketAttachment $attachment)
    {
        $path = Storage::disk('public')->path($attachment->file_path);

        return response()->download($path, $attachment->file_name);
    }
}
