<?php

use App\Http\Controllers\Api\ClusterController;
use App\Http\Controllers\Api\ContainerController;
use App\Http\Controllers\Api\EndpointController;
use App\Http\Controllers\Api\OptionReferenceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->as('api.')->group(function () {
//    Route::get('/user', function (Request $request) {
//        return $request->user();
//    });

    Route::get('/clusters', [ClusterController::class, 'index'])->name('cluster.index');
    Route::get('/clusters/{cluster}/containers', [ContainerController::class, 'index'])->name('container.index');
    Route::get('/containers/{container}/endpoints', [EndpointController::class, 'index'])->name('endpoint.index');
    Route::get('/options/endpoint-types', [OptionReferenceController::class, 'endpointType'])->name('option.endpoint-type');
});
