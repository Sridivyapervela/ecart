<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
$userId=Auth::id();
$products=DB::table('carts')
        ->join('products','carts.product_id','=','products.id')
        ->where('carts.user_id',$userId)
        ->select('products.*')
        ->get();
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Cart
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                            <form action="/ordernow" method="POST">
                            @csrf
                            @if($products->count()>0)
                            <input class="btn btn-primary mt-4" type="submit" value="Order now">
                            @endif
                            <br>
                            @foreach($products as $product)
                                <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        @if(file_exists('img/products/' . $product->id . '_thumb.jpg'))
                                                <a href="/img/products/{{$product->id}}_thumb.jpg" data-lightbox="img/products/{{$product->id}}_thumb.jpg" data-title="{{ $product->name }}">
                                                <img class="img-fluid" src="/img/products/{{$product->id}}_thumb.jpg" alt="">
                                                </a>
                                        @endif
                                        <a title="Product details" href="/product/{{ $product->id }}">{{ $product->name }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        Unit price:{{ $product->price }}
                                    </li>
                                    <li class="list-group-item">
                                        <label for="quantity" class="col-md-3 col-form-label text-md-right">{{ __('Quantity') }}</label>
                                        <input name="quantity[]" type="number" min='1' class="form-control @error('quantity') is-invalid @enderror" required>
                                    </li>
                                </ul>
                                </div>
                                <br>
                            @endforeach
                                <input type="hidden" name="products[]" value="{{ $products }}">
                                @if($products->count()>0)
                                <input class="btn btn-primary mt-4" type="submit" value="Order now">
                                @endif
                            </form>
                        </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm " href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to previous</a>
                </div>
            </div>
        </div>
    </div>
@endsection