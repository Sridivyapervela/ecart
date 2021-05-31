@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Products
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($products as $product)
                                @if($product->status=='active')
                                <div class="col-md-4 float-left">
                                @if(file_exists('img/products/' . $product->id . '_thumb.jpg'))
                                <a href="/img/products/{{$product->id}}_thumb.jpg" data-lightbox="img/products/{{$product->id}}_thumb.jpg" data-title="{{ $product->name }}">
                                    <img class="img-fluid" src="/img/products/{{$product->id}}_thumb.jpg" alt="">
                                </a>
                                @endif
                                </div>
                                <div class="col-md-9">
                                <ul class="list-group">
                                            <li class="list-group-item">
                                                <a title="Product details" href="/product/{{ $product->id }}">{{ $product->name }}</a>
                                                <form action="/add_to_cart" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <input class="btn btn-success mt-4 float-right" type="submit" value="Add to cart">
                                                </form>
                                            </li>
                                </ul>
                                </div>
                                @endif
                                @endforeach
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