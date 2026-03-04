<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contato extends Model
{
    use SoftDeletes;
    protected $table = 'contatos';

    public $timestamps = false;

    protected $fillable = [
        'cpf',
        'cnpj',
        'telefone',
        'whatsapp',
        'linkedin',
        'site'
    ];

    public function profissional()
    {
        return $this->hasOne(Profissional::class);
    }
}