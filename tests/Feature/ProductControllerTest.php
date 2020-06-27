<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductsController;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{

    use RefreshDatabase;

    /**
    * @test
    */
    function a_user_can_view_a_product()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product = Product::create([
            'name'=>'Product First',
            'price'=>32.00,
            'lawson_number'=>'23323' 
        ]);
        $response = $this->actingAs($user)->call('GET', '/products/1');
        $response->assertOk();
        $response->assertSee('Product First');
        $response->assertSee('$32.00');
        $response->assertSee('23323');

    }

    /**
    * @test
    */
    function a_user_can_view_all_products()
    {
        
        $user = factory(User::class)->create();
        $this->withoutExceptionHandling();
        $product1 = Product::create([
            'name'=>'Product First',
            'price'=>23.00,
            'lawson_number'=>'34443' 
        ]);
        $product2 = Product::create([
            'name'=>'Product Second',
            'price'=>32.00,
            'lawson_number'=>'23323' 
        ]);
        $response = $this->actingAs($user)->call('GET', '/products');
        $response->assertOk();

        $response->assertSee('Product First');
        $response->assertSee('Product Second');
        $response->assertSee('$23.00');
        $response->assertSee('$32.00');
        $response->assertSee('34443');
        $response->assertSee('23323');
    }

    /**
    * @test
    */
    function a_user_can_store_an_order()
    {
        $this->withoutExceptionHandling();
        $this->withoutMiddleware();
        $product_to_store = factory(Product::class)->make([
            'name'=>'My Amazing Product'
        ]); 

        $response = $this->post('/products', $product_to_store->toArray());
        $response->assertRedirect('products');
        $this->assertEquals('My Amazing Product', Product::first()->name);
    }

    /**
    * @test
    */
    function a_user_can_only_store_valid_data()
    {
        $this->assertActionUsesFormRequest( ProductsController::class, 'store', ProductRequest::class);   
        $this->assertEquals([
            'name'=>'required',
            'price'=>'required | numeric',
            'lawson_number'=>'required' 
        ], ( new ProductRequest() )->rules() );
    }

    /**
    * @test
    */
    function a_user_can_search_products()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();  

        factory(Product::class, 20)->create(); 
        $product = factory(Product::class)->create([
            'name'=>'A Very Specific Name'
        ]);
        $array = ['s'=>'A Very'];
        $formatted_array = http_build_query($array);
        $response = $this->actingAs($user)->get('/products/search?'. $formatted_array );

        $response->assertOk();
        $response->assertSee('A Very Specific Name');
    }
    
    /**
    * @test
    */
    function a_user_can_edit_a_product()
    {
        $this->withoutExceptionHandling();
        $user = factory(User::class)->create();
        $product1 = factory(Product::class)->create();
        $product2 = factory(Product::class)->create([
            'name' => 'Stupid Product' 
        ]);
        
        $product1->refresh();
        $product2->refresh();

        $response1 = $this->actingAs($user)->get('/products/'.$product2->id.'/edit');
        $response1->assertOk();

        $product3 = factory(Product::class)->make([
            'name'=>'My Great Name'
        ]);
        $response2 = $this->actingAs($user)->put('/products/'.$product2->id, $product3->toArray());

        $response2->assertStatus(302);

        $this->assertEquals('My Great Name', Product::findOrFail($product2->id)->name);
        
    }
    
    
    
    
    
}
