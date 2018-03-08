<div class="card bg-light mb-3">
    <div class="card-header">
        <a href="#">{{ $reply->owner->name }}</a>
        replied
        {{ $reply->created_at->diffForHumans() }}
    </div>

    <div class="card-body">
        <div class="body">{{ $reply->body }}</div>
    </div>
</div>