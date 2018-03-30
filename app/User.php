<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads()
    {
        return $this->hasMany(\App\Thread::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(\App\Activity::class)->latest();
    }

    public function lastReply()
    {
        return $this->hasOne(\App\Reply::class)->latest();
    }

    public function avatar()
    {
        // return !($this->avatar_path) ? 'avatars/default.jpg' : $this->avatar_path;
        $avatar = $this->avatar_path ?: 'avatars/default.png';

        return '/storage/' . $avatar;
    }
}
