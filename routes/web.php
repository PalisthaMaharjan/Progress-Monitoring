<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TowerController;

Route::get('/', [ProjectController::class, 'index'])->name('home');

Route::resource('projects', ProjectController::class);
Route::resource('towers', TowerController::class);
