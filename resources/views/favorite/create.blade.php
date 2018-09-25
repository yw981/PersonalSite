@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main">
                <h1>添加收藏</h1>
                <form action="{{ route('favorite.store') }}" method="post">
                    @csrf

                    <div class="form-group">
                        {!! Form::label('title','标题:') !!}
                        <label>{!! Form::checkbox('autoTitle', '1', true) !!}自动获取网页标题</label>
                        {!! Form::text('title',null,['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <select name="topics[]" class="js-example-placeholder-multiple js-data-example-ajax form-control" multiple="multiple">
                        </select>
                    </div>

                    <div class="form-group">
                        {!! Form::label('url','URL:') !!}
                        {!! Form::url('url',null,['class'=>'form-control']) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::submit('确定',['class'=>'btn btn-success form-control']) !!}
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection

@section('js')
    <script>
        $(document).ready(function() {
            function formatTopic (topic) {
                return "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'>" +
                topic.name ? topic.name : "Laravel"   +
                    "</div></div></div>";
            }
            function formatTopicSelection (topic) {
                return topic.name || topic.text;
            }
            $(".js-example-placeholder-multiple").select2({
                tags: true,
                placeholder: '选择相关话题',
                minimumInputLength: 1,
                ajax: {
                    url: '/api/topics',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function (data, params) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                templateResult: formatTopic,
                templateSelection: formatTopicSelection,
                escapeMarkup: function (markup) { return markup; }
            });
        });
    </script>
@endsection