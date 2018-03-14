<reply :attributes="{{ $reply }}" inline-template v-cloak>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-primary btn-sm" @click="update">Update</button>
                <button class="btn btn-link" @click="editing=false">Cancel</button>
            </div>

            <div class="body" v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-sm mr-2" @click="editing=true">Edit</button>
                <form action="/replies/{{ $reply->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>