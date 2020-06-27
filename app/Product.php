<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function setPriceAttribute($value)
    {
    
        $this->attributes['price'] = (int) ($value * 100);
    }

    public function getPriceAttribute($value)
    {
        return $value/100;
    
    }

    public function priceInDollars()
    {
        $price = $this->attributes['price']; 
        $float_price = $price/100;
        return '$'. number_format($float_price, 2);
    }

    public function orders()
    {
        return $this->hasMany(Order::class); 
    }

    public function scopeNewestFirst($query){
        return $query->orderBy('created_at', 'DESC'); 
    }

}
