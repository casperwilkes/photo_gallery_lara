@php
    // Alert classes //
    $alert = 'alert alert-dismissible col-sm-6 col-sm-offset-3';
    // Dismiss button //
    $btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
@endphp

@if (Session::exists('status'))
    <div class="{{ $alert }} alert-info" role="alert">
        {!! $btn !!}
        <strong>{{ Session::pull('status') }}</strong>
    </div>
@endif

@if (Session::exists('info'))
    <div class="{{ $alert }} alert-info" role="alert">
        {!! $btn !!}
        <strong>{{ Session::pull('info') }}</strong>
    </div>
@endif

@if (Session::exists('success'))
    <div class="{{ $alert }} alert-success" role="alert">
        {!! $btn !!}
        <strong>{{ Session::pull('success') }}</strong>
    </div>
@endif

@if (Session::exists('warning'))
    <div class="{{ $alert }} alert-warning" role="alert">
        {!! $btn !!}
        <strong>{{ Session::pull('warning') }}</strong>
    </div>
@endif

@if (Session::exists('error'))
    <div class="{{ $alert }} alert-danger" role="alert">
        {!! $btn !!}
        <strong>{{ Session::pull('error') }}</strong>
    </div>
@endif

@if ($errors->any())
    <div class="{{ $alert }} alert-danger" role="alert">
        {!! $btn !!}
        <ul>
            @foreach ($errors->all() as $error)
                <li><strong>{{ $error }}</strong></li>
            @endforeach
        </ul>
    </div>
@endif
