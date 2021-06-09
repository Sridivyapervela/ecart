@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $category->name }}
                        <a class='btn btn-sm btn-danger ml-2' href='/admin/categories/{{$category->id}}/edit'>Edit category</a>
                        <div class="float-right">
                            <form autocomplete="off" action="/admin/categories/{{$category->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('DELETE')
                            <input class='btn btn-sm btn-danger' type="submit" value="Delete category">
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                            @if($category->products->count() > 0)
                            <h5>Products in {{ $category->name}}</h5>
                                <ul class="list-group">
                                        @foreach($category->products as $product)
                                        @if($product->status=='active')
                                            <li class="list-group-item">
                                                @if(file_exists('img/products/' . $product->id . '_thumb.jpg'))
                                                <a href="/img/products/{{$product->id}}_thumb.jpg" data-lightbox="img/products/{{$product->id}}_thumb.jpg" data-title="{{ $product->name }}">
                                                <img class="img-fluid" src="/img/products/{{$product->id}}_thumb.jpg" alt="">
                                                </a>
                                                @endif    
                                                &nbsp;<a title="Show Details" href="/admin/products/{{ $product->id }}">{{ $product->name }}</a>
                                                &nbsp;<p>Product price:{{ $product->price }}</p>
                                            </li> 
                                        @endif                                         
                                        @endforeach
                                </ul>
                            @else
                            <p>
                            {{ $category->name }} has no products yet.
                            </p>
                            @endif
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