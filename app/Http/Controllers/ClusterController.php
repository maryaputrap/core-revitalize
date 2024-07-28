<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClusterRequest;
use Illuminate\Http\Request;
use App\Models\Cluster;
use Inertia\Inertia;

class ClusterController extends Controller
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
        $data = Cluster::all();

        return Inertia::render('Cluster/Index', [
            'datas' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Cluster/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClusterRequest $request)
    {
        $cluster = Cluster::create([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => floatval($request->latitude),
            'longitude' => floatval($request->longitude)
        ]);

        return redirect()->route('cluster.index')->with('success', 'Cluster created successfully.');
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
        $data = Cluster::findOrFail($id);
        $data->latitude = strval($data->latitude);
        $data->longitude = strval($data->longitude);

        return Inertia::render('Cluster/Edit', [
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClusterRequest $request, string $id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->update([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => floatval($request->latitude),
            'longitude' => floatval($request->longitude)
        ]);

        return redirect()->route('cluster.index')->with('success', 'Cluster updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();

        return redirect()->route('cluster.index')->with('success', 'Cluster deleted successfully.');
    }
}
