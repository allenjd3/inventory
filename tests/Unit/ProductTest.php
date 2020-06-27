<?php

namespace Tests\Unit;

use App\Order;
use App\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    /**
    * @test
    */
    function a_product_can_change_the_price_to_dollars()
    {
        $product = factory(Product::class)->create([
            'price'=>32.00
        ]);
        $this->assertDatabaseHas('products', ['price'=>3200]);
        $this->assertEquals('$32.00', $product->priceInDollars());
        
    }
    /**
    * @test
    */
    function a_product_has_many_orders()
    {
        $product = factory(Product::class)->create([
            'name'=>'My Product Name is cool' 
        ]);
        $order = factory(Order::class, 5)->create([
            'product_id'=>$product->id 
        ]);
        $this->assertEquals(5, $product->orders()->count());


        
    }

    
    
}
