<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * display the dashboard with statistics and recent tasks.
     */
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_tasks' => $user->tasks()->count(),
            'completed_tasks' => $user->tasks()->where('status', 'completed')->count(),
            'in_progress_tasks' => $user->tasks()->where('status', 'in_progress')->count(),
            'overdue_tasks' => $user->tasks()
                ->where('status', '!=', 'completed')
                ->where('due_date', '<', now())
                ->count(),
        ];

        $recentTasks = $user->tasks()
            ->with(['project', 'categories'])
            ->latest()
            ->take(10)
            ->get();

        $projects = $user->projects()
            ->withCount('tasks')
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('stats', 'recentTasks', 'projects'));
    }
}
