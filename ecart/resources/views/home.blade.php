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
                            <div class="col-md-20">
                                <ul class="list-group">
                                        @foreach($products as $product)
                                            <li class="list-group-item">
                                                <a title="Product details" href="/product/show/{{ $product->id }}">{{ $product->name }}</a>
                                                <a class="btn btn-sm btn-success float-right" href="">Add to cart</a>
                                            </li>
                                        @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $products->links() }}
                </div>
                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to top</a>
                </div>
            </div>
        </div>
    </div>
@endsection
<!-- @extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->
