<?php

namespace App\Providers;

use App\Events\TodoWasMoved;
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
