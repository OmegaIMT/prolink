<?php

namespace App\Services\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function listar()
    {
        return User::with('roles')
            ->orderByDesc('id')
            ->get();
    }

    public function buscar(int $id)
    {
        return User::with('roles')->findOrFail($id);
    }

    public function criar(array $dados)
    {
        $dados['password'] = Hash::make($dados['password']);

        $user = User::create($dados);

        // Se veio role_id (admin criando)
        if (!empty($dados['role_id'])) {
            $user->roles()->attach($dados['role_id']);
        } else {
            // Aplica role padrão (registro público)
            $defaultRole = Role::where('name', Role::DEFAULT_ROLE)->first();

            if ($defaultRole) {
                $user->roles()->attach($defaultRole->id);
            }
        }        

        return $user->load('roles');
    }

    public function atualizar(int $id, array $dados)
    {
        $user = User::findOrFail($id);

        if (!empty($dados['password'])) {
            $dados['password'] = Hash::make($dados['password']);
        } else {
            unset($dados['password']);
        }

        $user->update($dados);

        if (!empty($dados['role_id'])) {
            $user->roles()->sync([$dados['role_id']]);
        }

        return $user->load('roles');
    }

    public function deletar(int $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    }
}