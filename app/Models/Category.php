<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'slug', 'image', 'parent_id', 'meta_title', 'meta_description', 'meta_keywords', 'status'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id')->where('status', 1)->orderBy('id', 'asc')->limit(8);
    }
}
