<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\AdminDashboardController;

// Page d'accueil publique
Route::get('/', function () {
    return view('welcome');
});

// Toutes les routes où il FAUT être connecté
Route::middleware('auth')->group(function () {
    
    // 1. Routes des profils (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. L'ancien dashboard par défaut (on le garde au cas où)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // 3. NOS NOUVEAUX DASHBOARDS
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/company/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

});

require __DIR__.'/auth.php';