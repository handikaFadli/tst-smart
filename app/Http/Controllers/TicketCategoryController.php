<?php

namespace App\Http\Controllers;

use App\Models\TicketCategory;
use App\Http\Requests\StoreTicketCategoryRequest;
use App\Http\Requests\UpdateTicketCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketCategoryController extends Controller
{

    public function index(Request $request)
    {
        $query = TicketCategory::query();

        // Search hanya berdasarkan nama kategori
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('nama', 'like', "%{$search}%");
        }

        $categories = $query
            ->orderByDesc('created_at')
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        $user = Auth::user();

        return view('ticket_categories.index', compact('categories', 'user'));
    }

    public function create()
    {
        return view('ticket_categories.create');
    }

    public function store(StoreTicketCategoryRequest $request)
    {
        $validated = $request->validated();

        $validated['is_active'] = $request->boolean('is_active');

        TicketCategory::create($validated);

        return redirect()
            ->route('ticket-categories.index')
            ->with('success', 'Ticket category created');
    }

    public function show(TicketCategory $ticketCategory)
    {
        return view('ticket_categories.show', compact('ticketCategory'));
    }

    public function edit(TicketCategory $ticketCategory)
    {
        return view('ticket_categories.edit', compact('ticketCategory'));
    }

    public function update(UpdateTicketCategoryRequest $request, TicketCategory $ticketCategory)
    {
        $validated = $request->validated();
        $validated['is_active'] = $request->boolean('is_active');

        $ticketCategory->update($validated);

        return redirect()
            ->route('ticket-categories.index')
            ->with('success', 'Ticket category updated');
    }

    public function destroy(TicketCategory $ticketCategory)
    {
        $ticketCategory->delete();

        return redirect()
            ->route('ticket-categories.index')
            ->with('success', 'Ticket category deleted');
    }
}
