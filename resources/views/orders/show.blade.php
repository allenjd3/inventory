@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Show Product</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>{{$order->product->name}}</h3>
                    <p>Date: {{$order->due_date->format('F d Y')}}</p>
                    <p>Quantity: {{$order->quantity}}</p>
                    <p>Lawson Number: {{$order->product->lawson_number}}</p>
                    <p>Requisition #: {{$order->requisition ?? 'not set'}}</p>
                    <p>Price Per: {{$order->product->priceInDollars()}}</p>
                    <a href="{{route('orders.index')}}" class="btn btn-dark">Back to Orders</a>
                    <a href="{{route('orders.edit', ['id'=>$order->id])}}" class="btn btn-warning mx-2">Edit Order</a>
                    


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
