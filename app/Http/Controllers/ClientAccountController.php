<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientAccountRequest;
use App\Http\Requests\UpdateClientAccountRequest;
use App\Models\Client;
use App\Models\ClientAccount;
use App\Models\ClientApp;
use Illuminate\Http\Request;

class ClientAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with(['app.accounts', 'app'])->get();

        return view('accounts.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientApps = ClientApp::select('id', 'client_id')->with('client')->get();
        return view('accounts.create', compact('clientApps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientAccountRequest $request)
    {
        $validated = $request->validated();
        $clientId = $validated['client_app_id'];
        $accountsData = $validated['accounts'];

        foreach ($accountsData as $accountData) {
            $accountData['client_app_id'] = $clientId;
            $accountData['is_active'] = true;
            ClientAccount::create($accountData);
        }

        $count = count($accountsData);
        return redirect()->route('accounts.index')
            ->with('success', "$count akun client berhasil dibuat.");
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientAccount $account)
    {
        $client = Client::with([
            'app.features',
            'accounts',
        ])->findOrFail($account->client_id);

        // Pastikan accounts yang ditampilkan hanya milik client ini
        $accounts = ClientAccount::where('client_id', $client->id)
            ->orderBy('id')
            ->get();

        return view('accounts.show', compact('client', 'account', 'accounts'));
    }

    /**
     * Show the form for editing the specified resource.
     * This now redirects to bulk edit by client.
     */

    public function edit(ClientAccount $account)
    {
        $account->load([
            'app.client',
            'app.accounts',
        ]);

        $clientApp = $account->app;

        $client = $clientApp->client;

        $existingAccountIds = $clientApp->accounts
            ->pluck('id')
            ->toArray();

        return view('accounts.edit', [
            'account'   => $account,
            'client'    => $account->app->client,
            'clientApp' => $account->app,
            'existingAccountIds' => $existingAccountIds,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientAccountRequest $request, ClientAccount $account)
    {
        $validated = $request->validated();

        $clientAppId = $validated['client_app_id'];

        $accountsData = $validated['accounts'];

        $requestAccountIds = collect($accountsData)
            ->pluck('client_account_id')
            ->filter()
            ->values()
            ->toArray();

        /*
    |--------------------------------------------------------------------------
    | Hapus akun yang tidak dikirim lagi
    |--------------------------------------------------------------------------
    */

        $query = ClientAccount::where('client_app_id', $clientAppId);

        if (!empty($requestAccountIds)) {
            $query->whereNotIn('id', $requestAccountIds);
        }

        $query->delete();

        /*
    |--------------------------------------------------------------------------
    | Update / Create
    |--------------------------------------------------------------------------
    */

        foreach ($accountsData as $data) {

            $accountId = $data['client_account_id'] ?? null;

            unset($data['client_account_id']);

            $data['client_app_id'] = $clientAppId;
            $data['is_active'] = true;

            if ($accountId) {

                ClientAccount::where('id', $accountId)
                    ->where('client_app_id', $clientAppId)
                    ->update($data);
            } else {

                ClientAccount::create($data);
            }
        }

        return redirect()
            ->route('accounts.index')
            ->with('success', 'Akun client berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientAccount $account)
    {
        $client_app_id = $account->client_app_id;

        ClientAccount::where('client_app_id', $client_app_id)->delete();

        return redirect()->route('accounts.index')
            ->with('success', 'Semua akun pada client berhasil dihapus.');
    }
}
