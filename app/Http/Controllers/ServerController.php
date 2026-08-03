<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreServerRequest;
use App\Http\Requests\UpdateServerRequest;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index(Request $request)
    {
        $query = Server::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('catatan', 'like', "%{$search}%");
            });
        }

        // Sorting
        $query->latest();

        $servers = $query
            ->paginate($request->per_page ?? 10)
            ->withQueryString();


        return view('servers.index', compact('servers'));
    }

    public function create()
    {
        return view('servers.create');
    }

    public function store(StoreServerRequest $request)
    {
        $validated = $request->validated();

        Server::create([
            'nama' => $validated['nama'],
            'ip_address' => $validated['ip_address'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('servers.index')
            ->with('success', 'Server berhasil ditambahkan!');
    }

    public function show(Server $server) {}

    public function edit(Server $server)
    {
        return view('servers.edit', compact('server'));
    }

    public function update(UpdateServerRequest $request, Server $server)
    {
        $validated = $request->validated();

        $server->update([
            'nama' => $validated['nama'],
            'ip_address' => $validated['ip_address'] ?? null,
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()->route('servers.index')
            ->with('success', 'Server berhasil diupdate!');
    }

    public function destroy(Server $server)
    {
        $server->delete();

        return redirect()->route('servers.index')
            ->with('success', 'Server berhasil dihapus!');
    }
}
