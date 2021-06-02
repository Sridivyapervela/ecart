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
                            <input class="btn btn-primary mt-4" type="submit" value="Place order">
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
                                        Quantity:{{$quantities}}
                                    </li>
                                    <li class="list-group-item">
                                        Price:{{$product_prices}}
                                    </li>
                                </ul>
                                </div>
                                @endforeach
                            <div class="col-md-4 float-right">
                            Total:{{$total}}  
                            </div>
                            <input type="hidden" name="products[]" value="{{ $products }}">
                            <input type="hidden" name="total" value="{{$total}}">
                            <input type="hidden" name="quantity" value="{{$quantities}}">
                            <input class="btn btn-primary" type="submit" value="Place order">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="/cartlist"><i class="fas fa-arrow-circle-up"></i> Back to cart</a>
                </div>
            </div>
        </div>
    </div>
@endsection