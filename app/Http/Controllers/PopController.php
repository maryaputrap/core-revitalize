<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\Core;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PopController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pops = Container::where('code', 'POP')->get();

        return view('dashboard.containers.pop.index', compact('pops'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pop.create-cluster');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $container = Container::create([
            'code' => "POP",
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);

        return response()->json(['id' => $container->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Mengambil semua Container yang memiliki hardware dengan kode POP
        $pop = Container::where('code', 'POP')->get();


        // Mengambil semua Container dengan hardwares yang memiliki code OLT atau ODF
        $containers = Container::with(['hardwares' => function ($query) {
            $query->whereIn('code', ['OLT', 'ODF']);
        }])->get();

        // Mengelompokkan hasil berdasarkan jenis hardware
        $olt = [];
        $odf = [];

        foreach ($containers as $container) {
            foreach ($container->hardwares as $hardware) {
                if ($hardware->code == 'OLT') {
                    $olt[] = $hardware;
                } elseif ($hardware->code == 'ODF') {
                    $odf[] = $hardware;
                }
            }
        }

        // Mengambil data cores (hubungan antara port OLT dan ODF)
        $cores = Core::with(['parentCore', 'Cores'])->get();

        // Mengambil semua port OLT dan ODF
        $oltPorts = Port::whereHas('hardware', function ($query) {
            $query->where('code', 'OLT');
        })->get();

        $odfPorts = Port::whereHas('hardware', function ($query) {
            $query->where('code', 'ODF');
        })->get();

        return view('dashboard.containers.pop.view', compact('olt', 'odf', 'pop', 'cores', 'oltPorts', 'odfPorts'));
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
