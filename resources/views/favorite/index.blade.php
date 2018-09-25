@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Favorite Sites
                <a href="{{ route('favorite.create') }}" class="btn btn-primary btnBlack pull-right">
                    <span class="fa fa-paper-plane"></span>
                    Add New Favorites
                </a>
            </h1>
        </div>
    </div>

    <div class="container">
        @if(count($topics)>0)
            <h4>Tags:
                @foreach($topics as $topic)
                    <a href="{{ url('favorite/topic/'.$topic->id) }}"><span class="label @if($topic->id == @$curTagId) label-success @else label-default @endif" onclick="select(this)">{{ $topic->name  }}</span></a>
                @endforeach
            </h4>
            <br />
        @endif
        @foreach($favorites as $favorite)
            <h2>{{ $favorite->title }}</h2>
            <favorite>
                @if($favorite->tags)
                    @foreach($favorite->tags as $topic)
                        <span class="label @if($topic->id == @$curTagId) label-info @else label-default @endif" onclick="select(this)">{{ $topic->name  }}</span>
                    @endforeach
                @endif
                <span class="pull-right">{{ $favorite->created_at->diffForHumans() }}</span>
                <div class="body">
                    <a href="{{ $favorite->url }}" target="_blank">{{ $favorite->url }}</a>
                </div>
            </favorite>
        @endforeach
    </div>
@endsection