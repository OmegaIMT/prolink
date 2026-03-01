<?php

namespace App\Services\Auth;

use App\Services\User\UserService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function registrar(array $dados)
    {
        // Delegando criação para o UserService
        return $this->userService->criar($dados);
    }

    public function login(array $dados)
    {
        $campo = filter_var($dados['login'], FILTER_VALIDATE_EMAIL)
                    ? 'email'
                    : 'username';

        $credenciais = [
            $campo     => $dados['login'],
            'password' => $dados['password']
        ];

        if (!$token = auth('api')->attempt($credenciais)) {
            throw new UnauthorizedHttpException('', 'Credenciais inválidas.');
        }

        return $this->responderComToken($token);
    }

    public function refresh()
    {
        return $this->responderComToken(
            auth('api')->refresh()
        );
    }

    public function logout()
    {
        auth('api')->logout();
    }

    protected function responderComToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ];
    }
}