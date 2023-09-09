<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    // Add attribute relation
    public function values()
    {
        return $this->belongsToMany(AttributeValue::class, 'product_attributes')
            ->withPivot('product_id', 'price', 'inventory')
            ->withTimestamps();
    }

}
