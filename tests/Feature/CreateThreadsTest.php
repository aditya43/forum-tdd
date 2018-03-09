<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_new_forum_thread()
    {
        $user = factory(\App\User::class)->create();

        $this->actingAs($user);

        $thread = factory(\App\Thread::class)->make();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function unauthenticated_users_cannot_create_forum_thread()
    {
        $this->expectException(\Illuminate\Auth\AuthenticationException::class);

        $thread = factory(\App\Thread::class)->make();

        $this->post('/threads', $thread->toArray());
    }
}
