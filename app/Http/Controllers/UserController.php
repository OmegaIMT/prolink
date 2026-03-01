<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends BaseApiController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api');

        $this->middleware('permission:usuario.select')
            ->only(['index', 'show']);

        $this->middleware('permission:usuario.insert')
            ->only('store');

        $this->middleware('permission:usuario.update')
            ->only('update');

        $this->middleware('permission:usuario.delete')
            ->only('destroy');

        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        return $this->success(
            $this->userService->listar()
        );
    }

    public function store(UserRequest $request): JsonResponse
    {
        $user = $this->userService->criar(
            $request->validated()
        );

        return $this->success(
            $user,
            'Usuário criado com sucesso.',
            201
        );
    }

    public function show(int $id): JsonResponse
    {
        return $this->success(
            $this->userService->buscar($id)
        );
    }

    public function update(UserRequest $request, int $id): JsonResponse
    {
        $user = $this->userService->atualizar(
            $id,
            $request->validated()
        );

        return $this->success(
            $user,
            'Usuário atualizado com sucesso.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->userService->deletar($id);

        return $this->success(
            null,
            'Usuário removido com sucesso.'
        );
    }
}