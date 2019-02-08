<?php

namespace App\Events;

use App\Todo;

interface TodoEvent
{
    public function getTodo(): Todo;
}
