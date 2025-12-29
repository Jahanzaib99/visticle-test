<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskCompleted;
use App\Events\TaskCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of tasks.
     *
     * Admins see all tasks, regular users see only their own tasks.
     *
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $tasks = Task::with('creator')->latest()->get();
        } else {
            $tasks = Task::where('created_by', $user->id)->latest()->get();
        }

        return response()->json([
            'data' => $tasks,
        ]);
    }

    /**
     * Store a newly created task in storage.
     *
     * Triggers TaskCreated event which sends email notification and logs the event.
     *
     * @param StoreTaskRequest $request
     * 
     * @return JsonResponse
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ?? 'pending',
            'due_date' => $request->due_date,
            'created_by' => $request->user()->id,
        ]);

        event(new TaskCreated($task));

        return response()->json([
            'message' => 'Task created successfully',
            'data' => $task->load('creator'),
        ], 201);
    }

    /**
     * Update the specified task in storage.
     *
     * Users can only update their own tasks unless they are admin.
     * Triggers TaskCompleted event if status changes to completed.
     *
     * @param UpdateTaskRequest $request
     * @param Task $task
     * 
     * @return JsonResponse
     */
    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        $user = $request->user();

        if (!$user->isAdmin() && $task->created_by !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $oldStatus = $task->status;

        $task->update($request->validated());

        if ($oldStatus !== 'completed' && $task->status === 'completed') {
            event(new TaskCompleted($task));
        }

        return response()->json([
            'message' => 'Task updated successfully',
            'data' => $task->load('creator'),
        ]);
    }

    /**
     * Remove the specified task from storage.
     *
     * Users can only delete their own tasks unless they are admin.
     *
     * @param Request $request
     * @param Task $task
     * 
     * @return JsonResponse
     */
    public function destroy(Request $request, Task $task): JsonResponse
    {
        $user = $request->user();

        if (!$user->isAdmin() && $task->created_by !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully',
        ]);
    }
}
