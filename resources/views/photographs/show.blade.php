@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p><a href="photographs" class="btn btn-xs btn-primary">Back to main</a></p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{{ $photo->caption }}</h1>
        </div>
    </div>



    <div class="row">
        <div class="col-md-12">
            <img src="{{asset("img/main/{$photo->filename}")}}" alt="{{$photo->caption}}"
                 class="center-block img-responsive">
        </div>
    </div>

    <div class="row">
        <div class="top-buffer col-md-8 col-xs-10 col-xs-offset-1 col-md-offset-2">

            {{--{% if show_form == true %}--}}
                show form

            {{--{{ include('comments/_formComment.twig') }}--}}
            {{--{% else %}--}}
            {{--<p>{{ html_anchor('login', 'Login to leave a comment', {'class':'btn btn-warning'}) }}</p>--}}
            {{--{% endif %}--}}
        </div>
    </div>
@endsection