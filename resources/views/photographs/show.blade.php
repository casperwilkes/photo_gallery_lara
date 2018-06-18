@extends('base')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center">{{ ucwords($photo->caption) }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="btn btn-group btn-group-sm">
                <a href="photographs" class="btn btn-default">
                    <span class="glyphicon glyphicon-home"></span> Back to Main
                </a>
                @auth
                    @if(Auth::user()->id === $photo->user_id)
                        <a href="photographs/{{$photo->id}}/edit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-pencil"></span> Edit Photograph
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <p id="prev_next" class="clearfix">
                @if($photo->previous())
                    <a href="photographs/{{$photo->previous()->id}}"
                       title="{{$photo->previous()->caption}}"
                       class="btn btn-primary pull-left">
                        <span class="glyphicon glyphicon-chevron-left"></span> Prev
                    </a>
                @endif
                @if($photo->next())
                    <a href="photographs/{{$photo->next()->id}}"
                       title="{{$photo->next()->caption}}"
                       class="btn btn-primary pull-right">
                        Next <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                @endif
            </p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <img src="{{asset("img/main/{$photo->filename}")}}" alt="{{$photo->caption}}"
                 class="center-block img-responsive img-thumbnail">
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-md-4 col-md-offset-2">
            <dl class="dl-horizontal">
                <dt>Photograph type:</dt>
                <dd>{{ $photo->type }}</dd>
                <dt>Photograph size:</dt>
                <dd>{{ format_bytes($photo->size) }}</dd>
            </dl>
        </div>
        <div class="col-md-4">
            <dl class="dl-horizontal">
                <dt>Uploaded by:</dt>
                <dd><a href="profile/{{ $photo->user->name }}">{{ $photo->user->name }}</a></dd>
                <dt>Uploaded on:</dt>
                <dd>{{ $photo->created_at->format(' F d, Y g:i a') }}</dd>
            </dl>
        </div>
    </div>

    <div class="row">
        <div class="top-buffer col-md-8 col-xs-10 col-xs-offset-1 col-md-offset-2">
            @guest
                <p class="text-center"><a href="login" class="btn btn-warning">Login to leave a comment</a></p>
            @endguest

            @auth
                <div class="panel panel-default">
                    <div class="panel-heading">Leave a comment</div>
                    <div class="panel-body">
                        <form class="form form-horizontal" action="comments" method="post">
                            <fieldset>
                                {{ csrf_field() }}
                                <input type="hidden" name="photo_id" value="{{ $photo->id }}">
                                <div class="form-group">
                                    <div class="col-md-12">
                                <textarea name="comment"
                                          class="form-control"
                                          placeholder="What would you like to say?"
                                          rows="4"
                                          required></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary">Submit Comment</button>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </div>

    <div class="row top-buffer">
        @if($comments->isNotEmpty())
            @foreach($comments as $comment)
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="well well-sm">
                            <div class="clearfix">
                                <div class="col-md-10">
                                    <p>
                                        <a href="profile/{{$comment->user->name}}" title="{{$comment->user->name}}">
                                            <img src="img/avatar/thumb/{{$comment->user->avatar}}"
                                                 alt="User profile pic"
                                                 class="img-circle comment_img" />
                                        </a>
                                        <span class="comment_user">
                                            <a href="profile/{{$comment->user->name}}"
                                               title="View {{$comment->user->name}}'s profile">
                                                {{ $comment->user->name }}
                                            </a>
                                            wrote:
                                        </span>
                                    </p>
                                </div>
                                @auth
                                    @if(Auth::user()->id === $comment->user_id)
                                        <div class="col-md-1">
                                            <form action="comments/{{ $comment->id }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button class="btn btn-xs btn-danger" title="Delete this comment">
                                                    <span class="glyphicon glyphicon-trash"></span> Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                                <div class="col-md-12">
                                    <div class="well well-sm">
                                        <p>{!! nl2br(e($comment->body)) !!}</p>
                                    </div>
                                    <div class="col-md-12 text-right">
                                        <small>
                                            <strong>Created:</strong> {{ $comment->created_at->format(' F d, Y g:i a') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-md-6 col-md-offset-3">
                <div class="well well-sm text-center">
                    <span>No comments yet</span>
                </div>
            </div>
        @endif
    </div>
@endsection