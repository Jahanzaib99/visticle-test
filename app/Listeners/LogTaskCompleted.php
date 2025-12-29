<?php

namespace App\Listeners;

use App\Events\TaskCompleted;
use App\Models\TaskLog;

class LogTaskCompleted
{
    /**
     * Handle the event.
     *
     * @param TaskCompleted $event
     * @return void
     */
    public function handle(TaskCompleted $event): void
    {
        TaskLog::create([
            'task_id' => $event->task->id,
            'event_type' => 'task_completed',
            'description' => "Task '{$event->task->title}' was completed.",
        ]);
    }
}
