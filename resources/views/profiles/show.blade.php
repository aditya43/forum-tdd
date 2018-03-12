@extends('layouts.app')

@section('content')
<div class="container">
    <h2>{{ $profileUser->name }}</h2>
    <small>{{ $profileUser->created_at->diffForHumans() }}</small>
    <hr>
    
    @foreach ($threads as $thread)
    <div class="card mb-3">
        
        <div class="card-header">
            <div class="level">
                <span class="flex">{{ $thread->title }}</span>
                <span>{{ $thread->created_at->diffForHumans() }}</span>
            </div>            
        </div>
        
        <div class="card-body">
            <div class="body">{{ $thread->body }}</div>
        </div>
        
    </div>
    @endforeach
    {{ $threads->links() }}
</div>    
@endsection