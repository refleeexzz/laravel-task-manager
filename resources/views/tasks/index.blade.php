<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                Tasks
            </h2>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Task
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <p class="text-sm text-green-800 dark:text-green-400">{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6">
                    @forelse($tasks as $task)
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
                                            {{ $task->status === 'pending' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}
                                            {{ $task->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : '' }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </div>
                                    
                                    @if($task->description)
                                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">{{ Str::limit($task->description, 150) }}</p>
                                    @endif

                                    <div class="flex items-center gap-4 text-xs text-gray-500 dark:text-gray-400">
                                        @if($task->project)
                                            <span class="flex items-center">
                                                <span class="w-2 h-2 rounded-full mr-1.5" style="background-color: {{ $task->project->color }}"></span>
                                                {{ $task->project->name }}
                                            </span>
                                        @endif
                                        <span>By {{ $task->user->name }}</span>
                                        @if($task->due_date)
                                            <span class="{{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600 dark:text-red-400 font-medium' : '' }}">
                                                Due {{ $task->due_date->diffForHumans() }}
                                            </span>
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
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No tasks yet</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-4">Get started by creating your first task.</p>
                            <a href="{{ route('tasks.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                Create Task
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
