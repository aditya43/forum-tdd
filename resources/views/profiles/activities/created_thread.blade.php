@component('profiles.activities.activity') 
    @slot('heading') 
        <span class="flex">
            {{ $profileUser->name }} published : 
            <a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a> 
        </span>
        <span>
            {{ $activity->subject->created_at->diffForHumans() }}
        </span>    
    @endslot 

    @slot('body') 
        {{ $activity->subject->body }} 
    @endslot 
@endcomponent
