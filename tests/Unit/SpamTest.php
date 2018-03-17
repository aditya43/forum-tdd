<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\Concerns\InteractsWithExceptionHandling;

class SpamTest extends TestCase
{
    use RefreshDatabase;
    use InteractsWithExceptionHandling;

    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new \App\Inspections\Spam();

        $this->assertFalse($spam->detect('Innocent reply here.'));

        config(['aditesting' => 'yes']);

        $this->expectException('Exception');

        $spam->detect('yahoo customer support');
    }

    /** @test */
    public function it_checks_for_any_key_being_held_down()
    {
        $spam = new \App\Inspections\Spam();

        config(['aditesting' => 'yes']);

        $this->expectException('Exception');

        $spam->detect('Hello World aaaaaaaa');
    }
}
