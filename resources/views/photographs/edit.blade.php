@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Edit Photograph</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10">
            <p>
                <a href="photographs" class="btn btn-xs btn-default">Back to Main</a>
                <a href="photographs/{{ $photo->id }}" class="btn btn-xs btn-primary">Back to Photograph</a>
            </p>
        </div>
        <div class="col-md-2">
            @auth
                @if(Auth::user()->id === $photo->user_id)
                    <form class="form-inline" action="photographs/{{$photo->id}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-xs btn-danger">Delete Photograph</button>
                    </form>
                @endif
            @endauth
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $photo->caption }}</div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" class="form-horizontal" action="photographs/{{$photo->id}}"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <div class="col-md-10 col-md-offset-1">
                                <img src="{{asset("img/main/{$photo->filename}")}}" alt="{{$photo->caption}}"
                                     class="center-block img-responsive">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="caption" class="col-md-1 control-label">Caption</label>
                            <div class="col-md-10">
                                <input type="text" name="caption" id="caption" value="{{ $photo->caption }}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <button type="submit" id="edit" class="btn btn-primary">Edit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection