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
                    <div id="content" class="panel-body content">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        let content = document.getElementById('content');
        let str = `{!! $html !!}`;
        katex.render(str, content, {
            throwOnError: false
        });

    </script>
@endsection