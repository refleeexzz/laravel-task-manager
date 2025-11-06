<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $task->comments()->create([
            'content' => $validated['content'],
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'comment added successfully');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($validated);

        return redirect()
            ->route('tasks.show', $comment->task)
            ->with('success', 'comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $task = $comment->task;
        $comment->delete();

        return redirect()
            ->route('tasks.show', $task)
            ->with('success', 'comment deleted successfully');
    }
}
