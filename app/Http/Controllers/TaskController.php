<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('completed', 'false')->orderBy('priority', 'desc')->orderBy('due_date')->get();

        return view('tasks.index', compact('tasks'));
    }

    public function taskshow()
    {
        $tasks = Task::where('completed', true)->get();

        return view('tasks.show', compact('tasks'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',
            'priority' => 'required|max:255',
            'due_date' => 'nullable|max:255',
        ]);

        Task::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'due_date' => $request->input('due_date')
        ]);
        return redirect()->route('tasks.index')->with('success', 'Task created Successfully');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',
            'priority' => 'required|max:255',
            'due_date' => 'nullable|max:255',
        ]);

        $task->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'priority' => $request->input('priority'),
            'due_date' => $request->input('due_date')
        ]);


        return redirect()->route('tasks.index')->with('success', 'Task updated Successfully');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted Successfully');
    }

    public function complete(Task $task)
    {
        $task->update([
            'completed' => true,

        ]);
        return redirect()->route('tasks.index')->with('success', 'Task deleted Successfully');
    }
}
