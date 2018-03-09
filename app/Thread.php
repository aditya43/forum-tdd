<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['user_id', 'title', 'body'];

    public function path()
    {
        return '/threads/' . $this->id;
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }

    /**
     * Thread has many Replies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(\App\Reply::class);
    }

    /**
     * Thread belongs to Owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
