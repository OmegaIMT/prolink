<?php

namespace App\Services\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function index()
    {
        return User::with('roles')
            ->orderByDesc('id')
            ->get();
    }

    public function findByActive()
    {
        return User::with('roles')
            ->where('ativo', true) // se for boolean
            // ->where('ativo', 'S') // se for char(1)
            ->orderByDesc('id')
            ->get();
    }

    public function findById(int $id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function store(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if (!empty($data['role_id'])) {
            $user->roles()->attach($data['role_id']);
        } else {
            $defaultRole = Role::where('name', Role::DEFAULT_ROLE)->first();

            if ($defaultRole) {
                $user->roles()->attach($defaultRole->id);
            }
        }

        return $user->load('roles');
    }

    public function update(int $id, array $data)
    {
        $user = User::findOrFail($id);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if (!empty($data['role_id'])) {
            $user->roles()->sync([$data['role_id']]);
        }

        return $user->load('roles');
    }

    public function destroy(int $id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}