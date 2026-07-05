<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\CompanyDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicOfferController;
use App\Http\Controllers\StudentDashboardController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect()->route('offers.public.index');
});

// Espace Public
Route::get('/offres-de-stage', [PublicOfferController::class, 'index'])->name('offers.public.index');
Route::get('/offres-de-stage/{offer}', [PublicOfferController::class, 'show'])->name('offers.public.show');

Route::middleware(['auth'])->group(function () {
    // Dashboards
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::get('/company/dashboard', [CompanyDashboardController::class, 'index'])->name('company.dashboard');
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Candidatures (Étudiant)
    Route::middleware('role:student')->group(function () {
        Route::post('/apply', [ApplicationController::class, 'apply'])->name('apply');
        Route::get('/mes-candidatures', [ApplicationController::class, 'myApplications'])->name('applications.my');
    });

    // Offres (Entreprise)
    Route::middleware('role:company')->prefix('offers')->name('offers.')->group(function () {
        Route::get('/', [OfferController::class, 'index'])->name('index');
        Route::get('/create', [OfferController::class, 'create'])->name('create');
        Route::post('/', [OfferController::class, 'store'])->name('store');
        Route::get('/{offer}/edit', [OfferController::class, 'edit'])->name('edit');
        Route::put('/{offer}', [OfferController::class, 'update'])->name('update');
        Route::delete('/{offer}', [OfferController::class, 'destroy'])->name('destroy');
    });

        // Administration
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/offers', [AdminDashboardController::class, 'moderateOffers'])->name('offers');
        Route::post('/offers/{offer}/validate', [AdminDashboardController::class, 'validateOffer'])->name('validate');
        Route::delete('/offers/{offer}', [AdminDashboardController::class, 'destroyOffer'])->name('destroyOffer');
        Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    });

    // Candidatures (Entreprise - voir les candidats d'une offre)
    Route::middleware('role:company')->get('/offers/{offer}/applications', [ApplicationController::class, 'offerApplications'])->name('applications.offer');
    Route::middleware('role:company')->put('/applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
});