<?php

namespace App\Listeners;

use App\Notifications\TodoMoved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyAssigneesTodoMoved implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\TodoWasMoved $event
     * @return void
     */
    public function handle($event)
    {
        foreach ($event->todo->assignees as $user) {
            $user->notify(new TodoMoved($event->todo));
        }
    }
}
