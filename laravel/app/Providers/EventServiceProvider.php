<?php

namespace App\Providers;

use App\Events\TaskWasDone;
use App\Events\TaskWasMoved;
use Illuminate\Auth\Events\Registered;
use App\Listeners\NotifyAssigneesOfTaskMoved;
use App\Listeners\CongratsAssigneesOfDoneTask;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        TaskWasMoved::class => [
            NotifyAssigneesOfTaskMoved::class,
        ],
        TaskWasDone::class => [
            CongratsAssigneesOfDoneTask::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
