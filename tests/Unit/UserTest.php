<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user  = create(\App\User::class);
        $reply =create(\App\Reply::class, ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = create(\App\User::class);

        $this->assertEquals('/storage/avatars/default.png', $user->avatar());

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals('/storage/avatars/me.jpg', $user->avatar());
    }
}
