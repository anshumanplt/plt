<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeImage extends Model
{
    use HasFactory;
    protected $table = 'product_attribute_images';

    protected $fillable = [
        // 'product_attribute_id',
        'image_path',
        'sku'
        // Add any other fillable columns here
    ];

    public function productAttribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}
