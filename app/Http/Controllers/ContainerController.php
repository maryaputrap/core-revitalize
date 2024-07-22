<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContainerRequest;
use Illuminate\Http\Request;
use App\Models\Container;

class ContainerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContainerRequest $request)
    {
        $container = Container::create($request->all());

        return response()->json(['id' => $container->id]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContainerRequest $request, string $id)
    {
        $container = Container::findOrFail($id);
        $container->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $container = Container::findOrFail($id);
        $container->delete();
    }
}
