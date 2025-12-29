@extends('layouts.app')

@section('title', 'Create Task')

@section('content')
<h1>Create Task</h1>

<form method="POST" action="{{ route('tasks.store') }}">
    @csrf

    <label for="title">Title *</label>
    <input type="text" name="title" id="title" value="{{ old('title') }}" required>

    <label for="description">Description</label>
    <textarea name="description" id="description" rows="4">{{ old('description') }}</textarea>

    <label for="status">Status</label>
    <select name="status" id="status">
        <option value="pending" {{ old('status') === 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="in_progress" {{ old('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
    </select>

    <label for="due_date">Due Date</label>
    <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}">

    <button type="submit" class="btn btn-primary">Create Task</button>
    <a href="{{ route('tasks.index') }}">Cancel</a>
</form>
@endsection

