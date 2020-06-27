<?php

namespace App\Orders;

use App\Order;


class ProductNameSort
{
    public function handle()
    {
        return Order::join('products', 'orders.product_id', '=', 'products.id')->select('orders.*', 'products.name')->orderBy('name', 'asc')->paginate(5);
    }

}
