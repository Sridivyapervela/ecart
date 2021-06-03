@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Products
                    @auth
                        @if(auth()->user()->role=='admin')
                        <a class='btn btn-sm btn-success ml-2' href='/product/create'>Create product</a>
                        @endif
                    @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="col-md-11">
                                @foreach($products as $product)
                                @if($product->status=='active')
                                <ul class="list-group">
                                            <li class="list-group-item">
                                                @if(file_exists('img/products/' . $product->id . '_thumb.jpg'))
                                                <a href="/img/products/{{$product->id}}_thumb.jpg" data-lightbox="img/products/{{$product->id}}_thumb.jpg" data-title="{{ $product->name }}">
                                                <img class="img-fluid" src="/img/products/{{$product->id}}_thumb.jpg" alt="">
                                                </a>
                                                @endif
                                                <a title="Product details" href="/product/{{ $product->id }}">{{ $product->name }}</a>
                                                <form action="/add_to_cart" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                                <input class="btn btn-success mt-4 float-right" type="submit" value="Add to cart">
                                                </form>
                                            </li>
                                </ul>
                                @endif
                                @endforeach
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to Overview</a>
                </div>
                <div>
                {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection