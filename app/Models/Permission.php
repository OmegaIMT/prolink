<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    protected $table = 'permission';
    protected $fillable =
    [
        'name',
        'description'
    ];

    public function permissionRoles()
    {
        return $this->hasMany(PermissionRole::class,'permission_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permissions', 'permission_id', 'role_id');
    }
}
