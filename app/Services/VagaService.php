<?php

namespace App\Services;

use App\Models\Vaga;

class VagaService
{
    public function index()
    {
        return Vaga::with('empresa')
            ->orderByDesc('id')
            ->get();
    }

    public function findByActive()
    {
        return Vaga::with('empresa')
            ->where('ativo', true)
            ->orderByDesc('id')
            ->get();
    }

    public function findById(int $id)
    {
        return Vaga::with('empresa')->findOrFail($id);
    }

    public function store(array $data)
    {
        return Vaga::create($data);
    }

    public function update(int $id, array $data)
    {
        $vaga = Vaga::findOrFail($id);
        $vaga->update($data);

        return $vaga;
    }

    public function destroy(int $id): void
    {
        $vaga = Vaga::findOrFail($id);
        $vaga->delete();
    }
}