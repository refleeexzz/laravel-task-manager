<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-4 h-4 rounded-full" style="background-color: {{ $project->color }}"></div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $project->name }}
                </h2>
                <span class="px-3 py-1 text-xs rounded-full 
                    {{ $project->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : '' }}
                    {{ $project->status === 'completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' : '' }}
                    {{ $project->status === 'archived' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('projects.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                    ← Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-sm text-green-800 dark:text-green-400">{{ session('success') }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Description</h3>
                        @if($project->description)
                            <p class="text-gray-600 dark:text-gray-400">{{ $project->description }}</p>
                        @else
                            <p class="text-gray-400 dark:text-gray-500 italic">No description provided</p>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tasks</h3>
                            <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-700">+ Add Task</a>
                        </div>
                        <div class="p-6">
                            @forelse($project->tasks as $task)
                                <a href="{{ route('tasks.show', $task) }}" class="block mb-4 last:mb-0 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-indigo-300 dark:hover:border-indigo-600 transition-colors duration-150">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $task->title }}</h4>
                                                <span class="px-2 py-0.5 text-xs rounded
                                                    {{ $task->priority === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : '' }}
                                                    {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : '' }}
                                                    {{ $task->priority === 'low' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                                <span class="px-2 py-0.5 text-xs rounded
                                                    {{ $task->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : '' }}
                                                    {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' : '' }}
                                                    {{ $task->status === 'pending' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </div>
                                            
                                            @if($task->description)
                                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($task->description, 100) }}</p>
                                            @endif

                                            <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                                @if($task->due_date)
                                                    <span>Due {{ $task->due_date->diffForHumans() }}</span>
                                                @endif
                                            </div>

                                            @if($task->categories->count() > 0)
                                                <div class="flex flex-wrap gap-1 mt-2">
                                                    @foreach($task->categories as $category)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs" style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                                            {{ $category->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-8">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">No tasks yet</p>
                                    <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="text-sm text-indigo-600 hover:text-indigo-700">Create your first task</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Project Info</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Owner</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->user->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->created_at->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $project->updated_at->diffForHumans() }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                        <div class="space-y-2">
                            @can('update', $project)
                                <a href="{{ route('projects.edit', $project) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                    Edit Project
                                </a>
                            @endcan
                            @can('delete', $project)
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="block w-full px-4 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-800 dark:text-red-400 text-sm font-medium rounded-lg transition-colors duration-150">
                                        Delete Project
                                    </button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
