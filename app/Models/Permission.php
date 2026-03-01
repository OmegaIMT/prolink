<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable =
    [
        'insert',
        'delete',
        'update',
        'select',
        'module_id',
        'role_id'
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
