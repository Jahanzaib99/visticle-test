<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Mail\TaskCreatedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendTaskCreatedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * @param TaskCreated $event
     * @return void
     */
    public function handle(TaskCreated $event): void
    {
        Mail::to($event->task->creator->email)
            ->send(new TaskCreatedMail($event->task));
    }
}
