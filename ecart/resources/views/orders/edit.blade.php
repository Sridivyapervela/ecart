<?php
$user_id = $order->user_id;
$amount = $order->amount;
$ordered_at = $order->ordered_at;
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit order</div>
                    <div class="card-body">
                        <form autocomplete="off" action="/orders/{{$order->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <ul class="list-group">
                                    <li class="list-group-item">Order id:{{$order->id}}</li>
                                    <li class="list-group-item">User:{{$order->user_id}}</li>
                                    <li class="list-group-item">Order amount:{{$order->amount}}</li>
                                    <li class="list-group-item">Ordered at:{{$order->ordered_at}}</li>
                                    <li class="list-group-item">
                                    <label for="status" class="col-form-label text-md-right">{{ __('Order status') }}</label>
                                    <input id="status" type="text" placeholder="success/failed" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status') }}" required autocomplete="status">
                                    <small class="form-text text-danger">{!! $errors->first('status') !!}</small>
                                    </li>
                                </ul>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Save order">
                        </form>
                        <a class="btn btn-primary float-right" href="/orders"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

