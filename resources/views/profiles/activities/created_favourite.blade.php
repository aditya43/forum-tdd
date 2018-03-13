@component('profiles.activities.activity')
    @slot('heading')
        <span class="flex">
            <a href="{{ $activity->subject->favourited->path() }}">{{ $profileUser->name }} favourited a reply.</a>
        </span>
        <span>
            {{ $activity->subject->favourited->favourites->first()->created_at->diffForHumans() }}
        </span>
    @endslot

    @slot('body')
        {{ $activity->subject->favourited->body }}
    @endslot
@endcomponent
 