<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/', function () {
        return response()->json([
            'status' => true,
            'mensagem' => 'API ProLink v1 em funcionamento',
            'versao' => 'v1'
        ]);
    });

    Route::prefix('auth')->group(function () {

        Route::post('registrar', [AuthController::class, 'registrar']);
        Route::post('login', [AuthController::class, 'login']);

        Route::middleware('auth:api')->group(function () {
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::post('logout', [AuthController::class, 'logout']);
            Route::get('me', [AuthController::class, 'me']);
        });

    });

});