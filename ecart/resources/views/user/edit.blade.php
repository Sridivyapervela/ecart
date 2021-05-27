@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Edit User</div>
                    <div class="card-body">
                        <form autocomplete="off" action="/user/{{$user->id}}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="first_name">First_name</label>
                                <input type="text" class="form-control{{ $errors->has('first_name') ? ' border-danger' : '' }}" id="first_name" name="first_name" value="{{ old('first_name') ?? $user->first_name }}">
                                <small class="form-text text-danger">{!! $errors->first('first_name') !!}</small>
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last_name</label>
                                <input type="text" class="form-control{{ $errors->has('last_name') ? ' border-danger' : '' }}" id="last_name" name="last_name" value="{{ old('last_name') ?? $user->last_name }}">
                                <small class="form-text text-danger">{!! $errors->first('last_name') !!}</small>
                            </div>
                            <div class="form-group">
                                <label for="email_id">Email_id</label>
                                <input type="email_id" name="email_id" class="form-control{{ $errors->has('email_id') ? ' border-danger' : '' }}">  {{old('email_id') ?? $user->email_id}}</textarea>
                                <small class="form-text text-danger">{!! $errors->first('email_id') !!}</small>
                            </div>
                            <input class="btn btn-primary mt-4" type="submit" value="Save User">
                        </form>
                        <a class="btn btn-primary float-right" href="/user"><i class="fas fa-arrow-circle-up"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection