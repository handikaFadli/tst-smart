<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use App\Models\ClientApp;
use App\Models\ClientType;
use App\Models\Feature;
use App\Models\Product;
use App\Models\Server;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Client::with([
            'clientType',
            'picTim',
            'app.product',
            'app.server',
            'app.features',
        ]);

        // Filter Status Aplikasi
        if ($request->filled('status') && $request->status != 'semua') {
            $query->whereHas('app', function ($q) use ($request) {
                $q->where('status', $request->status);
            });
        }

        // Filter Jenis Client (Sekolah / Bimbel)
        if ($request->filled('client_type_id') && $request->client_type_id != 'semua') {
            $query->where('client_type_id', $request->client_type_id);
        }

        // Filter Product
        if ($request->filled('product_id') && $request->product_id != 'semua') {
            $query->whereHas('app', function ($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('kode', 'like', "%{$search}%");
            });
        }

        $clients = $query
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('clients.index', [
            'clients'     => $clients,
            'clientTypes' => ClientType::orderBy('nama')->get(),
            'products'    => Product::orderBy('nama')->get(),
            'user' => Auth::user(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view(
            'clients.create',
            [
                'clientType' => ClientType::orderBy('nama')->get(),
                'products'   => Product::orderBy('nama')->get(),
                'servers'    => Server::orderBy('nama')->get(),
                'users'   => User::where('role', 'support')->orWhere('role', 'leader')
                    ->orderBy('name')
                    ->get(),
                'features'   => Feature::orderBy('nama_fitur')->get(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $validated = $request->validated();

        // Generate Kode Client
        $nextId = (Client::withTrashed()->max('id') ?? 0) + 1;

        $kodeClient = 'CL-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        // Simpan Client
        $client = Client::create([
            'kode'            => $kodeClient,
            'nama'            => $validated['nama'],
            'client_type_id'  => $validated['client_type_id'],
            'pic_tim_id'      => $validated['pic_tim_id'],
        ]);

        // Simpan Aplikasi
        $app = ClientApp::create([
            'client_id'          => $client->id,
            'product_id'         => $validated['product_id'],
            'url_aplikasi'       => $validated['url_aplikasi'] ?? null,
            'jumsis'             => $validated['jumsis'] ?? 0,
            'kode_examol'        => $validated['kode_examol'] ?? null,
            'link_presensi'      => $validated['link_presensi'] ?? null,
            'aktivasi_aplikasi'  => $validated['aktivasi_aplikasi'] ?? null,
            'expired_aplikasi'   => $validated['expired_aplikasi'] ?? null,
            'expired_domain'     => $validated['expired_domain'] ?? null,
            'status'             => $validated['status'],
            'server_id'          => $validated['server_id'] ?? null,
            'catatan'            => $validated['catatan'] ?? null,
        ]);

        // Sync fitur
        if ($request->filled('fitur_ids')) {
            $app->features()->sync($request->fitur_ids);
        }

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load([
            'clientType',
            'picTim',
            'app.product',
            'app.server',
            'app.features',
            'app.accounts',
        ]);

        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $client->load([
            'clientType',
            'picTim',
            'app.product',
            'app.server',
            'app.features',
        ]);

        return view('clients.edit', [
            'client'      => $client,
            'clientTypes' => ClientType::orderBy('nama')->get(),
            'products'    => Product::orderBy('nama')->get(),
            'servers'     => Server::orderBy('nama')->get(),
            'supports'    => User::where('role', 'support')
                ->orderBy('name')
                ->get(),
            'features'    => Feature::orderBy('nama_fitur')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $validated = $request->validated();

        // Update Client
        $client->update([
            'nama'           => $validated['nama'],
            'client_type_id' => $validated['client_type_id'],
            'pic_tim_id'     => $validated['pic_tim_id'],
        ]);

        // Cek apakah sudah punya aplikasi
        if ($client->app) {

            $client->app->update([
                'product_id'         => $validated['product_id'],
                'url_aplikasi'       => $validated['url_aplikasi'] ?? null,
                'jumsis'             => $validated['jumsis'] ?? 0,
                'kode_examol'        => $validated['kode_examol'] ?? null,
                'link_presensi'      => $validated['link_presensi'] ?? null,
                'aktivasi_aplikasi'  => $validated['aktivasi_aplikasi'] ?? null,
                'expired_aplikasi'   => $validated['expired_aplikasi'] ?? null,
                'expired_domain'     => $validated['expired_domain'] ?? null,
                'status'             => $validated['status'],
                'server_id'          => $validated['server_id'] ?? null,
                'catatan'            => $validated['catatan'] ?? null,
            ]);

            if ($request->filled('fitur_ids')) {
                $client->app->features()->sync($request->fitur_ids);
            } else {
                $client->app->features()->sync([]);
            }
        } else {

            $app = ClientApp::create([
                'client_id'          => $client->id,
                'product_id'         => $validated['product_id'],
                'url_aplikasi'       => $validated['url_aplikasi'] ?? null,
                'jumsis'             => $validated['jumsis'] ?? 0,
                'kode_examol'        => $validated['kode_examol'] ?? null,
                'link_presensi'      => $validated['link_presensi'] ?? null,
                'aktivasi_aplikasi'  => $validated['aktivasi_aplikasi'] ?? null,
                'expired_aplikasi'   => $validated['expired_aplikasi'] ?? null,
                'expired_domain'     => $validated['expired_domain'] ?? null,
                'status'             => $validated['status'],
                'server_id'          => $validated['server_id'] ?? null,
                'catatan'            => $validated['catatan'] ?? null,
            ]);

            if ($request->filled('fitur_ids')) {
                $app->features()->sync($request->fitur_ids);
            }
        }

        return redirect()
            ->route('clients.index')
            ->with('success', 'Client berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
