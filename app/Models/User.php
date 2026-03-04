<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, SoftDeletes;
    
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'ativo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends =
    [
        'ativo_desc'
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

        if (!str_contains($permission, '.')) {
            return false;
        }

        list($module, $action) = explode('.', $permission);

        return $this->roles()
            ->whereHas('permissionRoles', function ($query) use ($module, $action) {
                $query->whereHas('permission', function ($q) use ($module) {
                    $q->where('name', $module);
                })->where($action, true);
            })
            ->exists();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
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