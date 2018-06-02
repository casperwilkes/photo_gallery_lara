@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $user->name }}'s profile</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {{--            <p>{{ html_anchor('/', '<span class="glyphicon glyphicon-home"></span> Back to Main', {'class': 'btn btn-primary'}) }}</p>--}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="col-sm-3">
                @empty($user->profile_fields['img'])
                    <img src="img/avatar/{{ $avatar }}" class="center-block img-responsive" alt="Dashboard Image" />
                @endempty
                {{--                {{ asset_img('profile/thumb/'~image, {'class': 'center-block img-responsive'}) }}--}}
            </div>
            {{--{% if auth.get_screen_name() == username%}--}}

            {{--<div class="col-md-2 col-sm-3 col-xs-3">--}}
            {{--<div class="btn-group">--}}
            {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
            {{--<span class="glyphicon glyphicon-list-alt"></span>  Options <span class="caret"></span>--}}
            {{--</button>--}}
            {{--<ul class="dropdown-menu">--}}
            {{--<li>{{ html_anchor('profile/edit', '<span class="glyphicon glyphicon-pencil"></span> Edit Profile', {'class':'btn btn-info'}) }}</li>--}}
            {{--<li>{{ html_anchor('logout', '<span class="glyphicon glyphicon-log-out"></span> Logout', {'class': 'btn btn-danger'}) }}</li>--}}
            {{--</ul>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--{% endif %}--}}

            <div class="col-sm-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <div class="panel-title">User Bio</div>
                    </div>
                    <div class="panel-body">{{ $bio }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
