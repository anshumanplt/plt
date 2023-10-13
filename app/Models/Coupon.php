<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;
    
    protected $fillable = ['code', 'type', 'discount', 'expiration_date'];

    // Validation rules for creating or updating coupons
    public static $rules = [
        'code' => 'required|unique:coupons,code',
        'type' => 'required|in:flat,percentage',
        'discount' => 'required|numeric',
        'expiration_date' => 'required|date',
    ];
}
