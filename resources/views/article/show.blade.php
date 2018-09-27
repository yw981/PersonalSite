@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ $article->title }}
                        @if(Auth::user()->id == $article->user_id)
                            <a class="" href="{{ route('article.edit',$article->id) }}">编辑</a>
                        @endif
                    </div>
                    <div>
                        @foreach($article->topics as $topic)
                            {{--TODO 处理链接--}}
                            <a class="topic" href="/topic/{{ $topic->id }}">{{ $topic->name }}</a>
                        @endforeach
                    </div>
                    <div class="panel-body content">
                        {!! $article->body !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection