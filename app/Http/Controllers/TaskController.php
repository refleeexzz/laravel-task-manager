<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['user', 'project', 'categories'])
            ->latest()
            ->paginate(20);

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::where('user_id', auth()->id())
            ->where('status', '!=', 'archived')
            ->get();
        
        $categories = Category::all();

        return view('tasks.create', compact('projects', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled,qa_review',
            'due_date' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $task = auth()->user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project_id' => $validated['project_id'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        if (isset($validated['categories'])) {
            $task->categories()->attach($validated['categories']);
        }

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'task created successfully');
    }

    public function show(Task $task)
    {
        $task->load(['user', 'project', 'categories', 'comments.user', 'attachments']);

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $projects = Project::where('user_id', auth()->id())
            ->where('status', '!=', 'archived')
            ->get();
        
        $categories = Category::all();

        return view('tasks.edit', compact('task', 'projects', 'categories'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'project_id' => 'required|exists:projects,id',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress,completed,cancelled,qa_review',
            'due_date' => 'nullable|date',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'project_id' => $validated['project_id'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? null,
        ]);

        if (isset($validated['categories'])) {
            $task->categories()->sync($validated['categories']);
        }

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'task updated successfully');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'task deleted successfully');
    }

    public function sendToQA(Task $task)
    {
        $this->authorize('sendToQA', $task);

        $task->update(['status' => 'qa_review']);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'task sent to qa review');
    }
}
