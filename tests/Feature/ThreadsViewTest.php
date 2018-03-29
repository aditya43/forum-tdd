<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class ThreadsViewTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    protected $thread;

    public function setUp()
    {
        $this->withExceptionHandling();

        parent::setUp();

        $this->thread = create(\App\Thread::class);
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_specific_thread()
    {
        $this->withExceptionHandling();

        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_channel()
    {
        $this->withExceptionHandling();

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
        $this->withExceptionHandling();

        $user = create(\App\User::class, ['name' => 'AdityaHajare']);
        $this->signIn($user);

        $threadByAditya    = create(\App\Thread::class, ['user_id' => auth()->id()]);
        $threadNotByAditya = create(\App\Thread::class);

        $this->get('/threads?by=AdityaHajare')
            ->assertSee($threadByAditya->title)
            ->assertDontSee($threadNotByAditya->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popularity()
    {
        $this->withExceptionHandling();

        $threadWithTwoReplies = create(\App\Thread::class);
        create(\App\Reply::class, ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create(\App\Thread::class);
        create(\App\Reply::class, ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson('/threads?popular=1')->json();
        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test */
    public function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create(\App\Thread::class);
        create(\App\Reply::class, ['thread_id' => $thread->id], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertEquals(2, $response['total']);
    }

    /** @test */
    public function a_user_can_filter_unanswered_threads()
    {
        $thread = create(\App\Thread::class);
        create(\App\Reply::class, ['thread_id' => $thread->id]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response['data']);
    }
}
