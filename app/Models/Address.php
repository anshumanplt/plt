<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mobile',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'pin',
        'is_default',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function addCountry()
    {
        return $this->belongsTo(Country::class, 'country');
    }

    public function addState()
    {
        return $this->belongsTo(State::class, 'state');
    }

    public function addCity()
    {
        return $this->belongsTo(City::class, 'city');
    }
}
