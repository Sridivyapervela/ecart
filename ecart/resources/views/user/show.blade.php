@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Hello {{ $user->firstname $user->lastname}},your orders
                        <b>{{ $user->role }}</b>
                        @if($user->role=='admin')
                        <a class='btn btn-sm ml-2' href='/edit/{{$user->id}}'>Edit User</a>
                        <a class='btn btn-sm ml-2' href='/user/destroy/{{$user->id}}'>Delete User</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <ul class="list-group">
                                    @if($user->orders->count() > 0)
                                        @foreach($user->orders as $order)
                                            <li class="list-group-item">
                                                
                                                &nbsp;<a title="Show Details" href="/order/{{ $order->id }}">{{ $order->ordered_at  $order->status }}</a>
                                                <br>
                                                @foreach($order->order_items as $order_item and $order_item->products as $order_item_product)
                                                    <a href="/order/order_item/{{ $order_item->id }}"><span>{{ $order_item->id }}</span></a>
                                                    <br>
                                                    <a href="/order/order_item/product/{{ $order_item_product->id }}"><span>{{ $order_item->products->name }}</span></a>
                                                    
                                                @endforeach
                                            </li>
                                        @endforeach
                                </ul>
                                @else
                                    <p>
                                        {{ $user->name }} has not placeded any orders yet.
                                    </p>
                                @endif
                            </div>
                        </div>


                    </div>

                </div>

                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to Overview</a>
                </div>
            </div>
        </div>
    </div>
@endsection