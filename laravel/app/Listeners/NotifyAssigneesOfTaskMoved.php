<?php

namespace App\Listeners;

use App\Events\TaskEvent;
use App\Notifications\TaskMoved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAssigneesOfTaskMoved implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\TaskEvent $event
     * @return void
     */
    public function handle(TaskEvent $event)
    {
        foreach ($event->getTask()->assignees as $user) {
            $user->notify(new TaskMoved($event->getTask()));
        }
    }
}
