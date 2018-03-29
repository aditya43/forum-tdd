<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class UsersAvatarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store()
    {
        request()->validate(['avatar' =>  'image']);

        auth()->user()->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
            ]);

        return back();
    }
}
