@extends('layouts.admin_app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit user</div>
                    <div class="card-body">
                        <form autocomplete="off" action="/admin/users/{{$user->id}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" class="form-control {{ $errors->has('first_name') ? 'border-danger' : ''}}" id="first_name" name="first_name" value="{{old('first_name') ?? $user->first_name}}" required autocomplete="first_name" >
                                <small class="form-text text-danger">{!! $errors->first('first_name') !!}</small>
                            </div>
            
                            <div class="form-group">
                            <label for="last_name">{{ __('Last Name') }}</label>
                            <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') ?? $user->last_name }}" required autocomplete="last_name">
                            <small class="form-text text-danger">{!! $errors->first('last_name') !!}</small>
                            </div>

                            <div class="form-group">
                            <label for="email">{{ __('User email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $user->email}}" required autocomplete="email">
                            <small class="form-text text-danger">{!! $errors->first('email') !!}</small>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Save user">
                        </form>
                        <a class="btn btn-primary float-right" href="/admin/users"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection