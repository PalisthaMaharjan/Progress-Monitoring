<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TowerController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Projects API routes
Route::prefix('v1')->group(function () {
    Route::get('/projects', [ProjectController::class, 'index'])->name('api.projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('api.projects.show');
    
    // Towers API routes
    Route::get('/towers', [TowerController::class, 'index'])->name('api.towers.index');
    Route::get('/towers/{tower}', [TowerController::class, 'show'])->name('api.towers.show');
});
