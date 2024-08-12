<?php

namespace App\Http\Controllers;

use App\Http\Requests\EndpointRequest;
use App\Models\Cluster;
use App\Models\Container;
use App\Models\Endpoint;
use App\Services\EndpointService;
use Exception;
use Inertia\Inertia;

class EndpointController extends Controller
{
    protected string $viewPrefix = 'Endpoint';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $endpoints = Endpoint::query()
            ->with('containers')
            ->get();

        return Inertia::render($this->viewComponent('Index'), [
            'endpoints' => $endpoints
        ]);
    }

    public function create(Cluster $cluster)
    {
        /** @var Container $containers */
        $containers = $cluster->containers->only('id', 'name');

        return Inertia::render($this->viewComponent('Form'), [
            'containers' => $containers
        ]);
    }

    public function store(Cluster $cluster, EndpointRequest $request)
    {
        try {
            $sv = new EndpointService();
            $sv->create($request->validated());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('endpoints.index');
    }

    public function show(Cluster $cluster, Endpoint $endpoint)
    {
        $endpoint->load('containers', 'ports');

        return Inertia::render($this->viewComponent('Show'), [
            'endpoint' => $endpoint
        ]);
    }

    public function edit(Cluster $cluster, Endpoint $endpoint)
    {
        $endpoint->load('containers');

        return Inertia::render($this->viewComponent('Form'), [
            'endpoint' => $endpoint
        ]);
    }

    public function update(Cluster $cluster, Endpoint $endpoint, EndpointRequest $request)
    {
        try {
            $sv = new EndpointService();
            $sv->update($endpoint, $request->validated());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('endpoints.index');
    }

    public function destroy(Cluster $cluster, Endpoint $endpoint)
    {
        try {
            $endpoint->ports()->delete();
            $endpoint->delete();
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }

        return redirect()->route('endpoints.index');
    }
}
