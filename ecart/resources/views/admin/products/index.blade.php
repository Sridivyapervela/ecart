@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Products
                        <a class='btn btn-sm btn-success ml-2' href='/admin/products/create'>Create product</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                            <div class="col-md-11">
                                @foreach($products as $product)
                                <ul class="list-group">
                                            <li class="list-group-item">
                                                @if(file_exists('img/products/' . $product->id . '_thumb.jpg'))
                                                <a href="/img/products/{{$product->id}}_thumb.jpg" data-lightbox="img/products/{{$product->id}}_thumb.jpg" data-title="{{ $product->name }}">
                                                <img class="img-fluid" src="/img/products/{{$product->id}}_thumb.jpg" alt="">
                                                </a>
                                                @endif                                    
                                                <h5>{{ $product->name}}</h5>
                                                Product_code: {{ $product->code}}
                                                 <br>
                                                Product price: {{ $product->price}}
                                                 <br>
                                                Product status:{{ $product->status}}
                                                <br>
                                                Available stock:{{ $product->available_stock}}
                                                <br>
                                                Category_id: {{ $product->category_id}}
                                                <br>
                                                <a class='btn btn-sm btn-danger ml-2' href='/admin/products/{{$product->id}}/edit'>Edit product</a>
                                                <div class="float-right">
                                                <form autocomplete="off" action="/admin/products/{{$product->id}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                 @method('DELETE')
                                                <input class='btn btn-sm btn-danger' type="submit" value="Delete product">
                                                </form>
                                                </div>
                                            </li>
                                </ul>
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