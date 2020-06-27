@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Show Order</div>

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
                    <p>Price Per: {{$order->product->priceInDollars()}}</p>
                    <p>Requisition #: {{$order->requisition ?? 'not set'}}</p>
                    <a href="{{route('orders.index')}}" class="btn btn-dark">Back to Orders</a>
                    


                </div>
            </div>
            <div class="card my-4">
                <div class="card-header">Edit Order</div>
                <div class="card-body">
                    <form action="{{ route('orders.update', ['id'=>$order->id]) }}" method="POST">
                        @csrf
                        @method('put')
                        <input type="hidden" name="product_id" value="{{$order->product_id}}"/>
                        <div class="form-group">
                            <label for="quantity">Quantity: </label>
                            <input id="quantity" type="number" min="1" step="1" name="quantity" value="{{$order->quantity ?? old('quantity')}}" class="form-control" />
                            @error('quantity')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="due_date">Due Date: </label>
                            <input type="date" id="due_date" name="due_date" value="{{$order->due_date->format('Y-m-d') ?? old('due_date')}}" class="form-control" />
                            @error('due_date')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror

                        </div>
                        <div class="form-group">
                            <label for="requisition">Requisition #: </label>
                            <input type="text" id="requisition" name="requisition" value="{{$order->requisition ?? old('requisition')}}" class="form-control" />
                            @error('requistion')
                            <div class="text-danger"> {{ $message }}</div>
                        @enderror
                        </div>
                        <button class="btn btn-dark" type="submit">Edit Order</button>
                    </form>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
