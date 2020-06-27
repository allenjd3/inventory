<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function an_order_belongs_to_a_product()
    {
        $product = factory(Product::class)->create([
            'name'=>'My Product Name is cool' 
        ]);
        $order = factory(Order::class)->create([
            'product_id'=>$product->id 
        ]);
        $this->assertEquals('My Product Name is cool', $order->product->name);


        
    }

    /**
     * @test
     */
    function an_order_can_scope_only_unreceived_orders()
    {
        $order1 = factory(Order::class)->create([
            'received'=>1 
        ]); 
        $order2 = factory(Order::class)->create([
            'received'=>0 
        ]); 

        $order1->refresh();
        $order2->refresh();

        $query = Order::unReceived()->first();
        $this->assertEquals($order2->id, $query->id);
        $this->assertNotEquals($order1->id, $query->id);

        
    }
    
}
