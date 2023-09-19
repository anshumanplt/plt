<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'address_id',
        'payment_method',
        'order_state',
        'total_amount',
        'payment_status',
        'payment_id'
    ];

    // public function products()
    // {
    //     return $this->belongsToMany(Product::class)
    //                 ->withPivot('quantity', 'sale_price', 'subtotal');
    // }


    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
