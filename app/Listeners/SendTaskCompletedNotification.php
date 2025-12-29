<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Jobs\SendTaskCompletionJob;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskCompletedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param TaskCompleted $event
     * @return void
     */
    public function handle(TaskCompleted $event): void
    {
        SendTaskCompletionJob::dispatch($event->task);
    }
}
