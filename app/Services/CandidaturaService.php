<?php

namespace App\Services;

use App\Models\Candidatura;
use App\Models\Vaga;
use Illuminate\Validation\ValidationException;

class CandidaturaService
{
    public function index()
    {
        return Candidatura::with(['vaga', 'profissional'])
            ->orderByDesc('id')
            ->get();
    }

    public function findById(int $id)
    {
        return Candidatura::with(['vaga', 'profissional'])
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        // 1️⃣ Impedir candidatura em vaga inativa
        $vaga = Vaga::findOrFail($data['vaga_id']);

        if (!$vaga->ativo) {
            throw ValidationException::withMessages([
                'vaga_id' => 'Não é possível se candidatar a uma vaga inativa.'
            ]);
        }

        // 2️⃣ Impedir duplicidade
        $exists = Candidatura::where('vaga_id', $data['vaga_id'])
            ->where('profissional_id', $data['profissional_id'])
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'profissional_id' => 'Este profissional já se candidatou a esta vaga.'
            ]);
        }

        return Candidatura::create($data);
    }

    public function update(int $id, array $data)
    {
        $candidatura = Candidatura::findOrFail($id);
        $candidatura->update($data);

        return $candidatura;
    }

    public function changeStatus(int $id, string $newStatus)
    {
        $candidatura = Candidatura::findOrFail($id);

        $allowedTransitions = [
            'aplicado' => ['entrevista', 'recusado'],
            'entrevista' => ['proposta', 'recusado'],
            'proposta' => ['aprovado', 'recusado'],
            'aprovado' => [],
            'recusado' => []
        ];

        if (!in_array($newStatus, $allowedTransitions[$candidatura->status])) {
            throw ValidationException::withMessages([
                'status' => 'Transição de status inválida.'
            ]);
        }

        $candidatura->status = $newStatus;
        $candidatura->save();

        return $candidatura;
    }

    public function destroy(int $id): void
    {
        Candidatura::findOrFail($id)->delete();
    }
}