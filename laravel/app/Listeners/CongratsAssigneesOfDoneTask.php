<?php

namespace App\Listeners;

use App\Events\TaskWasDone;
use App\Notifications\TaskDone;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CongratsAssigneesOfDoneTask implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param \App\Events\TaskWasDone $event
     * @return void
     */
    public function handle(TaskWasDone $event)
    {
        foreach ($event->task->assignees as $assignee) {
            $assignee->notify(new TaskDone($event->task));
        }
    }
}
