<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Models\Endpoint;
use App\Models\Port;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $countCluster = Cluster::count();
        $countEndpoint = Endpoint::count();
        $countPort = Port::count();

        $clusterActivityLog = Cluster::query()
            ->orderBy('created_at', 'desc')
            ->select(
                'id',
                DB::raw(
                    "CONCAT('Cluster ', name, ' berhasil dibuat') as name"
                ),
                DB::raw(
                    "DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at"
                )
            )->get();

        $endpointActivityLog = Endpoint::query()
            ->orderBy('created_at', 'desc')
            ->select(
                'id',
                DB::raw(
                    "DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s') as created_at"
                )
            )->get();

        $activityLog = $clusterActivityLog->concat($endpointActivityLog);
        $activityLog = $activityLog->sortByDesc('created_at')->take(10)->values();


        return Inertia::render('Dashboard', [
            'countCluster' => $countCluster ?? 0,
            'countEndpoint' => $countEndpoint ?? 0,
            'countPort' => $countPort ?? 0,
            'activityLog' => $activityLog
        ]);
    }
}
