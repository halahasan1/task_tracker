
# Task Management Command

This command allows you to manage tasks in a Laravel application from the terminal. You can create, update, delete, or list tasks using the `task:manage` command.

## Installation

To use this command, ensure that you have Laravel installed and properly set up in your project.

1. Make sure the `TaskCommand` is registered in your `app/Console/Kernel.php` file. If it's not registered, add the following line to the `$commands` array:

```php
protected $commands = [
    \App\Console\Commands\TaskCommand::class,
];
```

2. After registering the command, run the following Artisan command to clear and re-cache the command list:

```bash
php artisan config:cache
```

Now you're ready to use the `task:manage` command.

## Command Usage

The command can be used to perform different actions on tasks. Here's the general syntax for running the command:

```bash
php artisan task:manage {action} {--option}
```

### Available Actions

- **create**: Create a new task.
- **update**: Update an existing task.
- **delete**: Delete a task.
- **list**: List all tasks.

### Available Options

- `--name`: The name of the task.
- `--description`: The description of the task.
- `--status`: The status of the task (accepted values: `not_started`, `in_progress`, `done`).
- `--id`: The ID of the task (required for `update` and `delete` actions).

---

## Examples

### 1. Create a Task

To create a new task, run the following command:

```bash
php artisan task:manage create --name="Write Blog Post" --description="Write a new blog post on Laravel commands" --status="not_started"
```

This will create a task with the name "Write Blog Post" and description "Write a new blog post on Laravel commands". The default status is `not_started`.

If you don't pass the `--name`, `--description`, or `--status` options, the command will prompt you for this information.

### 2. Update a Task

To update an existing task, you must provide the `--id` of the task you want to update. For example:

```bash
php artisan task:manage update --id=1 --name="Write Updated Blog Post" --status="in_progress"
```

This will update the task with ID `1`, changing its name to "Write Updated Blog Post" and status to "in_progress".

If you don't provide a value for a field (e.g., `--name` or `--status`), it will retain the previous value.

### 3. Delete a Task

To delete a task, you need to provide the `--id` option. For example:

```bash
php artisan task:manage delete --id=1
```

This will delete the task with ID `1`.

### 4. List All Tasks

To view all tasks, use the `list` action:

```bash
php artisan task:manage list
```

This will display a table of all tasks with columns for ID, Name, Description, Status, and Created At.

---

## Error Handling

- If the task ID provided for `update` or `delete` doesn't exist, the command will display an error message: `Task not found!`.
- If you provide an invalid action (other than `create`, `update`, `delete`, or `list`), the command will show an error: `Invalid action. Use create, update, delete, or list.`

---

## Conclusion

With this `task:manage` command, you can easily perform CRUD operations on tasks directly from your terminal. Whether you're creating new tasks, updating existing ones, or listing them, this command simplifies task management within your Laravel application.
```
