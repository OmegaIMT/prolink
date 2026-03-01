<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Base\BaseApiController;
use App\Http\Requests\AcessoRequest;
use App\Services\Access\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcessoController extends BaseApiController
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;

        $this->middleware('auth:api');

        $this->middleware('permission:controle_acesso.select')
            ->only('index');

        $this->middleware('permission:controle_acesso.insert')
            ->only('store');

        $this->middleware('permission:controle_acesso.update')
            ->only(['update', 'setPermission']);

        $this->middleware('permission:controle_acesso.delete')
            ->only('destroy');
    }

    public function index(): JsonResponse
    {
        $data = $this->roleService->listRolesWithPermissions();

        return $this->success($data);
    }

    public function store(AcessoRequest $request): JsonResponse
    {
        $role = $this->roleService->createRole(
            $request->validated()
        );

        return $this->success($role, 'Cargo criado com sucesso.', 201);
    }

    public function update(AcessoRequest $request, int $id): JsonResponse
    {
        $role = $this->roleService->updateRole(
            $id,
            $request->validated()
        );

        return $this->success($role, 'Cargo atualizado com sucesso.');
    }

    public function destroy(int $id): JsonResponse
    {
        $this->roleService->deleteRole($id);

        return $this->success(null, 'Cargo removido com sucesso.');
    }

    public function setPermission(Request $request, int $roleId): JsonResponse
    {
        $this->roleService->setPermissions(
            $roleId,
            $request->permissions
        );

        return $this->success(null, 'Permissões atualizadas com sucesso.');
    }
}