<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\OptionReference\EndpointType;
use Illuminate\Http\JsonResponse;

class OptionReferenceController extends Controller
{
    public function endpointType(): JsonResponse
    {
        $types = EndpointType::query()->orderBy('content')->get([
            'id',
            'content',
        ]);

        return response()->json($types);
    }
}
