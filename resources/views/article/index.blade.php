@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($articles as $article)
                    <div class="media">
                        <div class="media-left">
                            <a href="">
                                <img width="36" src="{{ $article->user->avatar }}" alt="{{ $article->user->name }}">
                                <span>{{ $article->user->name }}</span>
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="{{ route('article.show',$article->id) }}">
                                    {{ $article->title }}
                                </a>
                            </h4>

                        </div>
                        <div class="media-body">
                            <h5 class="media-heading">
                                {{ $article->updated_at }}
                            </h5>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection