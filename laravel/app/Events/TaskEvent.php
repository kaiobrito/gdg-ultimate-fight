<?php

namespace App\Events;

use App\Task;

interface TaskEvent
{
    public function getTask(): Task;
}
