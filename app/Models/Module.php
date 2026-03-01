<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;

    protected $table = 'modules';
    protected $fillable =
    [
        'name',
        'description'
    ];

    public function permissions()
    {
        return $this->hasMany(Permission::class,'module_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permissions', 'module_id', 'role_id');
    }
}
