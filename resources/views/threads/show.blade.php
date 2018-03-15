@extends('layouts.app')

@section('content')
    <thread-view  :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card mb-3">

                        <div class="card-header">
                            <div class="level">
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
                            <div class="body">{{ $thread->body }}</div>
                        </div>

                    </div>

                    <replies :data="{{ $thread->replies }}" @added="repliesCount++" @removed="repliesCount--"></replies>

                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="body">
                                This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>, and currently has <span v-text="repliesCount"></span>
                                {{ str_plural('reply', $thread->replies_count) }}.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </thread-view>
@endsection