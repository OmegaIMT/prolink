<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\CandidaturaRequest;
use App\Services\CandidaturaService;
use Illuminate\Http\JsonResponse;

class CandidaturaController extends BaseApiController
{
    protected CandidaturaService $service;

    public function __construct(CandidaturaService $service)
    {
        $this->middleware('auth:api');

        $this->middleware('permission:candidatura.select')
            ->only(['index', 'findById']);

        $this->middleware('permission:candidatura.insert')
            ->only('store');

        $this->middleware('permission:candidatura.update')
            ->only(['update', 'changeStatus']);

        $this->middleware('permission:candidatura.delete')
            ->only('destroy');

        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return $this->success($this->service->index());
    }

    public function findById(int $id): JsonResponse
    {
        return $this->success($this->service->findById($id));
    }

    public function store(CandidaturaRequest $request): JsonResponse
    {
        return $this->success(
            $this->service->store($request->validated()),
            'Candidatura realizada com sucesso.',
            201
        );
    }

    public function update(CandidaturaRequest $request, int $id): JsonResponse
    {
        return $this->success(
            $this->service->update($id, $request->validated()),
            'Candidatura atualizada com sucesso.'
        );
    }

    public function changeStatus(int $id, string $status): JsonResponse
    {
        return $this->success(
            $this->service->changeStatus($id, $status),
            'Status atualizado com sucesso.'
        );
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->destroy($id);

        return $this->success(null, 'Candidatura removida com sucesso.');
    }
}