@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">All Orders</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th><a class="text-white" href="?sorted=product_name">Product Name</a></th>
                                <th><a class="text-white" href="?sorted=due_date">Due Date</a></th>
                                <th>Quantity</th>
                                <th>Received?</th>
                                <th>Bring Into Inventory</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td><a href="{{route('orders.show', ['order'=>$order->id])}}">{{$order->name}}</a></td>
                                    @if ($order->due_date->isPast() && $order->received)
                                        <td class="text-success">received</td>
                                    @elseif ($order->due_date->isPast())
                                        <td class="text-danger">Past Due- {{$order->due_date->format('F d Y')}}</td>
                                    @else
                                        <td>{{$order->due_date->format('F d Y')}}</td>
                                    @endif
                                    <td>{{$order->quantity}}</td>
                                    @if ($order->received)
                                        <td><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-1.25 16.518l-4.5-4.319 1.396-1.435 3.078 2.937 6.105-6.218 1.421 1.409-7.5 7.626z"/></svg></td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        @if ($order->received)
                                            <form method="POST" action="{{route('orders.togglereceive', ['id'=>$order->id])}}">
                                                @csrf
                                                @if(app('request')->input('sorted'))
                                                    <input type="hidden" name="sorted" value="{{app('request')->input('sorted')}}"/>

                                                @endif

                                                <button type="submit" class="btn btn-warning">Unreceive</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{route('orders.togglereceive', ['id'=>$order->id])}}">
                                                @csrf
                                                @if(app('request')->input('sorted'))
                                                    <input type="hidden" name="sorted" value="{{app('request')->input('sorted')}}"/>

                                                @endif
                                                <button type="submit" class="btn btn-info">Receive</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(app('request')->has('sorted'))

                        {{$orders->appends('sorted', app('request')->get('sorted'))->links()}}
                    @else

                        {{$orders->links()}}
                    @endif
                    <a href="{{route('products.index')}}" class="btn btn-warning">Create New Order</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
