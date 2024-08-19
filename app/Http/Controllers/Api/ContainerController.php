<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use Illuminate\Http\JsonResponse;

class ContainerController extends Controller
{
    public function index(Cluster $cluster): JsonResponse
    {
        $containers = $cluster->containers()->orderBy('name')->get([
            'id',
            'name',
        ]);

        return response()->json($containers);
    }
}
