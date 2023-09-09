<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    protected $fillable = ['attribute_id', 'value'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    // Add attribute relation
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute')
            ->withPivot('attribute_id', 'price', 'inventory')
            ->withTimestamps();
    }
}
