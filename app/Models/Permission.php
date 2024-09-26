<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;
    
    protected $fillable =[
        'title',
        'description'

    ];

    public function userPermissions()
    {
        return $this->hasMany(UserPermission::class);
    }
}
