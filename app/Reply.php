<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favouritable, RecordsActivity;

    protected $appends = ['favouritesCount', 'isFavourited'];

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Global scope for eager loading relationships.
     *
     * @var array
     */
    protected $with = ['owner', 'favourites'];

    public static function boot()
    {
        parent::boot();

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {
            $reply->thread->decrement('replies_count');
        });
    }

    /**
     * A reply has an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function thread()
    {
        return $this->belongsTo(\App\Thread::class);
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function wasJustPublished()
    {
        return $this->created_at->gt(\Carbon\Carbon::now()->subMinute());
    }

    public function mentionedUsers()
    {
        preg_match_all('/\@([\w.]+)/', $this->body, $matches);

        return $matches[1];
    }
}
