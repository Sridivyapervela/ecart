@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card">
                    <div style="font-size: 150%;" class="card-header align-center">{{ $user->firstname $user->lastname}}
                    <br> {{$user->email}}
                        <b>{{ $user->role }}</b>
                        @if($user->role=='admin')
                        <a class='btn btn-sm ml-2' href='/edit/{{$user->id}}'>Edit User</a>
                        <a class='btn btn-sm ml-2' href='/user/destroy/{{$user->id}}'>Delete User</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="row">
                                <ul class="list-group">
                                <h5>My Orders</h5>
                                    <a href="/user/show/{{$user->id}}">All Orders</a>
                                </ul>
                                
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