<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\ProfissionalRequest;
use App\Services\ProfissionalService;
use App\Services\SQL\SQLService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfissionalController extends BaseApiController
{
    protected $service, $sqlService;

    public function __construct(
        ProfissionalService $service,
        SQLService $sqlService
    ) {
        $this->middleware('auth:api');

        $this->middleware('permission:profissional.select')
            ->only(['index', 'findById', 'findByActive', 'show']);

        $this->middleware('permission:profissional.insert')
            ->only('store');

        $this->middleware('permission:profissional.update')
            ->only('update');

        $this->middleware('permission:profissional.delete')
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
            $this->sqlService->execute('profissional', 'show', $request->all())
        );
    }

    public function store(ProfissionalRequest $request): JsonResponse
    {
        return $this->success(
            $this->service->store($request->validated()),
            'Profissional criado com sucesso.',
            201
        );
    }

    public function update(ProfissionalRequest $request, int $id): JsonResponse
    {
        return $this->success(
            $this->service->update($id, $request->validated()),
            'Profissional atualizado com sucesso.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);

        return $this->success(
            null,
            'Profissional removido com sucesso.'
        );
    }
}