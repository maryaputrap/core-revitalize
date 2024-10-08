<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EndpointController;
use App\Http\Controllers\FDTController;
use App\Http\Controllers\JBController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\ConnectionController;
use Illuminate\Support\Facades\Route;
use Telegram\Bot\Laravel\Facades\Telegram;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('dashboard')->group(function () {

        Route::resource('cluster', ClusterController::class);
        Route::resource('container', ContainerController::class);
        Route::resource('endpoint', EndpointController::class);
        Route::resource('fdt', FDTController::class, ['parameters' => ['fdt' => 'endpoint']]);
        Route::resource('jb', JBController::class, ['parameters' => ['jb' => 'endpoint']]);

        Route::post('endpoint/{endpoint}/connection/connect', [ConnectionController::class, 'connect'])->name('connection.connect');
        Route::post('endpoint/{endpoint}/connection/{port}', [ConnectionController::class, 'disconnect'])->name('connection.disconnect');
    });
});

Route::post('/webhook', function () {
    Telegram::commandsHandler(true);
});

require __DIR__ . '/auth.php';
