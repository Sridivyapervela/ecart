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
                        <a class='btn btn-sm btn-danger ml-2' href='/users/delete/{{$user->id}}'>Delete User</a>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <ul class="list-group">
                                    @auth
                                        @if($user->orders->count() > 0)
                                        @foreach($user->orders as $order)
                                            <li class="list-group-item">                                                
                                                &nbsp;<a title="Show Details" href="/orders/{{ $order->id }}">Ordered at:{{ $order->ordered_at }} </a>
                                                <br>Order status:{{$order->status}} 
                                                <br>
                                                @foreach($order->order_items as $orderItem)
                                                    Order item id:<span class="ml-lg-2">{{ $orderItem->id }}</span>
                                                    Order item product id:<a href="/products/{{ $orderItem->product_id }}"><span>{{ $orderItem->product_id }}</span></a>
                                                    <br>
                                                @endforeach
                                            </li>
                                        @endforeach
                                </ul>
                                @else
                                    <p>
                                        {{$user->first_name }} {{$user->last_name}} has not placeded any orders yet.
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