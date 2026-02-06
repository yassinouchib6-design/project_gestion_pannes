<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StructureController;
use App\Http\Controllers\Api\UtilisateurController;
use App\Http\Controllers\Api\TechnicienController;
use App\Http\Controllers\Api\EquipementController;
use App\Http\Controllers\Api\PanneController;
use App\Http\Controllers\Api\SolutionController;
use App\Http\Controllers\Api\InterventionController;
use App\Http\Controllers\Api\AffectationEquipementController;

/*
|--------------------------------------------------------------------------
| API AUTH
|--------------------------------------------------------------------------
*/
Route::name('api.')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])->name('login');

    /*
    |--------------------------------------------------------------------------
    | PROTECTED API ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/me', fn (Request $request) => $request->user())->name('me');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware('role:admin,technicien')->group(function () {

            Route::apiResource('structures', StructureController::class)->names('api.structures');
            Route::apiResource('utilisateurs', UtilisateurController::class)->names('api.utilisateurs');
            Route::apiResource('techniciens', TechnicienController::class)->names('api.techniciens');
            Route::apiResource('equipements', EquipementController::class)->names('api.equipements');
            Route::apiResource('pannes', PanneController::class)->names('api.pannes');
            Route::apiResource('interventions', InterventionController::class)->names('api.interventions');
            Route::apiResource('solutions', SolutionController::class)->names('api.solutions');
            Route::apiResource('affectations', AffectationEquipementController::class)->names('api.affectations');
        });
    });
});