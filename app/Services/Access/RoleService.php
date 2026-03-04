<?php

namespace App\Services\Access;

use App\Models\Role;

class RoleService
{
    public function index()
    {
        return Role::with('permissions')
            ->orderByDesc('id')
            ->get();
    }

    public function findByActive()
    {
        return Role::where('ativo', true)
            ->with('permissions')
            ->orderByDesc('id')
            ->get();
    }

    public function findById(int $id)
    {
        return Role::with('permissions')->findOrFail($id);
    }

    public function store(array $data)
    {
        return Role::create($data);
    }

    public function update(int $id, array $data)
    {
        $role = Role::findOrFail($id);
        $role->update($data);

        return $role;
    }

    public function destroy(int $id): void
    {
        $role = Role::findOrFail($id);
        $role->delete();
    }

    public function setPermission(int $roleId, array $permissions): void
    {
        $role = Role::findOrFail($roleId);
        $role->permissions()->sync($permissions);
    }
}