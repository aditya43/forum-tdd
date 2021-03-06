@extends('layouts.app')

@section('header')
<link href="{{ asset('/css/vendor/jquery.atwho.css') }}" rel="stylesheet">
@endsection

@section('content')
<thread-view  :initial-replies-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">

                    <div class="card-header">
                        <div class="level">
                            <img src="{{ $thread->creator->avatar() }}" alt="{{ $thread->creator->name }}" width="50" class="mr-3">
                            <span class="flex">{{ $thread->title }}</span>
                            @can('update', $thread)
                            <form action="{{ $thread->path() }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-link">Delete</button>
                            </form>
                            @endcan
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="body">{!! $thread->body !!}</div>
                    </div>

                </div>

                <replies @added="repliesCount++" @removed="repliesCount--"></replies>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="body">
                            This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>, and currently has <span v-text="repliesCount"></span>
                            {{ str_plural('reply', $thread->replies_count) }}.
                        </div>
                        @auth
                        <div class="mt-3">
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
    @endsection