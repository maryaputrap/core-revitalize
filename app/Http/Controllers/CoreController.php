<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoreRequest;
use App\Models\Core;
use Illuminate\Http\Request;

class CoreController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CoreRequest $request)
    {
        $core = Core::create($request->all());

        return response()->json(['id' => $core->id]);
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
    public function update(CoreRequest $request, string $id)
    {
        $core = Core::findorfail($id);
        $core->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $core = Core::findOrFail($id);
        $core->delete();
    }
}
