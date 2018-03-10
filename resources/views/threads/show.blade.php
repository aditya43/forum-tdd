@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">

                <div class="card-header">
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
            @foreach ($replies as $reply)
                @include('partials.threads._reply')
            @endforeach

            {{ $replies->links() }}

            @if (auth()->check())
            <form action="{{ $thread->path() }}/replies" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" id="body" class="form-control" {{ $errors->has('body') ? 'is-invalid' : ''}} placeholder="Have something to say?" rows="5">{{ old('body') }}</textarea>
                    <div class="invalid-feedback">{{ $errors->first('body') }}</div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Post Reply</button>
                </div>
            </form>
            @else
                <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
            @endif
        </div>

        <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-body">
                    <div class="body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a>, and currently has
                        {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection