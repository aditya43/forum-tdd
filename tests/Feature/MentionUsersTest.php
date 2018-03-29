<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $john = create(\App\User::class, ['name' => 'JohnDoe']);
        $jane = create(\App\User::class, ['name' => 'JaneDoe']);

        $this->signIn($john);

        $thread = create(\App\Thread::class);
        $reply  = make(\App\Reply::class, ['body' => '@JaneDoe check this out..']);

        $this->json('POST', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_with_the_given_characters()
    {
        create(\App\User::class, ['name' => 'johndoe']);
        create(\App\User::class, ['name' => 'johndoe2']);
        create(\App\User::class, ['name' => 'janedoe']);

        $results = $this->json('GET', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
