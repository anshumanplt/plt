<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
        // Define the fillable fields of the model
        protected $fillable = [
            'sku',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'category_id',
            'subcategory_id',
            'brand_id',
            'name',
            'description',
            'price',
            'discount',
            'sale_price',
            'status',
            'hot_trend',
            'best_seller',
            'feature'
        ];
    
        // Define the relationships with other models
        public function category()
        {
            return $this->belongsTo(Category::class, 'category_id');
        }
    
        public function subcategory()
        {
            return $this->belongsTo(Category::class, 'category_id');
        }
    
        public function brand()
        {
            return $this->belongsTo(Brand::class);
        }
        public function productImages()
        {
            return $this->hasMany(ProductImage::class);
        }

        public function images()
        {
            return $this->hasMany(ProductImage::class);
        }

        // Adding Product attributes
        public function attributes()
        {
            return $this->belongsToMany(Attribute::class, 'product_attributes')
                ->withPivot('attribute_value_id', 'price', 'inventory')
                ->withTimestamps();
        }
    
}

