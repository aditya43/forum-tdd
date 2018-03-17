<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    public function setUp()
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_reply_that_is_not_posted_by_a_current_user()
    {
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
        create(\Illuminate\Notifications\DatabaseNotification::class);

        $response = $this->getJson('/profiles/' . auth()->user()->name . '/notifications/')->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        create(\Illuminate\Notifications\DatabaseNotification::class);

        $user = auth()->user();

        $unreadNotifications = $user->fresh()->unreadNotifications;

        $this->assertCount(1, $unreadNotifications);

        $this->delete("/profiles/{$user->name}/notifications/{$unreadNotifications->first()->id}");

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
