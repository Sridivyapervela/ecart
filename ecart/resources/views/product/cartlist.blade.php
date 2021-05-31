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
                            <input class="btn btn-primary mt-4" type="submit" value="Order now">
                            <br>
                                @foreach($products as $product)
                                <div class="col-md-6 float-left">
                                @if(file_exists('img/products/' . $product->id . '_thumb.jpg'))
                                <a href="/img/products/{{$product->id}}_thumb.jpg" data-lightbox="img/products/{{$product->id}}_thumb.jpg" data-title="{{ $product->name }}">
                                    <img class="img-fluid" src="/img/products/{{$product->id}}_thumb.jpg" alt="">
                                </a>
                                @endif
                                </div>
                                <div class="col-md-6 float-right">
                                <ul class="list-group">
                                    <li class="list-group-item">
                                        <a title="Product details" href="/product/{{ $product->id }}">{{ $product->name }}</a>
                                    </li>
                                    <li class="list-group-item">
                                        Unit price:{{ $product->price }}
                                    </li>
                                    <li class="list-group-item">
                                        <label for="quantity" class="col-md-3 col-form-label text-md-right">{{ __('Quantity') }}</label>
                                        <input id="quantity" type="number" class="form-control @error('quantity') is-invalid @enderror" name="quantity" required>
                                    </li>
                                </ul>
                                </div>
                                <br>
                                @endforeach
                                <input class="btn btn-primary mt-4" type="submit" value="Order now">
                            </form>
                        </div>
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