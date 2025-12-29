<h1>Task Created</h1>
<p>Hello {{ $task->creator->name }},</p>
<p>A new task has been created:</p>
<p><strong>Title:</strong> {{ $task->title }}</p>
<p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $task->status)) }}</p>
@if($task->due_date)
    <p><strong>Due Date:</strong> {{ $task->due_date->format('Y-m-d') }}</p>
@endif
@if($task->description)
    <p><strong>Description:</strong> {{ $task->description }}</p>
@endif
<p>Thank you for using our task management system.</p>

