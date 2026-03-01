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
        'status'
    ];

    protected $appends =
    [
        'status_desc'
    ];

    public function getStatusDescAttribute()
    {
        return $this->status ? 'Ativo' : 'Inativo';
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_users', 'roles_id', 'users_id');
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class, 'role_id', 'id');
    }
}
