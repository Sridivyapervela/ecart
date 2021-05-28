@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $product->name }}
                        @auth
                        @if(auth()->user()->role=='admin')
                        <a class='btn btn-sm ml-2' href='/edit/{{$product->id}}'>Edit product</a>
                        <a class='btn btn-sm ml-2' href='/product/destroy/{{$product->id}}'>Delete product</a>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                            @if(file_exists('img/products/' . $product->id . '_large.jpg'))
                                    <a href="/img/products/{{$product->id}}_large.jpg" data-lightbox="img/products/{{$product->id}}_large.jpg" data-title="{{ $product->name }}">
                                        <img class="img-fluid" src="/img/products/{{$product->id}}_large.jpg" alt="">
                                    </a>
                                    <i class="fa fa-search-plus"></i> Click image to enlarge
                            @endif
                            </div>
                            <div class="col-md-9">    
                                <h5>{{ $product->name}}</h5>
                                <ul class="list-group">
                                    <li class="list-group-item">Product_code: {{ $product->code}}</li>
                                    <li class="list-group-item">Product price: {{ $product->price}}</li>
                                    @auth
                                    @if(auth()->user()->role=='admin')
                                    <li class="list-group-item">Product status:{{ $product->status}}</li>
                                    <li class="list-group-item">Available stock:{{ $product->available_stock}}</li>
                                    @endif
                                    @endauth
                                    <li class="list-group-item">Category_id: {{ $product->category_id}}</li>
                                </ul>
                                <br>
                                <a class="btn btn-sm btn-success float-left" href="">Add to cart</a>
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