<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{    
    use SoftDeletes;
    protected $table = 'enderecos';

    public $timestamps = false;

    protected $fillable = [
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'pais'
    ];

    public function profissionais()
    {
        return $this->hasMany(Profissional::class);
    }

    public function empresas()
    {
        return $this->hasMany(Empresa::class);
    }
}