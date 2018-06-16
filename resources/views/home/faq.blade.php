@extends('base')

@section('content')
    <div id="faq" class="row">
        <div class="col-md-12">
            <h1 class="text-center">Frequently Asked Questions</h1>
            <div class="col-md-10 col-md-offset-1">
                @parsedown($faq)
            </div>
        </div>
    </div>
@endsection