@php
    // Alert classes //
    $alert = 'alert alert-dismissible col-sm-6 col-sm-offset-3';
    // Dismiss button //
    $btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
@endphp

@if (session('status'))
    <div class="{{ $alert }} alert-info" role="alert">
        {!! $btn !!}
        <strong>{{ session('status') }}</strong>
    </div>
@endif
@if (session('info'))
    <div class="{{ $alert }} alert-info" role="alert">
        {!! $btn !!}
        <strong>{{ session('info') }}</strong>
    </div>
@endif
@if (session('success'))
    <div class="{{ $alert }} alert-success" role="alert">
        {!! $btn !!}
        <strong>{{ session('success') }}</strong>
    </div>
@endif
@if (session('warning'))
    <div class="{{ $alert }} alert-warning" role="alert">
        {!! $btn !!}
        <strong>{{ session('warning') }}</strong>
    </div>
@endif
@if (session('error'))
    <div class="{{ $alert }} alert-danger" role="alert">
        {!! $btn !!}
        <strong>{{ session('error') }}</strong>
    </div>
@endif
