@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $category->name }}
                        @auth
                        @if(auth()->user()->role=='admin')
                        <a class='btn btn-sm btn-danger ml-2' href='/category/{{$category->id}}/edit'>Edit category</a>
                        <a class='btn btn-sm btn-danger ml-2' href='/category/delete/{{$category->id}}' action="categort.destroy">Delete category</a>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                
                                <h5>Products in {{ $category->name}}</h5>
                                <ul class="list-group">
                                    @if($category->products->count() > 0)
                                        @foreach($category->products as $product)
                                        @if($product->status=='active')
                                            <li class="list-group-item">    
                                                &nbsp;<a title="Show Details" href="/product/{{ $product->id }}">{{ $product->name }}</a>
                                                &nbsp;<p>Product price:{{ $product->price }}</p>
                                            </li> 
                                        @endif                                         
                                        @endforeach
                                    @else
                                    <p>
                                        {{ $product->name }} has no products yet.
                                    </p>
                                    @endif
                                </ul>
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