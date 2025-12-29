<?php

namespace App\Providers;

use App\Events\TaskCompleted;
use App\Events\TaskCreated;
use App\Listeners\LogTaskCompleted;
use App\Listeners\LogTaskCreated;
use App\Listeners\SendTaskCompletedNotification;
use App\Listeners\SendTaskCreatedNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TaskCreated::class => [
            SendTaskCreatedNotification::class,
            LogTaskCreated::class,
        ],
        TaskCompleted::class => [
            SendTaskCompletedNotification::class,
            LogTaskCompleted::class,
        ],
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        //
    }
}
