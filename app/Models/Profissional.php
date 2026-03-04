<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profissional extends Model
{
    use SoftDeletes;
    protected $table = 'profissionais';

    public $timestamps = false;

    protected $fillable = [
        'nome',
        'funcao',
        'user_id',
        'endereco_id',
        'contato_id',
        'user_created_id',
        'user_updated_id',
        'user_deleted_id',
        'ativo'
    ];

    protected $appends = [
        'ativo_desc'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }

    public function contato()
    {
        return $this->belongsTo(Contato::class);
    }

    public function candidaturas()
    {
        return $this->hasMany(Candidatura::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getAtivoDescAttribute()
    {
        return $this->ativo ? 'Ativo' : 'Inativo';
    }
}