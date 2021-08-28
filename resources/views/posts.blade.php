@extends('layout')


@section('body')
    <div class="album py-5 bg-light">
        <div class="container">
            <a type="button" href="{{ route('posts') }}" class="btn btn-sm btn-outline-secondary">@lang('Home')</a>
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4">
                        <div class="card mb-4 box-shadow">
                            <div class="card-body">
                                <p>{{ $post['title'] }}</p>
                                <p class="card-text">{{ $post['body'] }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a type="button" href="{{ route('post', $post['id']) }}" class="btn btn-sm btn-outline-secondary">@lang('View')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{ $posts->render() }}
    </div>
@endsection
