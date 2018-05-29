@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Upload a New Photograph</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <a href="photographs" class="btn btn-xs btn-primary">Back to main</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Photograph</div>
                <div class="panel-body">
                    <form enctype="multipart/form-data" class="form-horizontal" action="photographs"
                          method="post">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="image" class="col-md-1 control-label">Image</label>
                            <div class="col-md-8">
                                <input type="file" name="image" id="image" value="{{old('image')}}"
                                       class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="caption" class="col-md-1 control-label">Caption</label>
                            <div class="col-md-10">
                                <input type="text" name="caption" id="caption" value="{{old('caption')}}"
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-1">
                                <button type="submit" class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection