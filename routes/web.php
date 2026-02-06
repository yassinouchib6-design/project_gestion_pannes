<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PanneController;
use App\Http\Controllers\InterventionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ✅ PANNES: نخليها كاملة للـ 3 roles (و Controller هو اللي كيتكلف بالـ authorization/ownership)
    Route::middleware('role:admin,technicien,utilisateur')->group(function () {
        Route::resource('pannes', PanneController::class);
    });

    // ✅ INTERVENTIONS: admin + technicien فقط
    Route::middleware('role:admin,technicien')->group(function () {
        Route::resource('interventions', InterventionController::class);
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';