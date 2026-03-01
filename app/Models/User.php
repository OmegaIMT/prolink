<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    
    protected $fillable = [
        'name',
        'username',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users', 'user_id', 'role_id');
    }

    public function hasAnyRoles($roles): bool
    {
        return $this->roles()->whereIn('name', (array) $roles)->exists();
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->hasAnyRoles('admin')) {
            return true;
        }

        [$moduleName, $action] = explode('.', $permission);

        return $this->roles()->whereHas('permissions', function ($query) use ($moduleName, $action) {
            $query->whereHas('module', function ($q) use ($moduleName) {
                $q->where('name', $moduleName);
            })->where($action, true);
        })->exists();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}