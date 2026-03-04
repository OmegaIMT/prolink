<?php

namespace App\Services;

use App\Models\Contato;
use App\Models\Empresa;
use App\Models\Endereco;

class EmpresaService
{
    public function index()
    {
        return Empresa::with(['endereco'])
            ->orderByDesc('id')
            ->get();
    }

    public function findByActive()
    {
        return Empresa::with(['endereco'])
            ->where('ativo', true)
            ->orderByDesc('id')
            ->get();
    }

    public function findById(int $id)
    {
        return Empresa::with(['endereco'])
            ->findOrFail($id);
    }

    public function store(array $data)
    {
        if (isset($data['endereco'])) {
            $endereco = Endereco::create($data['endereco']);
            $data['endereco_id'] = $endereco->id;
        }

        if (isset($data['contato'])) {
            $contato = Contato::create($data['contato']);
            $data['contato_id'] = $contato->id;
        }

        unset($data['endereco'], $data['contato']);

        return Empresa::create($data);
    }

    public function update(int $id, array $data)
    {
        $empresa = Empresa::findOrFail($id);

        if (isset($data['endereco'])) {
            if ($empresa->endereco) {
                $empresa->endereco->update($data['endereco']);
            } else {
                $endereco = Endereco::create($data['endereco']);
                $empresa->endereco_id = $endereco->id;
            }
        }

        if (isset($data['contato'])) {
            if ($empresa->contato) {
                $empresa->contato->update($data['contato']);
            } else {
                $contato = Contato::create($data['contato']);
                $empresa->contato_id = $contato->id;
            }
        }

        unset($data['endereco'], $data['contato']);

        $empresa->update($data);

        return $empresa;
    }

    public function destroy(int $id): void
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();
    }
}