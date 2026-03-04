<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\VagaRequest;
use App\Services\VagaService;
use App\Services\SQL\SQLService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VagaController extends BaseApiController
{
    protected $service, $sqlService;

    public function __construct(
        VagaService $service,
        SQLService $sqlService
    ) {
        $this->middleware('auth:api');

        $this->middleware('permission:vaga.select')
            ->only(['index', 'findById', 'findByActive', 'show']);

        $this->middleware('permission:vaga.insert')
            ->only('store');

        $this->middleware('permission:vaga.update')
            ->only('update');

        $this->middleware('permission:vaga.delete')
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

    public function show(Request $request): JsonResponse
    {
        return $this->success(
            $this->sqlService->execute('vaga', 'show', $request->all())
        );
    }

    public function store(VagaRequest $request): JsonResponse
    {
        return $this->success(
            $this->service->store($request->validated()),
            'Vaga criada com sucesso.',
            201
        );
    }

    public function update(VagaRequest $request, int $id): JsonResponse
    {
        return $this->success(
            $this->service->update($id, $request->validated()),
            'Vaga atualizada com sucesso.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);

        return $this->success(
            null,
            'Vaga removida com sucesso.'
        );
    }
}