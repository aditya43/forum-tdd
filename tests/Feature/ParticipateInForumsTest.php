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

    /** @test */
    public function unauthorized_user_cannot_delete_a_reply()
    {
        $this->withExceptionHandling();

        $reply = create(\App\Reply::class);

        $this->delete("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_delete_a_reply()
    {
        $this->signIn();

        $reply = create(\App\Reply::class, ['user_id' => auth()->id()]);

        $this->delete("replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
