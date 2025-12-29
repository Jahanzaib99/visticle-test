<h1>Task Completed</h1>
<p>Hello {{ $task->creator->name }},</p>
<p>Congratulations! Your task has been completed:</p>
<p><strong>Title:</strong> {{ $task->title }}</p>
@if($task->due_date)
    <p><strong>Due Date:</strong> {{ $task->due_date->format('Y-m-d') }}</p>
@endif
@if($task->description)
    <p><strong>Description:</strong> {{ $task->description }}</p>
@endif
<p>Great job on completing this task!</p>

