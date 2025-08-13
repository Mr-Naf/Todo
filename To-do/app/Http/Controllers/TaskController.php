<?php

namespace App\Http\Controllers;

use App\Models\Task; // This connects to our Task table
use Illuminate\Http\Request; // This allows us to get form data from the user

class TaskController extends Controller
{
    /**
     * Show all tasks from the database
     */
    public function index()
    {
        // Get all tasks from the database
        $tasks = Task::all();

        // Send the tasks back as JSON (for AJAX)
        return response()->json($tasks);
    }

    /**
     * Add a new task to the database
     */
    public function store(Request $request)
    {
        // Create a new task with the title from the request
        $task = Task::create([
            'title' => $request->title, // Example: "Buy groceries"
        ]);

        // Send the created task back as JSON
        return response()->json($task);
    }

    /**
     * Mark a task as completed (or update it)
     */
    public function update(Request $request, Task $task)
    {
        // Update the "completed" column
        $task->update([
            'completed' => $request->completed, // true or false
        ]);

        // Send the updated task back
        return response()->json($task);
    }

    /**
     * Delete a task from the database
     */
    public function destroy(Task $task)
    {
        // Remove the task
        $task->delete();

        // Send success message back
        return response()->json(['success' => true]);
    }
};
