@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Create New User</div>
                    <div class="card-body">
                        <form autocomplete="off" action="/user" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">First_name</label>
                                <input type="text" class="form-control {{ $errors->has('first_name') ? 'border-danger' : ''}}" id="first_name" name="first_name" value="{{old('first_name')}}" >
                                <small class="form-text text-danger">{!! $errors->first('first_name') !!}</small>
                            </div>
                            <div class="form-group">
                                <label for="name">Last_name</label>
                                <input type="text" class="form-control {{ $errors->has('last_name') ? 'border-danger' : ''}}" id="last_name" name="last_name" value="{{old('last_name')}}" >
                                <small class="form-text text-danger">{!! $errors->first('last_name') !!}</small>
                            </div>
                            <div class="form-group">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            <small class="form-text text-danger">{!! $errors->first('email') !!}</small>
                            </div>
                            <div class="form-group">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" >
                            <small class="form-text text-danger">{!! $errors->first('password') !!}</small>
                            </div>
                            <div class="form-group">
                            <label for="password_confirm" class="col-md-4 col-form-label text-md-right">{{ __('ConfirmPassword') }}</label>
                            <input id="password_confirm" type="password" class="form-control @error('password_confirm') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password">
                            <small class="form-text text-danger">{!! $errors->first('password_confirm') !!}</small>
                            </div>

                            <input class="btn btn-primary mt-4" type="submit" value="Save user">
                        </form>
                        <a class="btn btn-primary float-right" href="/user"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection