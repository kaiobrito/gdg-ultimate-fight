<?php

namespace App\Listeners;

use App\Events\TodoEvent;
use App\Notifications\TodoMoved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAssigneesTodoMoved implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\TodoEvent $event
     * @return void
     */
    public function handle(TodoEvent $event)
    {
        foreach ($event->getTodo()->assignees as $user) {
            $user->notify(new TodoMoved($event->getTodo()));
        }
    }
}
