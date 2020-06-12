@extends('layout')

@section('content')
<div class="container">
    <div class="row p-3"></div>
    <div class="row">
        <div class="col-5">
            <div class="row">
                <div class="col-12">
                    <div id="logo">
                        <h1><span class="text-primary">#</span>bugbountytips</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-4"></div>
    <div class="row">
        <div class="card" style="width: 18rem;">
            <div class="card-header">
                Add a tweet
            </div>
            <div class="card-body">
                <p>
                    <input type="text" class="col" placeholder="id" value="">
                </p>
                <p>
                    <input type="text" class="col" placeholder="keywords" value="">
                </p>
                <p>
                <button type="submit" class="btn btn-primary">Add</button>
                </p>
            </div>
        </div>
        @foreach ($tweets as $tweet)
        <div class="card @if($tweet->ignore) tweet-ignore @endif">
            <div class="card-header @if($tweet->ignore) bg-danger @endif">
                <a href="https://twitter.com/xxxxx/statuses/{{ $tweet->twitter_id }}" target="_blank" class="card-linkd @if($tweet->ignore) tweet-ignore @endif">{{ $tweet->twitter_id }}</a>
            </div>
            <div class="card-body">
                <p class="card-text">
                    {{ $tweet->message }}
                </p>

            </div>
            <div class="card-footer2">
                <div class="row">
                    <div class="col-6 text-center">
                        @if($tweet->ignore)
                        <a href="#" class="card-link">Unignore</a>
                        @else
                        <a href="#" class="card-link">Ignore</a>
                        @endif
                    </div>
                    <div class="col-6 text-center">
                        <a href="{{ route('tweets.destroy',$tweet->id) }}" class="card-link">Delete</a>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <input type="text" class="col" value="{{ $tweet->keywords }} ">
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('style')
    .card:hover {
        border-color: #AAA;
    }
    div.tweet-ignore {
        border-color: #F88;
    }
    div.tweet-ignore:hover {
        border-color: #F00;
    }
    a.tweet-ignore {
        color: #FFF;
    }
    .card-footer2 {
        padding: 0.75rem 1.25rem;
        background-color: #FFF;
        border-top: 1px solid rgba(0, 0, 0, 0.125);
    }
    .card-footer2 div.col-6:first-child {
        border-right: 1px solid rgba(0, 0, 0, 0.125);
    }
    .card {
        margin-bottom: 15px;
        margin-left: 15px;
        width: 15rem;
    }
    input.col {
        padding: 0px 0px 0px 2px;
    }
@endsection


