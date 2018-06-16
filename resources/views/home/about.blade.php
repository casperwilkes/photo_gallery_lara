@extends('base')

@section('content')
    <div id="about" class="row">
        <div class="col-md-12">
            <h1 class="text-center">About</h1>
            <div class="col-md-10 col-md-offset-1">
                @parsedown($about)
            </div>
        </div>
    </div>
@endsection