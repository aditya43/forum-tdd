<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ThreadsViewTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create(\App\Thread::class);
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_specific_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_replies_associated_to_thread()
    {
        $reply = create(\App\Reply::class, ['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_by_channel()
    {
        $channel            = create(\App\Channel::class);
        $threadInChannel    = create(\App\Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(\App\Thread::class);

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontsee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $user = create(\App\User::class, ['name' => 'AdityaHajare']);
        $this->signIn($user);

        $threadByAditya    = create(\App\Thread::class, ['user_id' => auth()->id()]);
        $threadNotByAditya = create(\App\Thread::class);

        $this->get('/threads?by=AdityaHajare')
            ->assertSee($threadByAditya->title)
            ->assertDontSee($threadNotByAditya->title);
    }
}
