<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\TrainingCenterController;


Route::get('/', function () {
    return view('welcome');
});

// Rutas para Áreas
Route::get('/areas', [AreaController::class, 'index'])->name('areas.index');
Route::get('/areas/{id}', [AreaController::class, 'show'])->name('areas.show');

// Rutas para Computadores
Route::get('/computers', [ComputerController::class, 'index'])->name('computers.index');
Route::get('/computers/{id}', [ComputerController::class, 'show'])->name('computers.show');

// Rutas para Centros de Formación
Route::get('/training-centers', [TrainingCenterController::class, 'index'])->name('training_centers.index');
Route::get('/training-centers/{id}', [TrainingCenterController::class, 'show'])->name('training_centers.show');
