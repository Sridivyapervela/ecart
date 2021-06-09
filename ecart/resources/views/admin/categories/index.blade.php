@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header">Categories
                        <a class='btn btn-sm btn-success ml-2' href='/admin/categories/create'>Create Category</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-9">
                                <ul class="list-group">
                                        @foreach($categories as $category)
                                            <li class="list-group-item">
                                                <a title="Show Products" href="/admin/categories/{{ $category->id }}">{{ $category->name }}</a>
                                                <br>
                                                <a class='btn btn-sm btn-danger ml-2' href='/admin/categories/{{$category->id}}/edit'>Edit category</a>
                                                <div class="float-right">
                                                <form autocomplete="off" action="/admin/categories/{{$category->id}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('DELETE')
                                                <input class='btn btn-sm btn-danger' type="submit" value="Delete category">
                                                </form>
                                                </div>
                                            </li>
                                        @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    {{ $categories->links() }}
                </div>

                <div class="mt-4">
                    <a class="btn btn-primary btn-sm" href="{{ URL::previous() }}"><i class="fas fa-arrow-circle-up"></i> Back to Overview</a>
                </div>
            </div>
        </div>
    </div>
@endsection