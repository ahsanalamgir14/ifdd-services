<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('auth/email/verify/{id}', [App\Http\Controllers\Api\VerificationController::class, 'verify'])->name('verification.verify');
Route::get('auth/email/resend', [App\Http\Controllers\Api\VerificationController::class, 'resend'])->name('verification.resend');
Route::post('auth/register', [App\Http\Controllers\Api\UserController::class, 'register']);
Route::post('auth/login', [App\Http\Controllers\Api\UserController::class, 'login']);

// Route::middleware('auth.apikey')->group(
//     function () {


        Route::post('auth/password/forgot', [App\Http\Controllers\Api\UserController::class, 'forgot']);
        Route::post('auth/password/reset', [App\Http\Controllers\Api\UserController::class, 'reset'])->name('password.reset');



        Route::get('thematique', [App\Http\Controllers\Api\ThematiqueController::class, 'index']);
        Route::get('thematique/{id}', [App\Http\Controllers\Api\ThematiqueController::class, 'show']);

        Route::get('categoriethematique', [App\Http\Controllers\Api\CategorieThematiqueController::class, 'index']);
        Route::get('categoriethematique/{id}', [App\Http\Controllers\Api\CategorieThematiqueController::class, 'show']);

        Route::get('innovation', [App\Http\Controllers\Api\InnovationController::class, 'index']);
        Route::get('count/innovation', [App\Http\Controllers\Api\InnovationController::class, 'countInnovationInDb']);
        Route::get('innovation/{id}', [App\Http\Controllers\Api\InnovationController::class, 'show']);
        Route::post('search/innovation', [App\Http\Controllers\Api\InnovationController::class, 'searchInnovation']);
        Route::get('searchinnovation', [App\Http\Controllers\Api\InnovationController::class, 'searchInnovationByQuery']);

        Route::get('zonesintervention', [App\Http\Controllers\Api\ZoneInterventionController::class, 'index']);
        Route::get('zonesintervention/{id}', [App\Http\Controllers\Api\ZoneInterventionController::class, 'show']);

        Route::get('activeinnovation', [App\Http\Controllers\Api\InnovationController::class, 'getActiveInnovations']);
        
        Route::get('search-places', [App\Http\Controllers\Api\MapController::class, 'searchPlaces']);
        
        Route::middleware('auth:api')->group(
            function () {
                Route::get('auth/logout', [App\Http\Controllers\Api\UserController::class, 'logout']);
                Route::post('user/update/{id}', [App\Http\Controllers\Api\UserController::class, 'updateuser']);
                Route::delete('user/delete/{id}', [App\Http\Controllers\Api\UserController::class, 'deleteuser']);
                Route::get('user/me', [App\Http\Controllers\Api\UserController::class, 'getUser']);

                Route::post('thematique', [App\Http\Controllers\Api\ThematiqueController::class, 'store']);
                Route::put('thematique/{id}', [App\Http\Controllers\Api\ThematiqueController::class, 'update']);
                Route::delete('thematique/{id}', [App\Http\Controllers\Api\ThematiqueController::class, 'destroy']);

                Route::post('categoriethematique', [App\Http\Controllers\Api\CategorieThematiqueController::class, 'store']);
                Route::put('categoriethematique/{id}', [App\Http\Controllers\Api\CategorieThematiqueController::class, 'update']);
                Route::delete('categoriethematique/{id}', [App\Http\Controllers\Api\CategorieThematiqueController::class, 'destroy']);

                Route::post('innovation', [App\Http\Controllers\Api\InnovationController::class, 'store']);
                Route::put('innovation/{id}', [App\Http\Controllers\Api\InnovationController::class, 'update']);
                Route::delete('innovation/{id}', [App\Http\Controllers\Api\InnovationController::class, 'destroy']);

                Route::post('zonesintervention', [App\Http\Controllers\Api\ZoneInterventionController::class, 'store']);
                Route::put('zonesintervention/{id}', [App\Http\Controllers\Api\ZoneInterventionController::class, 'update']);
                Route::delete('zonesintervention/{id}', [App\Http\Controllers\Api\ZoneInterventionController::class, 'destroy']);

            }
        );
    // }
// );
