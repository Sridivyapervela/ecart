@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create New Category</div>
                    <div class="card-body">
                        <form autocomplete="off" action="/category" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control {{ $errors->has('name') ? 'border-danger' : ''}}" id="name" name="name" value="{{old('name')}}" >
                                <small class="form-text text-danger">{!! $errors->first('name') !!}</small>
                            </div>
            
                            <div class="form-group">
                            <label for="code" class="col-md-4 col-form-label text-md-right">{{ __('Category Code') }}</label>
                            <input id="code" type="number" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code">
                            <small class="form-text text-danger">{!! $errors->first('code') !!}</small>
                            </div>
            
                            <input class="btn btn-primary mt-4" type="submit" value="Save category">
                        </form>
                        <a class="btn btn-primary float-right" href="/category"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection