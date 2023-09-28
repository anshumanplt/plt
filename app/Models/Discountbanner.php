<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discountbanner extends Model
{
    use HasFactory;
    protected $fillable = [
        'discount_background_image',
        'status',
        'url'
    ];
}
