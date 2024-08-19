<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectionRequest;
use App\Models\Endpoint;
use App\Models\Port;
use App\Services\ConnectionService;
use Exception;
use App\Models\Connection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class ConnectionController extends Controller
{
    protected string $viewPrefix = 'Connection';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Endpoint $endpoint)
    {
        $connections = $endpoint->connections()->get();

        return Inertia::render($this->viewComponent('Index'), [
            'endpoint' => $endpoint,
            'connections' => $connections
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Endpoint $endpoint, ConnectionRequest $request)
    {
        try {
            $sv = new ConnectionService();
            $sv->create($request->validated());
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

        return redirect()->route('connection.index')->with('success', 'Connection created successfully.');
    }

    public function connect(Endpoint $endpoint, Request $request): RedirectResponse
    {
        $request->validate([
            'from_port_id' => ['required', new ExistsByHash(Port::class)],
            'to_port_id' => ['required', new ExistsByHash(Port::class)],
        ]);

        $fromPort = Port::byHash($request->from_port_id);
        $toPort = Port::byHash($request->to_port_id);

        $fromPort->toPorts()->sync($toPort);

        $fromPort->is_connected = true;
        $fromPort->save();

        $toPort->is_connected = true;
        $toPort->save();

        return redirect()->route('endpoint.show', $endpoint->hash)->with('success', 'Connection created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function disconnect(Endpoint $endpoint, Port $port): RedirectResponse
    {
        foreach ($port->toPorts as $toPort) {
            $toPort->is_connected = false;
            $toPort->save();
        }

        $port->toPorts()->detach();
        $port->is_connected = false;

        return redirect()->route('endpoint.show', $endpoint->hash)->with('success', 'Connection deleted successfully.');
    }
}
