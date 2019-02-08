<?php

namespace App\Listeners;

use App\Events\TodoWasDone;
use App\Notifications\TodoDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CongratsAssigneesOfDoneTodo implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\TodoWasDone $event
     * @return void
     */
    public function handle(TodoWasDone $event)
    {
        foreach ($event->todo->assignees as $assignee) {
            $assignee->notify(new TodoDone($event->todo));
        }
    }
}
