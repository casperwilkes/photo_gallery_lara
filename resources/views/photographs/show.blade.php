@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{{ ucwords($photo->caption) }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p>
                <a href="photographs" class="btn btn-xs btn-default">Back to main</a>
                @auth
                    @if(Auth::user()->id === $photo->user_id)
                        <a href="photographs/{{$photo->id}}/edit" class="btn btn-xs btn-primary">Edit Photograph</a>
                    @endif
                @endauth
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <img src="{{asset("img/main/{$photo->filename}")}}" alt="{{$photo->caption}}"
                 class="center-block img-responsive">
        </div>
        <div class="col-md-10 col-md-offset-1">
            <p>Image meta</p>
        </div>
    </div>

    <div class="row">
        <div class="top-buffer col-md-8 col-xs-10 col-xs-offset-1 col-md-offset-2">
            @guest
                <p class="text-center"><a href="login" class="btn btn-warning">Login to leave a comment</a></p>
            @endguest

            @auth
                {{--{% if show_form == true %}--}}
                show form

                {{--{{ include('comments/_formComment.twig') }}--}}
                {{--{% else %}--}}
                {{----}}
                {{--{% endif %}--}}
            @endauth


        </div>
    </div>
@endsection