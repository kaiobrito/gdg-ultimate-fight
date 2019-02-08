<?php

namespace App\Events;

use App\Todo;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class TodoWasDone implements TodoEvent
{
    use Dispatchable, SerializesModels;

    /**
     * @var \App\Todo
     */
    public $todo;

    /**
     * Create a new event instance.
     *
     * @param \App\Todo $todo
     */
    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    public function getTodo(): Todo
    {
        return $this->todo;
    }
}
