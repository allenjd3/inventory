@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Current Product</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>{{ $product->name }}</h3>
                    <p>Current Price: {{ $product->priceInDollars() }}</p> 
                    <p>Lawson Number {{ $product->lawson_number }}</p> 
                    
                    <a class="btn btn-info" href="{{ route('products.edit', ['id'=>$product->id]) }}">Edit</a>


                </div>

            </div>
        </div>
        <div class="col-md-8 my-4">
            <div class="card">
                <div class="card-header">
                    Create New Order
                </div>
                <div class="card-body">
                    @include('orders._form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
