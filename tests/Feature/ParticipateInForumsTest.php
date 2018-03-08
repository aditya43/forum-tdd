<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_participate_in_forum_threads()
    {
        $user = factory(\App\User::class)->create(); // Create a user.

        $this->be($user); // Log the user in.

        $thread = factory(\App\Thread::class)->create(); // Create a thread.

        $reply = factory(\App\Reply::class)->make(); // Create a reply.

        $this->post($thread->path() . '/replies', $reply->toArray()); // Submit reply via POST request.

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_users_can_not_add_replies()
    {
        $this->expectException(\Illuminate\Auth\AuthenticationException::class);

        $this->post('/threads/1/replies', []); // Submit reply via POST request.
    }
}
