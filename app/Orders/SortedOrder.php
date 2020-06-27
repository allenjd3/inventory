<?php

namespace App\Orders;

class SortedOrder
{
    private $sorts = [
        'product_name' => ProductNameSort::class,
        'due_date' => DueDateSort::class, 
        null => DefaultDataSort::class
    ];
    public static function handle($sort)
    {
        $bar = new static();
        return (new $bar->sorts[$sort])->handle();
    
    }
}
