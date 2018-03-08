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
</div>
@endsection
