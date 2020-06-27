<?php

namespace Tests\Feature;

use App\Http\Controllers\OrdersController;
use App\Http\Requests\OrderRequest;
use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_view_a_order()
    {
        $this->withoutMiddleware();
        $this->withoutExceptionHandling();
        factory(Product::class)->create();
        
        $order = Order::create([
            'product_id'=>1,
            'quantity'=>3,
            'due_date'=> Carbon::parse('+1 week'),
            'received'=>false
        ]);

        $response = $this->call('GET', '/orders/1');
        $response->assertOk();
        $response->assertSee(Carbon::parse('+1 week')->format('F d Y'));
        $response->assertSee('3');

    }

    /**
    * @test
    */
    function a_user_can_show_all_orders()
    {
        $user = factory(User::class)->create();
        $this->withoutExceptionHandling();
        $product = factory(Product::class)->create();

        $order = Order::create([
            'product_id'=>$product->id,
            'quantity'=>3,
            'due_date'=> Carbon::parse('+1 week'),
            'received'=>false
        ]);

        $order1 = Order::create([
            'product_id'=>$product->id,
            'quantity'=>5,
            'due_date'=> Carbon::parse('+2 week'),
            'received'=>true
        ]);
        $response = $this->actingAs($user)->call('GET', '/orders');
        $response->assertOk();

        $response->assertSee('3');
        $response->assertSee('5');
        
    }
    
    /**
    * @test
    */
    function a_user_can_store_an_order()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();
        $order_to_store = factory(Order::class)->make([
            'quantity'=>78 
        ]); 

        $response = $this->post('/orders', $order_to_store->toArray());
        $response->assertRedirect('orders');
        $this->assertEquals(78, Order::first()->quantity);
    }

    /**
    * @test
    */
    function a_user_can_only_store_valid_data()
    {
        $this->assertActionUsesFormRequest( OrdersController::class, 'store', OrderRequest::class);   
        $this->assertEquals([
            'product_id'=>'required | numeric',
            'quantity'=>'required | numeric',
            'due_date'=> 'required | date',
        ], ( new OrderRequest() )->rules() );
    }

    /**
    * @test
    */
    function a_user_can_order_orders_by_due_date()
    {
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $order2 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'due_date'=>Carbon::parse('+1 week') 
        ]);
        $order3 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'due_date'=>Carbon::parse('+2 week') 
        ]);
        $order1 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'due_date'=>Carbon::parse('+1 day') 
        ]);

        $response = $this->actingAs($user)->call('GET', '/orders?sorted=due_date');
        $response->assertSeeInOrder([ $order1->due_date->format('F d Y'), $order2->due_date->format('F d Y'), $order3->due_date->format('F d Y')]);
        
        
    }
    /**
    * @test
    */
    function a_user_can_order_orders_by_whether_they_are_un_received()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $order2 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'received'=>1
        ]);
        $order3 = factory(Order::class)->create([
            'product_id'=>$product->id,
            
        ]);
        $order1 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'received'=>1
        ]);

        $response = $this->actingAs($user)->call('GET', '/orders/unreceived');
        $response->assertOk();
        $response->assertSeeInOrder([$order3->due_date->format('F d Y') ]);
        
        
    }

    /**
    * @test
    */
    function a_user_can_receive_orders()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $order1 = factory(Order::class)->create([
            'product_id'=>$product->id
        ]); 
        $order1->refresh();
        
        $response = $this->actingAs($user)->call('POST', '/orders/toggle-receive/1');
        $response->assertStatus(302);

        $this->assertEquals(1, Order::find($order1->id)->received);
        

    }
    /**
    * @test
    */
    function a_user_can_unreceive_orders()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $order1 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'received' => 1
        ]); 
        $order1->refresh();
        
        $response = $this->actingAs($user)->call('POST', '/orders/toggle-receive/1');
        $response->assertStatus(302);

        $this->assertEquals(0, Order::find($order1->id)->received);
        

    }
    
    /**
    * @test
    */
    function a_user_can_edit_an_order()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = factory(Product::class)->create();
        $order1 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'quantity'=>23
        ]);
        $order2 = factory(Order::class)->create([
            'product_id'=>$product->id,
            'quantity'=>34
        ]);
        
        $order2->refresh();
        $response1 = $this->actingAs($user)->get('/orders/'.$order2->id.'/edit');
        $response1->assertOk();

        $order3 = factory(Order::class)->make([
            'product_id'=>$product->id,
            'quantity'=>45
        ]);
        $response2 = $this->actingAs($user)->put('/orders/'.$order2->id, $order3->toArray());

        $response2->assertStatus(302);

        $this->assertEquals(45, Order::findOrFail($order2->id)->quantity);
        
    }
    
    
    
    
}
