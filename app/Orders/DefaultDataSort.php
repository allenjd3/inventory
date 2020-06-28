<?php

namespace App\Orders;

use App\Order;

class DefaultDataSort
{
    public function handle()
    {
        return Order::join('products', 'orders.product_id', '=', 'products.id')->select('orders.*', 'products.name')->paginate(50);

    }

}
