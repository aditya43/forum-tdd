<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function unauthenticated_users_cannot_create_forum_thread()
    {
        // $this->expectException(\Illuminate\Auth\AuthenticationException::class);
        $this->withExceptionHandling();

        $this->get('threads/create')
            ->assertRedirect('/login');

        $this->post('/threads', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function authenticated_user_can_create_new_forum_thread()
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = create(\App\Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_valid_channel_id()
    {
        $this->withExceptionHandling();

        factory(\App\Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->withExceptionHandling();

        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->withExceptionHandling();

        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling();

        $this->signIn();

        $thread = make(\App\Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(\App\Thread::class);

        $this->delete($thread->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->withExceptionHandling();

        $this->signIn();
        $thread = create(\App\Thread::class, ['user_id' => auth()->id()]);
        $reply  = create(\App\Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
