@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">

                <div class="card-header">
                    <a href="#">{{ $thread->creator->name }}</a> posted:
                    {{ $thread->title }}
                </div>

                <div class="card-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>

            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($thread->replies as $reply)
            @include('partials.threads._reply')
            @endforeach
        </div>
    </div>

    @if (auth()->check())
        <div class="row justify-content-center">
            <div class="col-md-8">
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
            </div>
        </div>
    @else
        <p class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
    @endif
</div>
@endsection