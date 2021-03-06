@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit product</div>
                    <div class="card-body">
                        <form autocomplete="off" action="/admin/products/{{$product->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name"> Product Name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'border-danger' : ''}}" id="name" name="name" value="{{old('name') ?? $product->name}}" >
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>
            
                            <div class="form-group">
                            <label for="code">{{ __('Product Code') }}</label>
                            <input id="code" type="number" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code')?? $product->code }}" required autocomplete="code">
                            <small class="form-text text-danger">{!! $errors->first('code') !!}</small>
                            </div>

                            <div class="form-group">
                            <label for="price">{{ __('Product price') }}</label>
                            <input id="price" type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price')?? $product->price }}" required autocomplete="price">
                            <small class="form-text text-danger">{!! $errors->first('price') !!}</small>
                            </div>

                            <div class="form-group">
                            <label for="available_stock">{{ __('Product available_stock') }}</label>
                            <input id="available_stock" type="number" class="form-control @error('available_stock') is-invalid @enderror" name="available_stock" value="{{ old('available_stock')?? $product->available_stock }}" required autocomplete="available_stock">
                            <small class="form-text text-danger">{!! $errors->first('available_stock') !!}</small>
                            </div>

                            <div class="form-group">
                            <label for="status">{{ __('Product status  ') }}</label>
                            <input id="status" placeholder="active/inactive" class="form-control @error('status') is-invalid @enderror" name="status" value="{{ old('status')?? $product->status }}" required autocomplete="status">
                            <small class="form-text text-danger">{!! $errors->first('status') !!}</small>
                            </div>

                            <div class="form-group">
                            <label for="category_id" >{{ __('Category_id ') }}</label>
                            <input id="category_id" placeholder="select existing category_id" type="number" class="form-control @error('category_id') is-invalid @enderror" name="category_id" value="{{ old('category_id')?? $product->category_id }}" required autocomplete="category_id">
                            <small class="form-text text-danger">{!! $errors->first('category_id') !!}</small>
                            </div>
                            <div class="form-group">
                            <label for="image">{{ __('Product Image ') }}</label>
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') ?? $product->image}}"  autocomplete="image">
                            <small class="form-text text-danger">{!! $errors->first('image') !!}</small>
                            </div>

                            <input class="btn btn-primary mt-4" type="submit" value="Save product">
                        </form>
                        <a class="btn btn-primary float-right" href="/admin/products"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

