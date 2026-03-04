<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'roles';
    const DEFAULT_ROLE = 'usuario';

    protected $fillable =
    [
        'name',
        'description',
        'ativo'
    ];

    protected $appends =
    [
        'ativo_desc'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'roles_id', 'users_id');
    }

    public function permissionRoles()
    {
        return $this->hasMany(PermissionRole::class, 'role_id', 'id');
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
