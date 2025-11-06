<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total_projects' => $user->projects()->count(),
            'active_projects' => $user->projects()->where('status', 'active')->count(),
            'total_tasks' => $user->tasks()->count(),
            'pending_tasks' => $user->tasks()->where('status', 'pending')->count(),
            'in_progress_tasks' => $user->tasks()->where('status', 'in_progress')->count(),
            'completed_tasks' => $user->tasks()->where('status', 'completed')->count(),
            'overdue_tasks' => $user->tasks()
                ->whereIn('status', ['pending', 'in_progress'])
                ->where('due_date', '<', now())
                ->count(),
        ];

        $recent_projects = $user->projects()
            ->withCount('tasks')
            ->latest()
            ->take(5)
            ->get();

        $urgent_tasks = $user->tasks()
            ->where('priority', 'high')
            ->whereIn('status', ['pending', 'in_progress'])
            ->with(['project', 'categories'])
            ->latest()
            ->take(10)
            ->get();

        $upcoming_tasks = $user->tasks()
            ->whereNotNull('due_date')
            ->where('due_date', '>=', now())
            ->whereIn('status', ['pending', 'in_progress'])
            ->with(['project', 'categories'])
            ->orderBy('due_date')
            ->take(10)
            ->get();

        return view('dashboard', compact('stats', 'recent_projects', 'urgent_tasks', 'upcoming_tasks'));
    }
}
