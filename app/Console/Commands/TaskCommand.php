<?php

namespace App\Console\Commands;

use App\Models\Task;
use Illuminate\Console\Command;

class TaskCommand extends Command
{
    // The name of the command that will be used in the terminal
    protected $signature = 'task:manage 
                            {action : The action to perform (create, update, delete, list)} 
                            {--name= : The name of the task} 
                            {--description= : The description of the task} 
                            {--id= : The ID of the task} 
                            {--status= : The status of the task (not_started, in_progress, done)}';

    // The description of the command that appears when you run `php artisan list`
    protected $description = 'Manage tasks (create, update, delete, list)';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = $this->argument('action');

        // Execute the corresponding method based on the action argument
        switch ($action) {
            case 'create':
                $this->createTask();
                break;

            case 'update':
                $this->updateTask();
                break;

            case 'delete':
                $this->deleteTask();
                break;

            case 'list':
                $this->listTasks();
                break;

            default:
                $this->error("Invalid action. Use create, update, delete, or list.");
                break;
        }
    }

    // Create a new task
    private function createTask()
    {
        // Get the task details from the options or ask the user for input
        $name = $this->option('name') ?: $this->ask('Task name');
        $description = $this->option('description') ?: $this->ask('Task description');
        $status = $this->option('status') ?: $this->ask('Task status (not_started, in_progress, done)', 'not_started');

        // Create a new task and save it to the database
        $task = Task::create([
            'name' => $name,
            'description' => $description,
            'status' => $status,
        ]);

        // Display success message
        $this->info("Task '{$task->name}' created successfully!");
    }

    // Update an existing task
    private function updateTask()
    {
        // Get the task ID from the options or ask the user to enter it
        $id = $this->option('id') ?: $this->ask('Enter the task ID to update');
        $task = Task::find($id);

        // Check if the task exists
        if (!$task) {
            $this->error('Task not found!');
            return;
        }

        // Update task details based on the provided options or existing task values
        $task->name = $this->option('name') ?: $task->name;
        $task->description = $this->option('description') ?: $task->description;
        $task->status = $this->option('status') ?: $task->status;

        // Save the updated task to the database
        $task->save();

        // Display success message
        $this->info("Task '{$task->name}' updated successfully!");
    }

    // Delete an existing task
    private function deleteTask()
    {
        // Get the task ID from the options or ask the user to enter it
        $id = $this->option('id') ?: $this->ask('Enter the task ID to delete');
        $task = Task::find($id);

        // Check if the task exists
        if (!$task) {
            $this->error('Task not found!');
            return;
        }

        // Delete the task
        $task->delete();

        // Display success message
        $this->info("Task '{$task->name}' deleted successfully!");
    }

    // List all tasks
    private function listTasks()
    {
        // Get all tasks from the database
        $tasks = Task::all();

        // If no tasks are found, display a message
        if ($tasks->isEmpty()) {
            $this->info('No tasks found.');
            return;
        }

        // Display the tasks in a table format
        $this->table(
            ['ID', 'Name', 'Description', 'Status', 'Created At'],
            $tasks->map(function ($task) {
                return [$task->id, $task->name, $task->description, $task->status, $task->created_at];
            })
        );
    }
}
