<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\studentController;
use App\Http\Controllers\sppController;
use App\Http\Controllers\TeacherController;
<<<<<<< HEAD
use App\Http\Controllers\SubjectController;
=======
>>>>>>> 003c79269805b833399a5fc59703b21e24fe9c41
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('students', StudentController::class);
Route::resource('spp', SppController::class);
Route::resource('teachers', TeacherController::class);

Route::resource('teachers', TeacherController::class);
Route::resource('subjects', SubjectController::class);

require __DIR__.'/auth.php';
