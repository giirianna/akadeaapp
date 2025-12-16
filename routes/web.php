<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SppController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentExamController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', function () {
    return view('landing');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Modul ujian Guru (examteachers) 
Route::middleware(['web'])->prefix('examteachers')->name('exams.')->group(function () {
    Route::get('/', [ExamController::class, 'index'])->name('index');
    Route::get('/create', [ExamController::class, 'create'])->name('create');
    Route::post('/', [ExamController::class, 'store'])->name('store');
    Route::get('/{exam}', [ExamController::class, 'show'])->name('show');
    Route::get('/{exam}/submissions', [ExamController::class, 'submissions'])->name('submissions'); // ← BARU
    
    // route edit & delete
    Route::get('/{exam}/edit', [ExamController::class, 'edit'])->name('edit');
    Route::put('/{exam}', [ExamController::class, 'update'])->name('update');
    Route::delete('/{exam}', [ExamController::class, 'destroy'])->name('destroy');
});

// Modul ujian Siswa (examstudents)
Route::middleware(['web'])->prefix('examstudents')->name('student.exams.')->group(function () {
    Route::get('/', [StudentExamController::class, 'index'])->name('index');
    Route::get('/{exam}/take', [StudentExamController::class, 'take'])->name('take');
    Route::post('/{exam}/submit', [StudentExamController::class, 'submit'])->name('submit');
});

// Resource routes existing
Route::resource('students', StudentController::class);
Route::resource('spp', SppController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('subjects', SubjectController::class);

// Language Switcher
Route::post('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');

// Role Management Routes
Route::middleware('auth')->group(function () {
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/{user}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{user}', [RoleController::class, 'update'])->name('roles.update');
});

require __DIR__.'/auth.php';