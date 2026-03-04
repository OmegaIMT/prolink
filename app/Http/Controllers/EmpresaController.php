<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\EmpresaRequest;
use App\Services\EmpresaService;
use App\Services\SQL\SQLService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmpresaController extends BaseApiController
{
    protected $service, $sqlService;

    public function __construct(
        EmpresaService $service,
        SQLService $sqlService
    ) {
        $this->middleware('auth:api');

        $this->middleware('permission:empresa.select')
            ->only(['index', 'findById', 'findByActive', 'show']);

        $this->middleware('permission:empresa.insert')
            ->only('store');

        $this->middleware('permission:empresa.update')
            ->only('update');

        $this->middleware('permission:empresa.delete')
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
            $this->sqlService->execute('empresa', 'show', $request->all())
        );
    }

    public function store(EmpresaRequest $request): JsonResponse
    {
        return $this->success(
            $this->service->store($request->validated()),
            'Empresa criada com sucesso.',
            201
        );
    }

    public function update(EmpresaRequest $request, int $id): JsonResponse
    {
        return $this->success(
            $this->service->update($id, $request->validated()),
            'Empresa atualizada com sucesso.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);

        return $this->success(
            null,
            'Empresa removida com sucesso.'
        );
    }
}