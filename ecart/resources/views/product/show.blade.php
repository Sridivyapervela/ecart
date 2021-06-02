@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $product->name }}
                        @auth
                        @if(auth()->user()->role=='admin')
                        <a class='btn btn-sm btn-danger ml-2' href='/product/{{$product->id}}/edit'>Edit product</a>
                        <a class='btn btn-sm btn-danger ml-2' href='/product/delete/{{$product->id}}'>Delete product</a>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <form action="/add_to_cart" method="POST">
                         @csrf
                            <div class="col-md-9">
                            @if(file_exists('img/products/' . $product->id . '_large.jpg'))
                                    <a href="/img/products/{{$product->id}}_large.jpg" data-lightbox="img/products/{{$product->id}}_large.jpg" data-title="{{ $product->name }}">
                                        <img class="img-fluid" src="/img/products/{{$product->id}}_large.jpg" alt="">
                                    </a>
                                    <i class="fa fa-search-plus"></i> Click image to enlarge
                            @endif
                            </div>
                            <div class="col-md-12">    
                                <h5>{{ $product->name}}</h5>
                                    Product_code: {{ $product->code}}
                                    <br>
                                    Product price: {{ $product->price}}
                                    <br>
                                    @auth
                                    @if(auth()->user()->role=='admin')
                                    Product status:{{ $product->status}}
                                    <br>
                                    Available stock:{{ $product->available_stock}}
                                    <br>
                                    @endif
                                    @endauth
                                    Category_id: {{ $product->category_id}}
                                <br>
                                    <input type="hidden" name="product_id" value="{{$product->id}}">
                                    <input class="btn btn-success mt-4 float-left" type="submit" value="Add to cart">
                        </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to previous</a>
                </div>
            </div>
        </div>
    </div>
@endsection