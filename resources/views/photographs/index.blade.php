@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Photographs</h1>
        </div>
    </div>

    @auth
        <div class="row">
            <a href="photographs/create" class="btn btn-sm btn-primary">Upload a new photograph</a>
        </div>
    @endauth

    <div class="row">
        @if($photos->isNotEmpty())
            <div class="row top-buffer">
                @foreach($photos as $photo)
                    <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                        <a href="photographs/{{ $photo->id }}">
                            <img src="{{asset("img/main/thumb/{$photo->filename}")}}" alt="{{$photo->caption}}">
                        </a>

                        <div class="caption">
                            <p>{{ str_limit(ucwords($photo->caption),30) }}</p>
                        </div>
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
@endsection