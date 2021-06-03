@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header align-center">
                    Hello Admin
                    @auth
                        @if(auth()->user()->role=='admin')
                        <a class='btn btn-sm btn-success ml-2' href='/user/create'>Create User</a>
                        @endif
                    @endauth
                    </div>
                    <div class="card-body">
                        <div class="row">
                         @foreach($users as $user)
                                <ul class="list-group col-md-11">
                                <li class="list-group-item">
                                <a class='ml-2' href='/user/{{$user->id}}'>{{ $user->first_name}} {{ $user->last_name}}</p></a>
                                <p class="ml-2">{{$user->email}}</p>
                                <p class="ml-2"><b>{{ $user->role }}</b></p>
                                <a class='btn btn-sm btn-danger ml-2' href='/user/delete/{{$user->id}}'>Delete User</a>
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