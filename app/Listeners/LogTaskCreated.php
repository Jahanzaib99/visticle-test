<?php

namespace App\Listeners;

use App\Events\TaskCreated;
use App\Models\TaskLog;

class LogTaskCreated
{
    /**
     * Handle the event.
     *
     * @param TaskCreated $event
     * @return void
     */
    public function handle(TaskCreated $event): void
    {
        TaskLog::create([
            'task_id' => $event->task->id,
            'event_type' => 'task_created',
            'description' => "Task '{$event->task->title}' was created.",
        ]);
    }
}
