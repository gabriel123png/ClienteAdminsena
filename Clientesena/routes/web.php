<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\TrainingCenterController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas para Áreas
Route::resource('areas', AreaController::class);
Route::resource('computers', ComputerController::class);
Route::resource('training-centers', TrainingCenterController::class)->names('training_centers');
