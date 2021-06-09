<?php
$count = -1; ?>
@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Final order
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                            <form action="/placeorder" method="POST">
                            @csrf
                            @if($products->count() >0)
                            <input class="btn btn-primary mt-4" type="submit" value="Place order">
                            @endif
                            <br>
                            <?php $total = 0; ?>
                                @foreach($products as $cart)
                                <?php $total =
                                  $total +
                                  $cart->product->price * $cart->quantity; ?>
                                <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        @if(file_exists('img/products/' . $cart->product->id . '_thumb.jpg'))
                                                <a href="/img/products/{{$cart->product->id}}_thumb.jpg" data-lightbox="img/products/{{$cart->product->id}}_thumb.jpg" data-title="{{ $cart->product->name }}">
                                                <img class="img-fluid" src="/img/products/{{$cart->product->id}}_thumb.jpg" alt="">
                                                </a>
                                         @endif
                                        <a title="Product details" href="/product/{{ $cart->product->id }}">{{ $cart->product->name }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        Unit price:{{ $cart->product->price }}
                                    </li>
                                    <li class="list-group-item">
                                        Quantity:{{$cart->quantity}}
                                    </li>
                                    <li class="list-group-item">
                                        Price:{{$cart->product->price * $cart->quantity}}
                                    </li>
                                </ul>
                                </div>
                                @endforeach
                            @if($products->count() >0)
                            <div class="col-md-4 float-right">
                            Total:{{$total}}  
                            </div>
                            <input type="hidden" name="total" value="{{$total}}">
                            <input class="btn btn-primary" type="submit" value="Place order">
                            @endif
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="/"><i class="fas fa-arrow-circle-up"></i> Back to products</a>
                </div>
            </div>
        </div>
    </div>
@endsection