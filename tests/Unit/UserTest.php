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
}
