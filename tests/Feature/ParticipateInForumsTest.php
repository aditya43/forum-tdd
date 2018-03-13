<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class ParticipateInForumsTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function unauthenticated_users_can_not_add_replies()
    {
        // $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        $this->withExceptionHandling();

        $this->post('/threads/some-channel/1/replies', []) // Submit reply via POST request.
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_participate_in_forum_threads()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(\App\Thread::class); // Create a thread.
        $reply  = make(\App\Reply::class);    // Create a reply.

        $this->post($thread->path() . '/replies', $reply->toArray()); // Submit reply via POST request.

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(\App\Thread::class);
        $reply  = make(\App\Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
