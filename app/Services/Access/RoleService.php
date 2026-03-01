<?php

namespace App\Services\Access;

use App\Models\Role;
use App\Models\Module;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function listRolesWithPermissions(): array
    {
        $roles = Role::where('status', true)
            ->with(['permissions.module'])
            ->orderBy('id')
            ->get();

        $modules = Module::orderBy('id')->get();

        return $roles->map(function ($role) use ($modules) {

            $permissions = [];

            foreach ($modules as $module) {

                $permission = $role->permissions
                    ->where('module_id', $module->id)
                    ->first();

                $permissions[] = [
                    'module_id' => $module->id,
                    'description' => $module->description,
                    'permission' => $module->name,
                    'insert' => $permission->insert ?? false,
                    'select' => $permission->select ?? false,
                    'update' => $permission->update ?? false,
                    'delete' => $permission->delete ?? false,
                ];
            }

            return [
                'id' => $role->id,
                'name' => $role->name,
                'status' => $role->status,
                'permissions' => $permissions
            ];
        })->toArray();
    }

    public function createRole(array $data): Role
    {
        return Role::create($data);
    }

    public function updateRole(int $id, array $data): Role
    {
        $role = Role::findOrFail($id);
        $role->update($data);
        return $role;
    }

    public function deleteRole(int $id): void
    {
        $role = Role::findOrFail($id);
        $role->status = false;
        $role->save();
        $role->delete();
    }

    public function setPermissions(int $roleId, array $permissions): void
    {
        DB::transaction(function () use ($roleId, $permissions) {

            foreach ($permissions as $permission) {

                Permission::updateOrCreate(
                    [
                        'role_id' => $roleId,
                        'module_id' => $permission['module_id']
                    ],
                    [
                        'select' => $permission['select'] ?? false,
                        'insert' => $permission['insert'] ?? false,
                        'update' => $permission['update'] ?? false,
                        'delete' => $permission['delete'] ?? false,
                    ]
                );
            }
        });
    }
}