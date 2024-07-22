<?php

namespace App\Http\Controllers;

use App\Http\Requests\HardwareRequest;
use App\Models\Container;
use App\Models\Hardware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $containers = Container::with(['hardwares' => function ($query) {
            $query->where('name', 'OLT');
        }])->get();

        return view('dashboard.containers.index', compact('containers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.containers.create-cluster');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HardwareRequest $request)
    {
        $hardware = Hardware::create($request->all());

        return response()->json(['id' => $hardware->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $container = Container::with('hardwares')->findOrFail($id);
        $containers = Container::with('hardwares')->get();
        return view('dashboard.containers.view', compact('container', 'containers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HardwareRequest $request, string $id)
    {
        $hardware = Hardware::findOrFail($id);
        $hardware->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hardware = Hardware::findOrFail($id);
        $hardware->delete();
    }
}
