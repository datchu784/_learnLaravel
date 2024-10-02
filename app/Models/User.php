<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;


    protected $fillable = ['name', 'email', 'password','id_role','money'];

    protected $hidden = ['password', 'remember_token'];

    protected $attributes = [
        'money' => 0,
        'id_role'=>2
    ];


    // 2 method của interface
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }
}
