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
    public function unauthenticated_users_cannot_add_replies()
    {
        // $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        $this->withExceptionHandling();

        $this->post('/threads/some-channel/1/replies', []) // Submit reply via POST request.
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_participate_in_forum_threads()
    {
        // $this->withExceptionHandling();

        $this->signIn();

        $thread = create(\App\Thread::class); // Create a thread.
        $reply  = make(\App\Reply::class);    // Create a reply.

        $this->post($thread->path() . '/replies', $reply->toArray()); // Submit reply via POST request.

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $thread->fresh()->replies_count);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(\App\Thread::class);
        $reply  = make(\App\Reply::class, ['body' => null]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
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
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function unauthenticated_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create(\App\Reply::class);

        $this->patch("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_user_can_update_a_reply()
    {
        $this->signIn();

        $reply = create(\App\Reply::class, ['user_id' => auth()->id()]);

        $this->patch("replies/{$reply->id}", ['body' => 'Modified reply body']);

        $this->assertDatabaseHas('replies', [
            'id'   => $reply->id,
            'body' => 'Modified reply body'
        ]);
    }

    /** @test */
    public function replies_containing_spam_may_not_be_created()
    {
        config(['aditesting' => 'yes']);

        $this->signIn();

        $thread = create(\App\Thread::class);
        $reply  = make(\App\Reply::class, [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }

    /** @test */
    public function user_can_post_only_one_reply_per_minute()
    {
        $this->signIn();

        $thread = create(\App\Thread::class);
        $reply  = make(\App\Reply::class, [
            'body' => 'My simple reply'
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }
}
