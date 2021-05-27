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
                            <div class="col-md-9">
                                <ul class="list-group">
                                        @foreach($products as $product)
                                            <li class="list-group-item">
                                                <a title="Product details" href="/product/show/{{ $product->id }}">{{ $product->name }}</a>
                                                <a class="btn btn-sm btn-success float-left" href="">Buy now</a>
                                            </li>
                                        @endforeach
                                </ul>
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