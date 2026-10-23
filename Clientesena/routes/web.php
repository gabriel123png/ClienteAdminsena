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
Route::get('/areas/create', [AreaController::class, 'create'])->name('areas.create');
Route::post('/areas', [AreaController::class, 'store'])->name('areas.store');
Route::get('/areas/{id}', [AreaController::class, 'show'])->name('areas.show');
Route::get('/areas/{id}/edit', [AreaController::class, 'edit'])->name('areas.edit');
Route::put('/areas/{id}', [AreaController::class, 'update'])->name('areas.update');
Route::delete('/areas/{id}', [AreaController::class, 'destroy'])->name('areas.destroy');

// Rutas para Computadores
Route::get('/computers', [ComputerController::class, 'index'])->name('computers.index');
Route::get('/computers/{id}', [ComputerController::class, 'show'])->name('computers.show');

// Rutas para Centros de Formación
Route::get('/training-centers', [TrainingCenterController::class, 'index'])->name('training_centers.index');
Route::get('/training-centers/{id}', [TrainingCenterController::class, 'show'])->name('training_centers.show');
