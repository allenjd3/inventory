<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Order;
use App\Orders\SortedOrder;
use App\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class OrdersController extends Controller
{
    private $pagination = 5; 
    public function __construct(){
        $this->middleware('auth'); 
    }
    
    public function show($order)
    {
        $order = Order::with('product')->findOrFail($order); 
        return view('orders.show', compact('order')); 
    }

    public function index()
    {


        if(Request::has('sorted')){
            $orders = SortedOrder::handle(Request::get('sorted'));
        } 
        else {
            $orders = SortedOrder::handle(null);
        }
        
        return view('orders.index', compact('orders')); 

    }

    public function unreceived()
    {

        if(Request::has('sorted'))
        {
            switch(Request::get('sorted')){
                case 'due_date' :
                    $orders = Order::unReceived()->dueDate()->join('products', 'orders.product_id', '=', 'products.id')->select('orders.*', 'products.name')->paginate($this->pagination);
                    break;
                case 'product_name' :
                    $orders = Order::unReceived()->join('products', 'orders.product_id', '=', 'products.id')->select('orders.*', 'products.name')->orderBy('name','asc')->paginate($this->pagination);
                    break;
                default : 
                    $orders = Order::unReceived()->join('products', 'orders.product_id', '=', 'products.id')->select('orders.*', 'products.name')->paginate($this->pagination);
            }  
        }
        else {
            $orders = Order::unReceived()->join('products', 'orders.product_id', '=', 'products.id')->select('orders.*', 'products.name')->paginate($this->pagination);
        
        }
        
        return view('orders.index', compact('orders')); 
    }

    

    

    public function store(OrderRequest $request)
    {
        $order = Order::create($request->all()); 
        return redirect()->route('orders.index');
    }

    public function togglereceive($id)
    {
        $order = Order::findOrFail($id);

        if($order->received == 1){
            $order->received = 0;
        }
        else {
            $order->received = 1;
        }

        $order->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id); 
        return view('orders.edit', compact('order'));
    }

    public function update($id, OrderRequest $request )
    {

        $order = Order::findOrFail($id);
        $order->update($request->toArray());
        return redirect()->back();
    }
}
