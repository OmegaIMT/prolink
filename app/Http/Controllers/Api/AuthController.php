<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use App\Services\User\UserPermissionService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseApiController
{
    protected $authService, $permissionService;

    public function __construct(
        AuthService $authService,
        UserPermissionService $permissionService
    ) {
        $this->authService = $authService;
        $this->permissionService = $permissionService;

        $this->middleware('auth:api', [
            'except' => ['login', 'registrar']
        ]);
    }

    /**
     * Registrar novo usuário
     */
    public function registrar(RegisterRequest $request): JsonResponse
    {
        $usuario = $this->authService->registrar($request->validated());

        return $this->success(
            $usuario,
            'Usuário registrado com sucesso.',
            201
        );
    }

    /**
     * Login (email ou username)
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->validated());

        return $this->success(
            $token,
            'Login realizado com sucesso.'
        );
    }

    /**
     * Refresh do token
     */
    public function refresh(): JsonResponse
    {
        $token = $this->authService->refresh();

        return $this->success(
            $token,
            'Token renovado com sucesso.'
        );
    }

    /**
     * Logout
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return $this->success(
            null,
            'Logout realizado com sucesso.'
        );
    }

    /**
     * Usuário autenticado + permissões estruturadas
     */
    public function me(): JsonResponse
    {
        $user = auth('api')->user();

        $payload = $this->permissionService
            ->buildUserPayload($user);

        return $this->success(
            $payload,
            'Usuário autenticado.'
        );
    }
}