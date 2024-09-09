<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContainerRequest;
use Illuminate\Http\Request;
use App\Models\Container;
use Inertia\Inertia;

class ContainerController extends Controller
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
        $data = Container::all();

        return Inertia::render('Container/index', [
            'datas' => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Container/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContainerRequest $request)
    {
        $container = Container::create([
            'name' => $request->name,
            'latitude' => floatval($request->latitude),
            'longitude' => floatval($request->longitude)
        ]);

        return redirect()->route('container.index')->with('success', 'Container created successfully.');
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
        $data = Container::findOrFail($id);
        $data->latitude = strval($data->latitude);
        $data->longitude = strval($data->longitude);

        return Inertia::render('Container/edit', [
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContainerRequest $request, string $id)
    {
        $container = Container::findOrFail($id);
        $container->update([
            'name' => $request->name,
            'latitude' => floatval($request->latitude),
            'longitude' => floatval($request->longitude)
        ]);

        return redirect()->route('container.index')->with('success', 'Container updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $container = Container::findOrFail($id);
        $container->delete();

        return redirect()->route('container.index')->with('success', 'Container deleted successfully.');
    }
}
