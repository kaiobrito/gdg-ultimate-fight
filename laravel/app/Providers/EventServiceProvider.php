<?php

namespace App\Providers;

use App\Events\TodoWasDone;
use App\Events\TodoWasMoved;
use App\Listeners\CongratsAssigneesOfDoneTodo;
use Illuminate\Auth\Events\Registered;
use App\Listeners\NotifyAssigneesTodoMoved;
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
        TodoWasMoved::class => [
            NotifyAssigneesTodoMoved::class,
        ],
        TodoWasDone::class => [
            CongratsAssigneesOfDoneTodo::class,
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
