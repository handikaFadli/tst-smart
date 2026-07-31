<?php

namespace App\Http\Controllers;

use App\Models\Feature;
use App\Http\Requests\StoreFeatureRequest;
use App\Http\Requests\UpdateFeatureRequest;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::latest()->paginate(10);

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
