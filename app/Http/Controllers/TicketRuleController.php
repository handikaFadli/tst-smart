<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use App\Models\TicketRule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TicketRuleController extends Controller
{
    public function index(): View
    {
        $rules = TicketRule::query()
            ->with('category')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view(
            'ticket_rules.index',
            [
                'rules' => $rules,
                'user' => Auth::user(),

            ]
        );
    }

    public function create(): View
    {
        $categories = TicketCategory::query()
            ->where('is_active', true)
            ->orderBy('nama')
            ->get();

        return view('ticket_rules.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama_rule'      => 'required|string|max:255',
            'category_id'    => 'required|exists:ticket_categories,id',
            'priority'       => 'required|in:low,medium,high',
            'response_time'  => 'required|integer|min:1',
            'resolution_time' => 'required|integer|min:1',
            'is_active'      => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        TicketRule::query()->create($validated);

        return redirect()
            ->route('ticket-rules.index')
            ->with('success', 'SLA Rule created successfully.');
    }

    public function show(TicketRule $ticketRule): View
    {
        $ticketRule->load('category');

        return view('ticket_rules.show', compact('ticketRule'));
    }

    public function edit(TicketRule $ticketRule): View
    {
        $categories = TicketCategory::query()
            ->where('is_active', true)
            ->orderBy('nama')
            ->get();

        return view('ticket_rules.edit', compact('ticketRule', 'categories'));
    }

    public function update(Request $request, TicketRule $ticketRule): RedirectResponse
    {
        $validated = $request->validate([
            'nama_rule'      => 'required|string|max:255',
            'category_id'    => 'required|exists:ticket_categories,id',
            'priority'       => 'required|in:low,medium,high',
            'response_time'  => 'required|integer|min:1',
            'resolution_time' => 'required|integer|min:1',
            'is_active'      => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $ticketRule->update($validated);

        return redirect()
            ->route('ticket-rules.index')
            ->with('success', 'SLA Rule updated successfully.');
    }

    public function destroy(TicketRule $ticketRule): RedirectResponse
    {
        $ticketRule->delete();

        return redirect()
            ->route('ticket-rules.index')
            ->with('success', 'SLA Rule deleted successfully.');
    }
}
