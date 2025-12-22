<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CustomRoleController;
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
Route::middleware(['auth', 'permission:exams.view'])->prefix('examteachers')->name('exams.')->group(function () {
    Route::get('/', [ExamController::class, 'index'])->name('index');
    Route::get('/create', [ExamController::class, 'create'])->middleware('permission:exams.create')->name('create');
    Route::post('/', [ExamController::class, 'store'])->middleware('permission:exams.create')->name('store');
    Route::get('/{exam}', [ExamController::class, 'show'])->name('show');
    Route::get('/{exam}/submissions', [ExamController::class, 'submissions'])->middleware('permission:exams.view_submissions')->name('submissions');
    
    // route edit & delete
    Route::get('/{exam}/edit', [ExamController::class, 'edit'])->middleware('permission:exams.edit')->name('edit');
    Route::put('/{exam}', [ExamController::class, 'update'])->middleware('permission:exams.edit')->name('update');
    Route::delete('/{exam}', [ExamController::class, 'destroy'])->middleware('permission:exams.delete')->name('destroy');
});

// Modul ujian Siswa (examstudents)
Route::middleware(['auth', 'permission:exams.view'])->prefix('examstudents')->name('student.exams.')->group(function () {
    Route::get('/', [StudentExamController::class, 'index'])->name('index');
    Route::get('/{exam}/take', [StudentExamController::class, 'take'])->name('take');
    Route::post('/{exam}/submit', [StudentExamController::class, 'submit'])->name('submit');
});

// Resource routes with granular permission middleware
Route::middleware('auth')->group(function () {
    // Students module - granular permissions
    Route::middleware('permission:students.view')->group(function () {
        Route::get('/students', [StudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    });
    Route::post('/students', [StudentController::class, 'store'])->middleware('permission:students.create')->name('students.store');
    Route::get('/students/create', [StudentController::class, 'create'])->middleware('permission:students.create')->name('students.create');
    Route::put('/students/{student}', [StudentController::class, 'update'])->middleware('permission:students.edit')->name('students.update');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->middleware('permission:students.edit')->name('students.edit');
    Route::delete('/students/{student}', [StudentController::class, 'destroy'])->middleware('permission:students.delete')->name('students.destroy');
    
    // SPP module - granular permissions
    Route::middleware('permission:spp.view')->group(function () {
        Route::get('/spp', [SppController::class, 'index'])->name('spp.index');
        Route::get('/spp/{spp}', [SppController::class, 'show'])->name('spp.show');
    });
    Route::post('/spp', [SppController::class, 'store'])->middleware('permission:spp.create')->name('spp.store');
    Route::get('/spp/create', [SppController::class, 'create'])->middleware('permission:spp.create')->name('spp.create');
    Route::put('/spp/{spp}', [SppController::class, 'update'])->middleware('permission:spp.edit')->name('spp.update');
    Route::get('/spp/{spp}/edit', [SppController::class, 'edit'])->middleware('permission:spp.edit')->name('spp.edit');
    Route::delete('/spp/{spp}', [SppController::class, 'destroy'])->middleware('permission:spp.delete')->name('spp.destroy');
    
    // Teachers module - granular permissions
    Route::middleware('permission:teachers.view')->group(function () {
        Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index');
        Route::get('/teachers/{teacher}', [TeacherController::class, 'show'])->name('teachers.show');
    });
    Route::post('/teachers', [TeacherController::class, 'store'])->middleware('permission:teachers.create')->name('teachers.store');
    Route::get('/teachers/create', [TeacherController::class, 'create'])->middleware('permission:teachers.create')->name('teachers.create');
    Route::put('/teachers/{teacher}', [TeacherController::class, 'update'])->middleware('permission:teachers.edit')->name('teachers.update');
    Route::get('/teachers/{teacher}/edit', [TeacherController::class, 'edit'])->middleware('permission:teachers.edit')->name('teachers.edit');
    Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy'])->middleware('permission:teachers.delete')->name('teachers.destroy');
    
    // Subjects module - granular permissions
    Route::middleware('permission:subjects.view')->group(function () {
        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/subjects/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
    });
    Route::post('/subjects', [SubjectController::class, 'store'])->middleware('permission:subjects.create')->name('subjects.store');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->middleware('permission:subjects.create')->name('subjects.create');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->middleware('permission:subjects.edit')->name('subjects.update');
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->middleware('permission:subjects.edit')->name('subjects.edit');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->middleware('permission:subjects.delete')->name('subjects.destroy');
});

// Language Switcher
Route::post('/language/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'id'])) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('language.switch');

// Role Management Routes
Route::middleware('auth')->prefix('roles')->name('roles.')->group(function () {
    // User role assignment (existing functionality) - requires roles.view permission
    Route::middleware('permission:roles.view')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
    });
    
    Route::middleware('permission:roles.assign')->group(function () {
        Route::get('/{user}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{user}', [RoleController::class, 'update'])->name('update');
    });
    
    // Custom role management (new functionality) - requires roles.manage permission
    Route::middleware('permission:roles.manage')->group(function () {
        Route::get('/custom', [CustomRoleController::class, 'index'])->name('custom.index');
        Route::get('/custom/create', [CustomRoleController::class, 'create'])->name('custom.create');
        Route::post('/custom', [CustomRoleController::class, 'store'])->name('custom.store');
        Route::get('/custom/{role}/edit', [CustomRoleController::class, 'edit'])->name('custom.edit');
        Route::put('/custom/{role}', [CustomRoleController::class, 'update'])->name('custom.update');
        Route::delete('/custom/{role}', [CustomRoleController::class, 'destroy'])->name('custom.destroy');
    });
});

require __DIR__.'/auth.php';