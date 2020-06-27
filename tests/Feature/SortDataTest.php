<?php

namespace Tests\Feature;

use App\Order;
use App\Orders\SortedOrder;
use App\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortDataTest extends TestCase
{
    use RefreshDatabase;
    protected function setUp() : void
    {
        parent::setUp();
        factory(Product::class)->create(); 
    }


    /**
    * @test
    */
    function data_can_be_sorted_by_due_date()
    {
        $order1 = factory(Order::class)->create([
            'due_date'=> Carbon::parse('+3 week') 
        ]);     
        $order2 = factory(Order::class)->create([
            'due_date'=> Carbon::parse('+1 week') 
        ]);     
        $order3 = factory(Order::class)->create([
            'due_date'=> Carbon::parse('+2 week') 
        ]);     
    
        $sortedOrders = SortedOrder::handle('due_date');

        $this->assertEquals($sortedOrders->first()->due_date->format('Y m d'), Order::find($order2->id)->due_date->format('Y m d'));
    }

    /**
    * @test
    */
    function data_can_be_sorted_in_a_default_way()
    {
        $order1 = factory(Order::class)->create([
            'quantity' => 3
        ]);     
        $order2 = factory(Order::class)->create([
            'quantity' => 2
        ]);     
        $order3 = factory(Order::class)->create([
            'quantity' => 1
        ]);     

        $sortedOrders = SortedOrder::handle(null);

        $this->assertEquals($sortedOrders->first()->quantity, Order::find($order1->id)->quantity);

        
    }

    /**
    * @test
    */
    function data_can_be_sorted_by_product_name()
    {
        
        $product1 = factory(Product::class)->create([
            'name'=>'Name 1'
        ]);
        $product2 = factory(Product::class)->create([
            'name'=>'Name 2'
        ]);
        $product3 = factory(Product::class)->create([
            'name'=>'Name 3'
        ]);
        $order1 = factory(Order::class)->create([
            'product_id'=>$product1->id,
            'quantity' => 3
        ]);     
        $order2 = factory(Order::class)->create([
            'product_id'=>$product2->id,
            'quantity' => 2
        ]);     
        $order3 = factory(Order::class)->create([
            'product_id'=>$product3->id,
            'quantity' => 1
        ]);     

        $sortedOrders = SortedOrder::handle('product_name');

        $this->assertEquals($sortedOrders->first()->product->name, Order::find($order1->id)->product->name);
        
    }
    
    
    
}
