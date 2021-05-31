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
                                <div class="col-md-9">
                                <ul class="list-group">
                                    <li class="list-group-item">Order id:{{$order->id}}</li>
                                    <li class="list-group-item">User:{{$order->user_id}}</li>
                                    <li class="list-group-item">Order amount:{{$order->amount}}
                                    <a class="btn btn-sm btn-primary" href="/order/edit/{{$order->id}}">Edit status</a>
                                    </li>
                                    <li class="list-group-item">Order status:{{$order->status}}</li>
                                    <li class="list-group-item">Ordered at:{{$order->ordered_at}}</li>
                                </ul>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="/home"><i class="fas fa-arrow-circle-up"></i> Back to home</a>
                </div>
            </div>
        </div>
    </div>
@endsection