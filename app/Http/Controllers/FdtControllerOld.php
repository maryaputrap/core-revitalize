<?php

namespace App\Http\Controllers;

use App\Models\Container;
use App\Models\Core;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FdtControllerOld extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fdts = Container::where('code', 'FDT')->get();

        return view('dashboard.containers.fdt.index', compact('fdts'));
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $container = Container::create([
            'code' => "FDT",
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
        // Mengambil semua data POP
        $pop = Container::all();

        // Mengambil semua Container dengan hardwares yang memiliki code ODF atau Best Tray
        $containers = Container::with(['hardwares' => function ($query) {
            $query->whereIn('code', ['ODF', 'BEST_TRAY']);
        }])->get();

        // Mengelompokkan hasil berdasarkan jenis hardware
        $odf = [];
        $best_tray = [];

        foreach ($containers as $container) {
            foreach ($container->hardwares as $hardware) {
                if ($hardware->code == 'ODF') {
                    $olt[] = $hardware;
                } elseif ($hardware->code == 'BEST_TRAY') {
                    $odf[] = $hardware;
                }
            }
        }

        // Mengambil data cores (hubungan antara port OLT dan ODF)
        $cores = Core::with(['parentCore', 'Cores'])->get();

        // Mengambil semua port OLT dan ODF
        $odfPorts = Port::whereHas('hardware', function ($query) {
            $query->where('code', 'ODF');
        })->get();

        $btPorts = Port::whereHas('hardware', function ($query) {
            $query->where('code', 'BEST_TRAY');
        })->get();

        return view('dashboard.containers.fdt.view', compact('best_tray', 'odf', 'pop', 'cores', 'btPorts', 'odfPorts'));
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
