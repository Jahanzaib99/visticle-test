<?php

namespace App\Http\Controllers;

use App\Events\TaskCompleted;
use App\Events\TaskCreated;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     *
     * Admins see all tasks, regular users see only their own tasks.
     *
     * @return View
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $tasks = Task::with('creator')->latest()->get();
        } else {
            $tasks = Task::where('created_by', $user->id)->latest()->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     *
     * @return View
     */
    public function create(): View
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     *
     * Triggers TaskCreated event which sends email notification and logs the event.
     *
     * @param StoreTaskRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'due_date' => $request->due_date,
            'created_by' => auth()->id(),
        ]);

        event(new TaskCreated($task));

        return redirect()->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified task.
     *
     * Users can only view their own tasks unless they are admin.
     *
     * @param Task $task
     * @return View
     */
    public function show(Task $task): View
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $task->created_by !== $user->id) {
            abort(403);
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     *
     * Users can only edit their own tasks unless they are admin.
     *
     * @param Task $task
     * @return View
     */
    public function edit(Task $task): View
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $task->created_by !== $user->id) {
            abort(403);
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     *
     * Triggers TaskCompleted event if status changes to completed.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * @return RedirectResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $task->created_by !== $user->id) {
            abort(403);
        }

        $oldStatus = $task->status;

        $task->update($request->validated());

        if ($oldStatus !== 'completed' && $task->status === 'completed') {
            event(new TaskCompleted($task));
        }

        return redirect()->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified task from storage.
     *
     * Users can only delete their own tasks unless they are admin.
     *
     * @param Task $task
     * @return RedirectResponse
     */
    public function destroy(Task $task): RedirectResponse
    {
        $user = auth()->user();

        if (!$user->isAdmin() && $task->created_by !== $user->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}
