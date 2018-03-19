<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;

class NotifyMentionedUsers
{
    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        collect($event->reply->mentionedUsers())
            ->map(function ($name) {
                return \App\User::where('name', $name)->first();
            })
            ->filter() // To strip all 'null' instances.
            ->each(function ($user) use ($event) {
                $user->notify(new \App\Notifications\YouWereMentioned($event->reply));
            });
    }
}
