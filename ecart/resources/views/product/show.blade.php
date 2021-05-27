@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $product->name }}
                        @if($user->role=='admin')
                        <a class='btn btn-sm ml-2' href='/edit/{{$product->id}}'>Edit product</a>
                        <a class='btn btn-sm ml-2' href='/product/destroy/{{$product->id}}'>Delete product</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                
                                <h5>{{ $product->name}}</h5>
                                <ul class="list-group">
                                    <li>Product_code: {{ $product->code}}</li>
                                    <li>Product price: {{ $product->price}}</li>
                                    @if($user->role=='admin')
                                    <li>Product status:{{ $product->status}}</li>
                                    <li>Available stock:{{ $product->available_stock}}</li>
                                    @endif
                                    <li>Category_id: {{ $product->category_id}}</li>
                                </ul>
                                <a class="btn btn-sm btn-success float-left" href="">Buy now</a>
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