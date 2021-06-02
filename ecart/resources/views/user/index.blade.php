@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header align-center">
                    Hello Admin
                    </div>
                    <div class="card-body">
                        <div class="row">
                         @foreach($users as $user)
                                <ul class="list-group col-md-11">
                                <li class="list-group-item">
                                <p class="ml-2">{{ $user->firstname}} {{ $user->lastname}}</p>
                                <p class="ml-2">{{$user->email}}</p>
                                <p class="ml-2"><b>{{ $user->role }}</b></p>
                                <a class='btn btn-sm btn-danger mr-2' href='/user/{{$user->id}}/edit'>Edit User</a>
                                <a class='btn btn-sm btn-danger ml-2' href='/user/{{$user->id}}'>Delete User</a>
                                </li>
                                </ul> 
                        @endforeach  
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