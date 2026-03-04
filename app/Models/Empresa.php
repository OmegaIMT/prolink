<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;
    protected $table = 'empresas';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'tipo',
        'endereco_id',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
        'ativo'
    ];

    protected $appends = [
        'tipo_desc',
        'ativo_desc'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function contato()
    {
        return $this->belongsTo(Contato::class);
    }

    public function vagas()
    {
        return $this->hasMany(Vaga::class);
    }

    public function criadoPor()
    {
        return $this->belongsTo(User::class, 'user_created_id');
    }

    public function atualizadoPor()
    {
        return $this->belongsTo(User::class, 'user_updated_id');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getTipoDescAttribute()
    {
        return ucfirst($this->tipo);
    }

    public function getAtivoDescAttribute()
    {
        return $this->ativo ? 'Ativo' : 'Inativo';
    }
}