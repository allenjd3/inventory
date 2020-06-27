<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    private $pagination = 5;

    public function __construct(){
        $this->middleware('auth'); 
    }

    public function show($id)
    {
        $product = Product::findOrFail($id); 
        return view('products.show', compact('product')); 
    }

    public function index()
    {
        $products = Product::newestFirst()->paginate($this->pagination);

        return view('products.index', compact('products'));

    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->all());
         
        return redirect()->route('products.index');
    }

    public function search()
    {
        if(request()->has('s')){
            $products = Product::newestFirst()->where('name', 'LIKE', "%".request()->get('s'). "%")->paginate($this->pagination);

            return view('products.index', compact('products'));
        }
        else {
            $products = Product::newestFirst()->paginate($this->pagination);
            return view('products.index', compact('products'));
        
        }
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update($id, ProductRequest $request)
    {
        $product = Product::findOrFail($id); 
        $product->update($request->toArray());
        return redirect()->back();
    }

}
