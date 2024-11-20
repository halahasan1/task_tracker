<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Http\Requests\StoreTaskRequest;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    use ApiResponse; // Using the ApiResponse Trait to handle unified responses

    public function __construct()
    {
        // Applying Sanctum authentication middleware to all actions
        $this->middleware('auth:sanctum'); 
    }

    // Create a new task
    public function create(StoreTaskRequest $request)
    {
        // Creating a new task and associating it with the authenticated user
        $task = $request->user()->tasks()->create([ 
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);

        // Returning a successful response with the newly created task
        return $this->successResponse($task, 'Task created successfully');
    }

    // Update the status and details of an existing task
    public function update(StoreTaskRequest $request, $id)
    {
        // Ensuring the task belongs to the authenticated user
        $task = $request->user()->tasks()->findOrFail($id); 

        // Updating the task with provided data or keeping the existing data if not provided
        $task->update([
            'name' => $request->name ?? $task->name,
            'description' => $request->description ?? $task->description,
            'status' => $request->status ?? $task->status,
        ]);

        // Returning a successful response with the updated task
        return $this->successResponse($task, 'Task updated successfully');
    }

    // Delete an existing task
    public function destroy(Request $request, $id)
    {
        // Ensuring the task belongs to the authenticated user
        $task = $request->user()->tasks()->findOrFail($id); 

        // Deleting the task
        $task->delete();

        // Returning a successful response after deletion
        return $this->successResponse(null, 'Task deleted successfully');
    }

    // Get all tasks for the authenticated user
    public function index(Request $request)
    {
        // Retrieving all tasks associated with the authenticated user
        $tasks = $request->user()->tasks()->get();

        // Returning the list of tasks in a successful response
        return $this->successResponse($tasks);
    }

    // Get only the completed tasks (status = 'done')
    public function done(Request $request)
    {
        // Retrieving tasks with the status 'done' for the authenticated user
        $tasks = $request->user()->tasks()->where('status', 'done')->get();

        // Returning the completed tasks in a successful response
        return $this->successResponse($tasks);
    }

    // Get only the tasks that are not yet completed (status = 'not_started' or 'in_progress')
    public function notDone(Request $request)
    {
        // Retrieving tasks that are either 'not_started' or 'in_progress' for the authenticated user
        $tasks = $request->user()->tasks()->where('status', 'not_started')
            ->orWhere('status', 'in_progress')->get();

        // Returning the non-completed tasks in a successful response
        return $this->successResponse($tasks);
    }

    // Get only the tasks that are currently in progress (status = 'in_progress')
    public function inProgress(Request $request)
    {
        // Retrieving tasks with the status 'in_progress' for the authenticated user
        $tasks = $request->user()->tasks()->where('status', 'in_progress')->get();

        // Returning the tasks in progress in a successful response
        return $this->successResponse($tasks);
    }
}
