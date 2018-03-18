<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class ReplyTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function it_has_an_owner()
    {
        $reply = create(\App\Reply::class);

        $this->assertInstanceOf(\App\User::class, $reply->owner);
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create(\App\Reply::class);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = \Carbon\Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }
}
