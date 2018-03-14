<reply :attributes="{{ $reply }}" inline-template v-cloak>
    <div id="reply-{{ $reply->id }}" class="card bg-light mb-3">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                        <a href="{{ route('profile', $reply->owner) }}">{{ $reply->owner->name }}</a>
                        replied
                        {{ $reply->created_at->diffForHumans() }}
                </div>
                @auth
                    <div>
                        <favourite :reply="{{ $reply }}"></favourite>
                    </div>
                @endauth
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
                <button class="btn btn-danger btn-sm" @click="destroy()">Delete</button>
            </div>
        @endcan
    </div>
</reply>