<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\TrainingCenterController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseTeacherController;
use App\Http\Controllers\TeacherController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rutas para Áreas
Route::resource('areas', AreaController::class);
Route::resource('computers', ComputerController::class);
Route::resource('training-centers', TrainingCenterController::class)->names('training_centers');
Route::resource('courses', CourseController::class)->except('show');
Route::resource('teachers', TeacherController::class)->except('show');
Route::resource('apprentices', ApprenticeController::class);
Route::resource('course-teachers', CourseTeacherController::class)
    ->except('show')
    ->names('course_teachers');
