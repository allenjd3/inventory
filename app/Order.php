<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $dates = ['due_date'];
    protected $casts = [
        'received'=>'boolean' 
    ];

    public function product()
    {
        return $this->belongsTo(Product::class); 
    }

    public function scopeDueDate($query){
        return $query->orderBy('due_date');
    }

    public function scopeUnReceived($query){
        return $query->where('received', 0);
    }

    public function scopeNewestFirst($query){
        return $query->orderBy('created_at', 'DESC'); 
    }

}
