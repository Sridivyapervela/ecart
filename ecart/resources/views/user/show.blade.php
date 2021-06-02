@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Hello {{ $user->firstname}} {{$user->lastname}},your orders
                        <b>{{ $user->role }}</b>
                        @auth
                        @if(auth()->user()->role=='admin')
                        <a class='btn btn-sm ml-2' href='/user/{{$user->id}}/edit'>Edit User</a>
                        <a class='btn btn-sm ml-2' href='/user/delete/{{$user->id}}'>Delete User</a>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <ul class="list-group">
                                    @auth
                                        @if(auth()->user()->orders->count() > 0)
                                        @foreach(auth()->user()->orders as $order)
                                            <li class="list-group-item">
                                                
                                                &nbsp;<a title="Show Details" href="/order/{{ $order->id }}">{{ $order->ordered_at }} {{$order->status}} </a>
                                                <br>
                                                @foreach($order->orderItems as $orderItem and $orderItem->products as $orderItem_product)
                                                    <a href="/order/orderItem/{{ $orderItem->id }}"><span>{{ $orderItem->id }}</span></a>
                                                    <br>
                                                    <a href="/order/orderItem/product/{{ $orderItem_product->id }}"><span>{{ $orderItem_product->name }}</span></a>
                                                    
                                                @endforeach
                                            </li>
                                        @endforeach
                                </ul>
                                @else
                                    <p>
                                        {{auth()->user()->name }} has not placeded any orders yet.
                                    </p>
                                @endif
                                @endauth
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