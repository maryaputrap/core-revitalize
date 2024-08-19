<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Container;
use App\Models\Endpoint;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Veelasky\LaravelHashId\Rules\ExistsByHash;

class EndpointController extends Controller
{
    public function index(Container $container, Request $request): JsonResponse
    {
        $request->validate([
            'except_endpoint_id' => ['sometimes', new ExistsByHash(Endpoint::class)],
        ]);

        $endpoints = $container->endpoints()
            ->when($request->has('except_endpoint_id'), function ($query) use ($request) {
                $query->where('id', '!=', Endpoint::hashToId($request->except_endpoint_id));
            })
            ->with('ports')
            ->orderBy('name')
            ->get([
                'id',
                'name',
            ]);

        return response()->json($endpoints);
    }
}
