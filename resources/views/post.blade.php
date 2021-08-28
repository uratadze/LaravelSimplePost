@extends('layout')


@section('body')
    <div class="album py-5 bg-light">
        <a type="button" href="{{ route('posts') }}" class="btn btn-sm btn-outline-secondary">@lang('Back')</a>
        <div class="container">
            <div class="row">
                <div class="card mb-4 box-shadow">
                    <div class="card-body">
                        <p>Title: {{ $post['title'] }}</p>
                        <p class="card-text">Body: {{ $post['body'] }}</p>
                        <p class="card-text">User ID: {{ $post['userId'] }}</p>
                    </div>
                </div>
            </div>
            <p>Comments:</p>
            @foreach($comments as $comment)
                <div class="col-sm-5">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>{{ $comment['name'] }}</strong>
                            <span class="text-muted">{{ $comment['email'] }}</span>
                            <p>{{ $comment['body'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        {{ $comments->render() }}
    </div>




@endsection
