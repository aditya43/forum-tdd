<div class="card bg-light mb-3">
    <div class="card-header">
        <div class="level">
            <h5 class="flex">
                <a href="#">{{ $reply->owner->name }}</a>
                replied
                {{ $reply->created_at->diffForHumans() }}
            </h5>
            <div>
                <form action="/replies/{{ $reply->id }}/favourites" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavourited() ? 'disabled' : ''}}>
                        {{ $reply->favourites()->count() }} {{ str_plural('Favourite', $reply->favourites()->count()) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="body">{{ $reply->body }}</div>
    </div>
</div>