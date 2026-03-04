<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vaga extends Model
{
    use SoftDeletes;
    
    protected $table = 'vagas';

    public $timestamps = false;

    protected $fillable = [
        'empresa_id',
        'titulo',
        'descricao',
        'salario',
        'modalidade',
        'data_publicacao'
    ];

    protected $casts = [
        'salario' => 'decimal:2',
        'data_publicacao' => 'date'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function candidaturas()
    {
        return $this->hasMany(Candidatura::class);
    }
}