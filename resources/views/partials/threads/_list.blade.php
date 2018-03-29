@forelse ($threads as $thread)
<div class="card mb-4">
    <div class="card-header">
        <div class="level">
            <div class="flex">
                <h4>
                    <a href="{{ $thread->path() }}">
                        @if (auth()->check() && $thread->hasUpdatesFor())
                        <strong>
                            {{ $thread->title }}
                        </strong>
                        @else
                        {{ $thread->title }}
                        @endif
                    </a>
                </h4>
                <h6>
                    Posted By: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                </h6>
            </div>
            <strong>
                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }}
                    {{ str_plural('reply', $thread->replies_count) }}
                </a>
            </strong>
        </div>
    </div>
    <div class="card-body">
        <div class="body">
            {!! $thread->body !!}
        </div>
    </div>
</div>
@empty
<p>There are 0 threads associated with this channel.</p>
@endforelse