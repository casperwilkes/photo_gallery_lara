@extends('base')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>Welcome to {{ config('app.name', 'Laravel') }}</h1>
            </div>
        </div>
    </div>
@endsection
