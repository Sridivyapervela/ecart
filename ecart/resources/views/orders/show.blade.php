@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Order id:{{ $order->id }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group">
                                    <li class="list-group-item">Order id:{{$order->id}}</li>
                                    <li class="list-group-item">Userid:{{$order->user_id}}</li>
                                    <li class="list-group-item">User_email:{{$order->user->email}}</li>
                                    <li class="list-group-item">Order amount:{{$order->amount}}
                                    </li>
                                    <li class="list-group-item">Order status:{{$order->status}}
                                    <a class="btn btn-sm btn-primary" href="/orders/{{$order->id}}/edit">Edit status</a></li>
                                    <li class="list-group-item">Ordered at:{{$order->ordered_at}}</li>
                                </ul>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="/orders"><i class="fas fa-arrow-circle-up"></i> Back to orders</a>
                </div>
            </div>
        </div>
    </div>
@endsection