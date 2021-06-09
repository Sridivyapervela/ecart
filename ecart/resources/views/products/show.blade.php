@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $product->name }}
                    </div>
                    <div class="card-body">
                        <div class="row">
                        <form action="/carts" method="POST">
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
                                    Category_id: {{ $product->category_id}}
                                <br>
                                    <form action="/carts" method="POST">
                                                @csrf
                                                <div class="col-xs-2">
                                                <label for="quantity" class=" text-md-right">{{ __('Quantity') }}</label>
                                                <input name="quantity" type="number" min='1' class="form-control @error('quantity') is-invalid @enderror" required>
                                                </div>
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <input class="btn btn-success mt-4 float-right" type="submit" value="Add to cart">
                                                </form>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="/products"><i class="fas fa-arrow-circle-up"></i> Back to products</a>
                </div>
            </div>
        </div>
    </div>
@endsection