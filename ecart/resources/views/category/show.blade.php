@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">{{ $category->name }}
                        @auth
                        @if(auth()->user()->role=='admin')
                        <a class='btn btn-sm ml-2' href='/edit/{{$category->id}}'>Edit category</a>
                        <a class='btn btn-sm ml-2' href='/category/destroy/{{$category->id}}'>Delete category</a>
                        @endif
                        @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                
                                <h5>Products in {{ $category->name}}</h5>
                                <ul class="list-group">
                                    @if($category->products->count() > 0)
                                        @foreach($category->products as $category)
                                            <li class="list-group-item">
                                                
                                                &nbsp;<a title="Show Details" href="/category/{{ $category->id }}">{{ $category->name }}</a>
                                            </li>
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
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to Overview</a>
                </div>
            </div>
        </div>
    </div>
@endsection