<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PanneController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\TechnicienController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ PANNES (admin + technicien + utilisateur)
    Route::middleware('role:admin,technicien,utilisateur')->group(function () {
        Route::resource('pannes', PanneController::class);
    });

    // ✅ INTERVENTIONS (admin + technicien)
    Route::middleware('role:admin,technicien')->group(function () {
        Route::resource('interventions', InterventionController::class);
    });

    // ✅ TECHNICIENS (admin فقط) - إدارة التقنيين
    Route::middleware('role:admin')->prefix('techniciens')->name('techniciens.')->group(function () {
        Route::get('/', [TechnicienController::class, 'index'])->name('index');
        Route::get('/create', [TechnicienController::class, 'create'])->name('create');
        Route::post('/', [TechnicienController::class, 'store'])->name('store');
       Route::delete('/{technicien}', [TechnicienController::class, 'destroy'])->name('destroy');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';