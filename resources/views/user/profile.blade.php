@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p>
                <a href="{{route('home')}}" class="btn btn-xs btn-default">
                    <span class="glyphicon glyphicon-home"></span> Back to Main
                </a>
                @auth
                    @if(Auth::user()->id === $user->id)
                        <a href="profile/{{ $user->id }}/edit" class="btn btn-xs btn-primary">
                            <span class="glyphicon glyphicon-user"></span> Edit Profile
                        </a>
                        <a href="{{route('logout')}}" class="btn btn-xs btn-warning">
                            <span class="glyphicon glyphicon-log-out"></span> Logout
                        </a>
                    @endif
                @endauth
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{{ $user->name }}'s profile</h1>
        </div>
    </div>

    @include('user.profile_user')

    <br>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">My Photographs</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if($photos->isNotEmpty())
                <div class="row top-buffer">
                    @foreach($photos as $photo)
                        <div class="col-md-3 text-center">
                            <a href="photographs/{{ $photo->id }}">
                                <img src="{{asset("img/main/thumb/{$photo->filename}")}}" alt="{{$photo->caption}}">
                            </a>

                            <div class="caption">
                                <p>{{ ucwords($photo->caption) }}</p>
                            </div>

                            @auth
                                @if(Auth::user()->id === $user->id)
                                    <p>
                                        <a href="photographs/{{ $photo->id }}/edit" class="btn btn-xs btn-primary">
                                            <span class="glyphicon glyphicon-pencil"></span> Edit Photograph
                                        </a>
                                    </p>
                                @endif
                            @endauth
                        </div>
                    @endforeach
                </div>

                <div id="page" class="row text-center">
                    {{ $photos->links() }}
                </div>
            @else
                <p class="lead text-center">
                    No Photographs To Display Yet.<br>
                    Upload some to get started!
                </p>
            @endif
        </div>
    </div>
@endsection
