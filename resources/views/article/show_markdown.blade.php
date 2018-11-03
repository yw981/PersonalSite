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
                        {!! $html !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        {{--const rawString = `{!! $html !!}`;--}}
        {{--const regex = new RegExp('\\$\\$(.+?)\\$\\$', 'g');--}}
        {{--const result = rawString.replace(regex, function (match,match1) {--}}
            {{--console.log('match '+match+' 1 '+match1);--}}
            {{--const html = katex.renderToString(match1, {--}}
                {{--throwOnError: false--}}
            {{--});--}}
            {{--return html;--}}
        {{--});--}}
        {{--document.getElementById('content').innerHTML = result;--}}

    </script>
@endsection