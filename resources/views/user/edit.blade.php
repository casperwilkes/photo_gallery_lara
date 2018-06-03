@extends('base')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <p>
                <a href="{{route('home')}}" class="btn btn-xs btn-default">
                    <span class="glyphicon glyphicon-home"></span> Back to Main
                </a>
                @auth
                    @if(Auth::user()->id === $user->id)
                        <a href="profile" class="btn btn-xs btn-primary">Back to profile</a>
                    @endif
                @endauth
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{{ $user->name }}'s profile</h1>
        </div>
    </div>

    @include('user.profile_user')

    <br>
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center">Editable Fields</h2>
        </div>
    </div>

    <div class="row" id="profile_edit_panel">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="BioHeading">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#BioForm"
                           aria-expanded="true" aria-controls="BioForm">
                            <h4 class="panel-title">Bio</h4>
                        </a>
                    </div>
                    <div id="BioForm" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="BioHeading">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form method="post" action="profile/{{ $user->id }}" class="form form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="form" value="bio" />
                                    <div class="form-group">
                                        <textarea name="bio" id="bio" rows="8" placeholder="Bio"
                                                  class="form-control">{{ old('bio', $user->profile_fields['bio']) }}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-xs btn-primary">Submit Bio</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="AvatarHeading">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#AvatarForm" aria-expanded="false" aria-controls="AvatarForm">
                            <h4 class="panel-title">Avatar</h4>
                        </a>
                    </div>
                    <div id="AvatarForm" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="AvatarHeading">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form method="post" action="profile/{{ $user->id }}" class="form form-horizontal"
                                      enctype="multipart/form-data">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="form" value="avatar" />
                                    <div class="form-group">
                                        <input type="file" name="avatar" id="image" value="{{ old('image') }}"
                                               class="form-control" />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-xs btn-primary">Submit Avatar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="EmailHeading">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#EmailForm" aria-expanded="false" aria-controls="EmailForm">
                            <h4 class="panel-title">Email</h4>
                        </a>
                    </div>
                    <div id="EmailForm" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="EmailHeading">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form method="post" action="profile/{{ $user->id }}" class="form form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="form" value="email" />
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" placeholder="New Email Address"
                                               value="{{ old('email', $user->email) }}"
                                               class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-xs btn-primary">Submit Email</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="PasswordHeading">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion"
                           href="#PasswordForm" aria-expanded="false" aria-controls="PasswordForm">
                            <h4 class="panel-title">Password</h4>
                        </a>
                    </div>
                    <div id="PasswordForm" class="panel-collapse collapse" role="tabpanel"
                         aria-labelledby="PasswordHeading">
                        <div class="panel-body">
                            <div class="col-md-12">
                                <form method="post" action="profile/{{ $user->id }}" class="form form-horizontal">
                                    {{ csrf_field() }}
                                    {{ method_field('PUT') }}
                                    <input type="hidden" name="form" value="password" />
                                    <div class="form-group">
                                        <div class="col-md-3"></div>
                                        <input type="password" name="original" id="original"
                                               placeholder="Original Password"
                                               value="" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3"></div>
                                        <input type="password" name="password" id="password" placeholder="New Password"
                                               value="" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3"></div>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                               placeholder="New Password Confirmation"
                                               value="" class="form-control" required />
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-xs btn-primary">Submit Email</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
