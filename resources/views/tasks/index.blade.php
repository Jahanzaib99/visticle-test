@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Tasks</h1>
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
</div>

@if($tasks->isEmpty())
    <p>No tasks found. Create your first task!</p>
@else
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Due Date</th>
                @if(auth()->user()->isAdmin())
                    <th>Created By</th>
                @endif
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td><a href="{{ route('tasks.show', $task) }}">{{ $task->title }}</a></td>
                    <td>{{ ucfirst(str_replace('_', ' ', $task->status)) }}</td>
                    <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                    @if(auth()->user()->isAdmin())
                        <td>{{ $task->creator->name }}</td>
                    @endif
                    <td>
                        <a href="{{ route('tasks.edit', $task) }}">Edit</a> |
                        <form method="POST" action="{{ route('tasks.destroy', $task) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection

