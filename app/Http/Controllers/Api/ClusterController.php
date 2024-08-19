<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use Illuminate\Http\JsonResponse;

class ClusterController extends Controller
{
    public function index(): JsonResponse
    {
        $clusters = Cluster::query()->orderBy('name')->get([
            'id',
            'name',
        ]);

        return response()->json($clusters);
    }
}
