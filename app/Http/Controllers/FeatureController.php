<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index(Request $request)
    {
        $query = Feature::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_fitur', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        // Sorting
        $query->latest();

        $features = $query
            ->paginate($request->per_page ?? 10)
            ->withQueryString();

        return view('features.index', compact('features'));
    }

    public function create()
    {
        return view('features.create');
    }

    public function store(StoreFeatureRequest $request)
    {
        $validated = $request->validated();

        Feature::create([
            'nama_fitur' => $validated['nama_fitur'],
            'kode' => $validated['kode'],
        ]);

        return redirect()->route('features.index')
            ->with('success', 'Feature berhasil ditambahkan!');
    }

    public function show(Feature $feature)
    {
        $feature->load('clientApps');

        return view('features.show', compact('feature'));
    }

    public function edit(Feature $feature)
    {
        return view('features.edit', compact('feature'));
    }

    public function update(UpdateFeatureRequest $request, Feature $feature)
    {
        $validated = $request->validated();

        $feature->update([
            'nama_fitur' => $validated['nama_fitur'],
            'kode' => $validated['kode'],
        ]);

        return redirect()->route('features.index')
            ->with('success', 'Feature berhasil diupdate!');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();

        return redirect()->route('features.index')
            ->with('success', 'Feature berhasil dihapus!');
    }
}
