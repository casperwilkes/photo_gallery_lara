@extends('base')

@section('content')
    @auth
        @if(Auth::user()->id === $photo->user_id)
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1>Edit Photograph</h1>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <form class="form-inline" action="{{route('photographs.show', ['photograph'=> $photo->id])}}"
                          method="post">
                        <div class="btn btn-group btn-group-sm">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <a href="photographs" class="btn btn-default">
                                <span class="glyphicon glyphicon-home"></span> Back to Main
                            </a>
                            <a href="photographs/{{ $photo->id }}" class="btn btn-primary">
                                <span class="glyphicon glyphicon-arrow-left"></span> Back to Photograph
                            </a>
                            <button type="submit" class="btn btn-danger">
                                <span class="glyphicon glyphicon-trash"></span> Delete Photograph
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default">
                        <div class="panel-heading">{{ $photo->caption }}</div>
                        <div class="panel-body">
                            <form enctype="multipart/form-data" class="form-horizontal"
                                  action="photographs/{{$photo->id}}"
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
                                        <button type="submit" id="edit" class="btn btn-primary">Submit Edit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endauth
@endsection