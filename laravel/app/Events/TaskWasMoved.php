<?php

namespace App\Events;

use App\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TaskWasMoved implements TaskEvent
{
    use Dispatchable, SerializesModels;

    /**
     * @var \App\Task
     */
    public $task;

    /**
     * Create a new event instance.
     *
     * @param \App\Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
