<?php

use App\Http\Controllers\Api\AcessoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CandidaturaController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\Api\ProfissionalController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VagaController;
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
            // Rotas de controle de acesso
            Route::prefix('acesso')->group(function () {
                Route::get('index', [AcessoController::class, 'index']);
                Route::get('findByActive', [AcessoController::class, 'findByActive']);
                Route::get('show', [AcessoController::class, 'show']);
                Route::get('findById/{id}', [AcessoController::class, 'findById']);
                Route::post('store', [AcessoController::class, 'store']);
                Route::put('update/{id}', [AcessoController::class, 'update']);
                Route::delete('destroy/{id}', [AcessoController::class, 'destroy']);
                Route::put('setPermission/{roleId}', [AcessoController::class, 'setPermission']);
            });
            // Rotas do usuário
            Route::prefix('usuario')->group(function () {
                Route::get('index', [UserController::class, 'index']);
                Route::get('findByActive', [UserController::class, 'findByActive']);
                Route::get('show', [UserController::class, 'show']);
                Route::get('findById/{id}', [UserController::class, 'findById']);
                Route::post('store', [UserController::class, 'store']);
                Route::put('update/{id}', [UserController::class, 'update']);
                Route::delete('destroy/{id}', [UserController::class, 'destroy']);
            });
            // Rotas do profissional
            Route::prefix('profissional')->group(function () {
                Route::get('index', [ProfissionalController::class, 'index']);
                Route::get('findByActive', [ProfissionalController::class, 'findByActive']);
                Route::get('show', [ProfissionalController::class, 'show']);
                Route::get('findById/{id}', [ProfissionalController::class, 'findById']);
                Route::post('store', [ProfissionalController::class, 'store']);
                Route::put('update/{id}', [ProfissionalController::class, 'update']);
                Route::delete('destroy/{id}', [ProfissionalController::class, 'destroy']);
            });
            // Rotas da empresa
            Route::prefix('empresa')->group(function () {
                Route::get('index', [EmpresaController::class, 'index']);
                Route::get('findByActive', [EmpresaController::class, 'findByActive']);
                Route::get('show', [EmpresaController::class, 'show']);
                Route::get('findById/{id}', [EmpresaController::class, 'findById']);
                Route::post('store', [EmpresaController::class, 'store']);
                Route::put('update/{id}', [EmpresaController::class, 'update']);
                Route::delete('destroy/{id}', [EmpresaController::class, 'destroy']);
            });
            // Rotas da vaga
            Route::prefix('vaga')->group(function () {
                Route::get('index', [VagaController::class, 'index']);
                Route::get('findByActive', [VagaController::class, 'findByActive']);
                Route::get('show', [VagaController::class, 'show']);
                Route::get('findById/{id}', [VagaController::class, 'findById']);
                Route::post('store', [VagaController::class, 'store']);
                Route::put('update/{id}', [VagaController::class, 'update']);
                Route::delete('destroy/{id}', [VagaController::class, 'destroy']);
            });
            // Rotas da candidatura
            Route::prefix('candidatura')->group(function () {
                Route::get('index', [CandidaturaController::class, 'index']);
                Route::get('findByActive', [CandidaturaController::class, 'findByActive']);
                Route::get('show', [CandidaturaController::class, 'show']);
                Route::get('findById/{id}', [CandidaturaController::class, 'findById']);
                Route::post('store', [CandidaturaController::class, 'store']);
                Route::put('update/{id}', [CandidaturaController::class, 'update']);
                Route::delete('destroy/{id}', [CandidaturaController::class, 'destroy']);
            });
        });

    });

});