@extends('base')

@section('content')
    <div id="privacy" class="row">
        <div class="col-md-12">
            <h1 class="text-center">Privacy Policy</h1>
            <div class="col-md-10 col-md-offset-1">
                <p><strong>Last Revision: April 1, 2018 </strong></p>
                @parsedown($policy)
            </div>
        </div>
    </div>
@endsection