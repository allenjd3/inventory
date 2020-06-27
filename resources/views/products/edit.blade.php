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
                    


                </div>
            </div>
        </div>
        <div class="col-md-8 my-4">
            <div class="card">
                <div class="card-header">
                    Create New Order
                </div>
                <div class="card-body">

                    <form action="{{ route('products.update', ['id'=> $product->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Product Name: </label>
                            <input type="text" id="name" class="form-control" name="name" value="{{$product->name ?? old( 'name' )}}" />
                            @error('name')
                            <div class="text-danger">{{$message}}</div>
                        @enderror

                        </div>
                        <div class="form-group">
                            <label for="price">Cost of Product: </label>
                            <input type="number" min="0.01" step="0.01" class="form-control" name="price" value="{{$product->price ?? old('price')}}"/>
                            @error('price')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                        </div>
                        <div class="form-group">
                            <label for="lawson_number">Lawson Number: </label>
                            <input type="text" id="lawson_number" class="form-control" name="lawson_number" value="{{$product->lawson_number ?? old('lawson_number')}}"/>
                            @error('lawson_number')
                            <div class="text-danger">{{$message}}</div>
                        @enderror
                        </div>
                        <button type="submit" class="btn btn-dark">Update Product</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
