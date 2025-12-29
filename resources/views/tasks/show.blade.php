@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
<div style="margin-bottom: 20px;">
    <a href="{{ route('tasks.index') }}">← Back to Tasks</a>
</div>

<div>
    <h1>{{ $task->title }}</h1>
    
    <p><strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $task->status)) }}</p>

    @if($task->description)
        <p><strong>Description:</strong> {{ $task->description }}</p>
    @endif

    <p><strong>Due Date:</strong> {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'Not set' }}</p>
    <p><strong>Created:</strong> {{ $task->created_at->format('Y-m-d H:i') }}</p>

    <div style="margin-top: 20px;">
        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-primary">Edit</a>
        <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
</div>
@endsection

