<div id="reply-{{ $reply->id }}" class="card bg-light mb-3">
    <div class="card-header">
        <div class="level">
            <div class="flex">
                    <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a>
                    replied
                    {{ $reply->created_at->diffForHumans() }}
            </div>
            <div>
                <form action="/replies/{{ $reply->id }}/favourites" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavourited() ? 'disabled' : ''}}>
                        {{ $reply->favourites_count }} {{ str_plural('Favourite', $reply->favourites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="body">{{ $reply->body }}</div>
    </div>
</div>