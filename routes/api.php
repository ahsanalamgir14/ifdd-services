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

Route::middleware('auth.apikey')->group(
    function () {


        Route::post('auth/password/forgot', [App\Http\Controllers\Api\UserController::class, 'forgot']);
        Route::post('auth/password/reset', [App\Http\Controllers\Api\UserController::class, 'reset'])->name('password.reset');

        Route::post('auth/register', [App\Http\Controllers\Api\UserController::class, 'register']);
        Route::post('auth/login', [App\Http\Controllers\Api\UserController::class, 'login']);


        Route::get('odd', [App\Http\Controllers\Api\OddController::class, 'index']);
        Route::get('odd/{id}', [App\Http\Controllers\Api\OddController::class, 'show']);

        Route::get('categorieodd', [App\Http\Controllers\Api\CategorieOddController::class, 'index']);
        Route::get('categorieodd/{id}', [App\Http\Controllers\Api\CategorieOddController::class, 'show']);

        Route::get('osc', [App\Http\Controllers\Api\OscController::class, 'index']);
        Route::get('count/osc', [App\Http\Controllers\Api\OscController::class, 'countOscInDb']);
        Route::get('osc/{id}', [App\Http\Controllers\Api\OscController::class, 'show']);
        Route::post('search/osc', [App\Http\Controllers\Api\OscController::class, 'searchOsc']);
        Route::get('searchosc', [App\Http\Controllers\Api\OscController::class, 'searchOscByQuery']);

        Route::get('zonesintervention', [App\Http\Controllers\Api\ZoneInterventionController::class, 'index']);
        Route::get('zonesintervention/{id}', [App\Http\Controllers\Api\ZoneInterventionController::class, 'show']);

        Route::get('activeosc', [App\Http\Controllers\Api\OscController::class, 'getActiveOscs']);

        Route::middleware('auth:api')->group(
            function () {
                Route::get('auth/logout', [App\Http\Controllers\Api\UserController::class, 'logout']);
                Route::post('user/update/{id}', [App\Http\Controllers\Api\UserController::class, 'updateuser']);
                Route::delete('user/delete/{id}', [App\Http\Controllers\Api\UserController::class, 'deleteuser']);
                Route::get('user/me', [App\Http\Controllers\Api\UserController::class, 'getUser']);

                Route::post('odd', [App\Http\Controllers\Api\OddController::class, 'store']);
                Route::put('odd/{id}', [App\Http\Controllers\Api\OddController::class, 'update']);
                Route::delete('odd/{id}', [App\Http\Controllers\Api\OddController::class, 'destroy']);

                Route::post('categorieodd', [App\Http\Controllers\Api\CategorieOddController::class, 'store']);
                Route::put('categorieodd/{id}', [App\Http\Controllers\Api\CategorieOddController::class, 'update']);
                Route::delete('categorieodd/{id}', [App\Http\Controllers\Api\CategorieOddController::class, 'destroy']);

                Route::post('osc', [App\Http\Controllers\Api\OscController::class, 'store']);
                Route::put('osc/{id}', [App\Http\Controllers\Api\OscController::class, 'update']);
                Route::delete('osc/{id}', [App\Http\Controllers\Api\OscController::class, 'destroy']);

                Route::post('zonesintervention', [App\Http\Controllers\Api\ZoneInterventionController::class, 'store']);
                Route::put('zonesintervention/{id}', [App\Http\Controllers\Api\ZoneInterventionController::class, 'update']);
                Route::delete('zonesintervention/{id}', [App\Http\Controllers\Api\ZoneInterventionController::class, 'destroy']);
            }
        );
    }
);
