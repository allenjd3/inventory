@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="alert alert-primary">
                    To Create a New Order, Click on one of the Products Below
                </div>
                <div class="card">
                    <div class="card-header">Products</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Product Name</th>
                                    <th>Cost</th>
                                    <th>Lawson Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td><a href="{{route('products.show', ['product'=>$product->id])}}">{{$product->name}}</a></td>
                                        <td>{{$product->priceInDollars()}}</td>
                                        <td>{{$product->lawson_number}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{$products->appends(['s'=> request()->get('s')])->links()}}
                        <form class="form-inline" method="GET" action="{{route('products.search')}}">

                            <div class="form-group">
                                <label for="search" class="sr-only">Search</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" id="search" name='s' />
                                    <div class="input-group-append">

                                        <button type="submit" class="btn btn-dark">Search</button>
                                    </div>


                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <div class="card my-4">
                    <div class="card-header">
                        Create Product
                    </div>
                    <div class="card-body">
                        @include('products._form')
                    </div>
                </div>
            </div>
        @endsection
