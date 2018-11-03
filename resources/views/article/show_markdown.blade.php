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
        const rawString = `{!! $html !!}`;
        let regex = new RegExp('\\$\\$([\\s\\S]+?)\\$\\$|\\$([\\s\\S]+?)\\$','g');
        let result = rawString.replace(regex, function (match,match1,match2) {
            let match_string;
            if(match1){
                console.log('match '+match+' 1 '+match1);
                match_string = match1;
            }
            if(match2){
                console.log('match '+match+' 2 '+match2);
                match_string = match2;
            }
            const html = katex.renderToString(match_string, {
                throwOnError: false
            });
            return html;
        });
        document.getElementById('content').innerHTML = result;

    </script>
@endsection