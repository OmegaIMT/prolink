<?php

namespace App\Services;

use App\Models\Profissional;
use App\Models\Endereco;
use App\Models\Contato;

class ProfissionalService
{
    public function index()
    {
        return Profissional::with(['endereco', 'contato'])
            ->orderByDesc('id')
            ->get();
    }

    public function findByActive()
    {
        return Profissional::with(['endereco', 'contato'])
            ->where('ativo', true)
            ->orderByDesc('id')
            ->get();
    }

    public function findById(int $id)
    {
        return Profissional::with(['endereco', 'contato'])
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        // Endereço
        if (isset($data['endereco'])) {
            $endereco = Endereco::create($data['endereco']);
            $data['endereco_id'] = $endereco->id;
        }

        // Contato
        if (isset($data['contato'])) {
            $contato = Contato::create($data['contato']);
            $data['contato_id'] = $contato->id;
        }

        unset($data['endereco'], $data['contato']);

        return Profissional::create($data);
    }

    public function update(int $id, array $data)
    {
        $profissional = Profissional::findOrFail($id);

        // Sync Endereço
        if (isset($data['endereco'])) {

            if ($profissional->endereco) {
                $profissional->endereco->update($data['endereco']);
            } else {
                $endereco = Endereco::create($data['endereco']);
                $profissional->endereco_id = $endereco->id;
            }
        }

        // Sync Contato
        if (isset($data['contato'])) {

            if ($profissional->contato) {
                $profissional->contato->update($data['contato']);
            } else {
                $contato = Contato::create($data['contato']);
                $profissional->contato_id = $contato->id;
            }
        }

        unset($data['endereco'], $data['contato']);

        $profissional->update($data);

        return $profissional->load(['endereco', 'contato']);
    }

    public function destroy(int $id): void
    {
        $profissional = Profissional::findOrFail($id);
        $profissional->delete();
    }
}