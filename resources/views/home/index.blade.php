@extends('base')

@section('content')
    <div class="col-md-12">
        <div class="jumbotron text-center">
            <h1>Welcome to {{ config('app.name', 'Laravel') }}</h1>
            <p>The place to upload your photographs and have other like minded, well respected, photographers leave
               their honest feedback.
            </p>
            <p>
                <a class="btn btn-primary pull-right" href="about" role="button">Learn more</a>
            </p>
        </div>
    </div>
@endsection
