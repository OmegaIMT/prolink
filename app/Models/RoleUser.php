<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_users';
    protected $fillable =
    [
        'role_id',
        'user_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id','id');
    }

    protected $timestamp = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}