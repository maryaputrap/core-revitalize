<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContainerRequest;
use Illuminate\Http\Request;
use App\Models\Connection;
use Inertia\Inertia;

class ConnectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Connection::all();

        return Inertia::render('Connection/index', [
            'datas' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Connection/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ConnectionRequest $request)
    {
        $connection = Connection::create([
            'code' => $request->code,
            'name' => $request->name,
            'latitude' => floatval($request->latitude),
            'longitude' => floatval($request->longitude)
        ]);

        return redirect()->route('connection.index')->with('success', 'Connection created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Connection::findOrFail($id);
        $data->latitude = strval($data->latitude);
        $data->longitude = strval($data->longitude);

        return Inertia::render('Connection/edit', [
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConnectionRequest $request, string $id)
    {
        $connection = Conenction::findOrFail($id);
        $conenction->update([
            'code' => $request->code,
            'name' => $request->name,
            'latitude' => floatval($request->latitude),
            'longitude' => floatval($request->longitude)
        ]);

        return redirect()->route('conenction.index')->with('success', 'Conenction updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $connection = Connection::findOrFail($id);
        $connection->delete();

        return redirect()->route('connection.index')->with('success', 'Connection deleted successfully.');
    }
}
