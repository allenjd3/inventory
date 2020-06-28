<?php

namespace App\Orders;

use App\Order;

class DueDateSort
{

    public function handle()
    {
        return Order::dueDate()->join('products', 'orders.product_id', '=', 'products.id')->select('orders.*', 'products.name')->paginate(50);
    }
}
