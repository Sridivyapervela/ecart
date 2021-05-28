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
                                                <a class="btn btn-sm btn-success float-left" href="">Add to cart</a>
                                            </li>
                                </ul>
                                </div>
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