<?php

namespace App\Jobs;

use App\Mail\TaskCompletedMail;
use App\Models\Task;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendTaskCompletionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     *
     * @param Task $task
     */
    public function __construct(public Task $task)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        Mail::to($this->task->creator->email)
            ->send(new TaskCompletedMail($this->task));
    }
}
