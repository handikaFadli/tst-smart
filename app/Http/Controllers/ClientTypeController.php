<?php

namespace App\Http\Controllers;

use App\Models\ClientType;
use App\Http\Requests\StoreClientTypeRequest;
use App\Http\Requests\UpdateClientTypeRequest;

class ClientTypeController extends Controller
{

    public function index()
    {
        $clientTypes = ClientType::latest()->paginate(10);

        return view('client-types.index', compact('clientTypes'));
    }

    public function create()
    {
        return view('client-types.create');
    }

    public function store(StoreClientTypeRequest $request)
    {
        $validated = $request->validated();

        ClientType::create([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('client-types.index')
            ->with('success', 'Client type berhasil ditambahkan!');
    }

    public function show(ClientType $clientType) {}

    public function edit(ClientType $clientType)
    {
        return view('client-types.edit', compact('clientType'));
    }

    public function update(UpdateClientTypeRequest $request, ClientType $clientType)
    {
        $validated = $request->validated();

        $clientType->update([
            'nama' => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
        ]);

        return redirect()->route('client-types.index')
            ->with('success', 'Client type berhasil diupdate!');
    }

    public function destroy(ClientType $clientType)
    {
        $clientType->delete();

        return redirect()->route('client-types.index')
            ->with('success', 'Client type berhasil dihapus!');
    }
}
