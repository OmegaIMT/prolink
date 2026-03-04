<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\UserRequest;
use App\Services\SQL\SQLService;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseApiController
{
    protected $service, $sqlService;

    public function __construct(UserService $service, SQLService $sqlService)
    {
        $this->middleware('auth:api');

        $this->middleware('permission:usuario.select')
            ->only(['index', 'findById', 'findByActive', 'show']);

        $this->middleware('permission:usuario.insert')
            ->only('store');

        $this->middleware('permission:usuario.update')
            ->only('update');

        $this->middleware('permission:usuario.delete')
            ->only('destroy');

        $this->service = $service;
        $this->sqlService = $sqlService;
    }

    public function index(): JsonResponse
    {
        return $this->success(
            $this->service->index()
        );
    }

    public function findByActive(): JsonResponse
    {
        return $this->success(
            $this->service->findByActive()
        );
    }

    public function findById(int $id): JsonResponse
    {
        return $this->success(
            $this->service->findById($id)
        );
    }

    public function show(Request $request)
    {
        $params = [
            // você monta os filtros aqui
        ];

        return $this->success(
            $this->sqlService->execute('user', 'show', $params)
        );
    }

    public function store(UserRequest $request): JsonResponse
    {
        return $this->success(
            $this->service->store($request->validated()),
            'Usuário criado com sucesso.',
            201
        );
    }

    public function update(UserRequest $request, int $id): JsonResponse
    {
        return $this->success(
            $this->service->update($id, $request->validated()),
            'Usuário atualizado com sucesso.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);

        return $this->success(
            null,
            'Usuário removido com sucesso.'
        );
    }
}