<?php

namespace App\Services\User;

use App\Models\User;

class UserPermissionService
{
    public function buildUserPayload(User $user): array
    {
        $roles = $user->roles()
            ->with('permissions.module')
            ->get();

        $admin = $roles->contains(fn($role) => $role->slug === 'admin');

        $permissions = [];

        if (!$admin) {
            foreach ($roles as $role) {

                foreach ($role->permissions as $permission) {

                    $moduleName = str_replace(' ', '_', $permission->module->name);

                    $permissions[$moduleName] = [
                        'insert' => $permission->insert ?? false,
                        'select' => $permission->select ?? false,
                        'update' => $permission->update ?? false,
                        'delete' => $permission->delete ?? false,
                    ];
                }
            }
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'admin' => $admin,
            'permissions' => $permissions,
        ];
    }
}