<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_reply_that_is_not_posted_by_a_current_user()
    {
        $this->signIn();

        $thread = create(\App\Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'Some reply here..'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(\App\User::class)->id,
            'body'    => 'Some reply here..'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();

        $thread = create(\App\Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(\App\User::class)->id,
            'body'    => 'Some reply here..'
        ]);

        $user = auth()->user();

        $response = $this->getJson("/profiles/{$user->name}/notifications/")->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        $this->signIn();

        $thread = create(\App\Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(\App\User::class)->id,
            'body'    => 'Some reply here..'
        ]);

        $user = auth()->user();

        $unreadNotifications = $user->fresh()->unreadNotifications;

        $this->assertCount(1, $unreadNotifications);

        $this->delete("/profiles/{$user->name}/notifications/{$unreadNotifications->first()->id}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
