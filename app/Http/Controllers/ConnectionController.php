<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnectionRequest;
use App\Models\Endpoint;
use App\Services\ConnectionService;
use Exception;
use App\Models\Connection;
use Inertia\Inertia;

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Endpoint $endpoint, Connection $connection)
    {
        $connection->delete();

        return redirect()->route('connection.index')->with('success', 'Connection deleted successfully.');
    }
}
