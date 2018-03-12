@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h2>{{ $profileUser->name }}
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
            </h2>            
            <hr>
            @foreach ($threads as $thread)
            <div class="card mb-4">
                <div class="card-header">
                    <div class="level">
                        <span class="flex">
                            <a href="{{ $thread->path() }}">                                
                                {{ $thread->title }}                                
                            </a>
                        </span>
                        <span>{{ $thread->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="body">{{ $thread->body }}</div>
                </div>
            </div>
            @endforeach {{ $threads->links() }}
        </div>
    </div>    
</div>    
@endsection