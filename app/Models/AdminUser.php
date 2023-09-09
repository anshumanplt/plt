<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

// class AdminUser extends Model
class AdminUser extends Authenticatable implements AuthenticatableContract
{
    use HasFactory;
    protected $table = 'admin_users';
    protected $fillable = [
        'name',
        'email',
        'password',
        // Add other fields that you want to be mass-assignable
    ];
}
