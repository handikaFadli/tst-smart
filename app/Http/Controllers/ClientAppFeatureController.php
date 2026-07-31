<?php

namespace App\Http\Controllers;

use App\Models\ClientAppFeature;
use App\Http\Requests\StoreClientAppFeatureRequest;
use App\Http\Requests\UpdateClientAppFeatureRequest;
use App\Models\ClientAccount;

class ClientAppFeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientAppFeatureRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ClientAppFeature $clientAppFeature)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClientAppFeature $clientAppFeature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientAppFeatureRequest $request, ClientAppFeature $clientAppFeature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClientAppFeature $clientAppFeature)
    {
        //
    }
}
