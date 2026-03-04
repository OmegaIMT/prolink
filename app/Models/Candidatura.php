<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Candidatura extends Model
{
    use SoftDeletes;
    protected $table = 'candidaturas';

    public $timestamps = false;

    protected $fillable = [
        'vaga_id',
        'profissional_id',
        'link_acompanhamento',
        'salario_proposto',
        'data_aplicacao',
        'status',
        'observacao',
        'beneficios'
    ];

    protected $casts = [
        'salario_proposto' => 'decimal:2',
        'data_aplicacao' => 'date'
    ];

    protected $appends = [
        'status_desc'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    public function vaga()
    {
        return $this->belongsTo(Vaga::class);
    }

    public function profissional()
    {
        return $this->belongsTo(Profissional::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getStatusDescAttribute()
    {
        switch ($this->status) {
            case 'aplicado':
                return 'Aplicado';
            case 'entrevista':
                return 'Entrevista';
            case 'proposta':
                return 'Proposta';
            case 'aprovado':
                return 'Aprovado';
            case 'recusado':
                return 'Recusado';
            default:
                return 'Desconhecido';
        }
    }
}