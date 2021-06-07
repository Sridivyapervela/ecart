@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Orders
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($orders as $order)
                                <div class="col-md-12">
                                <ul class="list-group margin-bottom:4px padding-bottom: 4px">
                                    <li class="list-group-item"> Order id:{{$order->id}}<br>
                                    Userid:{{$order->user_id}}<br>
                                    User_email:{{$order->user->email}}<br>
                                    Order amount:{{$order->amount}}<br>
                                    
                                    Order status:{{$order->status}}
                                    <a class="btn btn-sm btn-primary" href="/orders/{{$order->id}}/edit">Edit status</a><br>
                                    Ordered at:{{$order->ordered_at}}
                                    </li>
                                </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="/"><i class="fas fa-arrow-circle-up"></i> Back to home</a>
                </div>
            </div>
        </div>
    </div>
@endsection