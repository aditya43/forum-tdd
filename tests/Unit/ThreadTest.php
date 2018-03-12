<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class ThreadTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    public function setUp()
    {
        parent::setUp();

        $this->thread = create(\App\Thread::class);
    }

    /** @test */
    public function a_thread_has_a_creator()
    {
        $this->assertInstanceOf(\App\User::class, $this->thread->creator);
    }

    /** @test */
    public function a_reply_can_be_added_to_thread()
    {
        $this->thread->addReply([
            'body'    => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_has_replies()
    {
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $this->thread->replies);
    }

    /** @test */
    public function a_thread_can_belong_to_a_channel()
    {
        $this->assertInstanceOf(\App\Channel::class, $this->thread->channel);
    }

    /** @test */
    public function a_thread_can_make_a_string_path()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }
}
