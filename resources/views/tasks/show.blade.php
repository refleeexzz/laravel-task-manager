<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $task->title }}
                </h2>
                <span class="px-3 py-1 text-xs rounded
                    {{ $task->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : '' }}
                    {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-400' : '' }}
                    {{ $task->status === 'pending' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}
                    {{ $task->status === 'cancelled' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : '' }}">
                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                </span>
            </div>
            <div class="flex items-center gap-3">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                        Edit
                    </a>
                @endcan
                <a href="{{ route('tasks.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
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
                        @if($task->description)
                            <p class="text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $task->description }}</p>
                        @else
                            <p class="text-gray-400 dark:text-gray-500 italic">No description provided</p>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Comments</h3>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('comments.store', $task) }}" method="POST" class="mb-6">
                                @csrf
                                <textarea name="content" rows="3" placeholder="Add a comment..." required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white mb-3"></textarea>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                    Add Comment
                                </button>
                            </form>

                            @forelse($task->comments as $comment)
                                <div class="mb-4 last:mb-0 p-4 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center gap-2">
                                            <span class="font-medium text-sm text-gray-900 dark:text-white">{{ $comment->user->name }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        @if($comment->user_id === auth()->id())
                                            <form action="{{ route('comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:text-red-700 dark:text-red-400">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-300 whitespace-pre-wrap">{{ $comment->content }}</p>
                                </div>
                            @empty
                                <p class="text-center text-sm text-gray-500 dark:text-gray-400 py-4">No comments yet. Be the first to comment!</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Task Info</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Project</dt>
                                <dd class="mt-1">
                                    @if($task->project)
                                        <a href="{{ route('projects.show', $task->project) }}" class="flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $task->project->color }}"></span>
                                            {{ $task->project->name }}
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-400">No project</span>
                                    @endif
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Priority</dt>
                                <dd class="mt-1">
                                    <span class="px-2 py-1 text-xs rounded
                                        {{ $task->priority === 'high' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : '' }}
                                        {{ $task->priority === 'medium' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : '' }}
                                        {{ $task->priority === 'low' ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' : '' }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Assigned to</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->user->name }}</dd>
                            </div>
                            @if($task->due_date)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Due Date</dt>
                                    <dd class="mt-1 text-sm {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-600 dark:text-red-400 font-medium' : 'text-gray-900 dark:text-white' }}">
                                        {{ $task->due_date->format('M d, Y') }}
                                        <span class="text-xs">({{ $task->due_date->diffForHumans() }})</span>
                                    </dd>
                                </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Created</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->created_at->format('M d, Y') }}</dd>
                            </div>
                        </dl>

                        @if($task->categories->count() > 0)
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-3">Categories</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($task->categories as $category)
                                        <a href="{{ route('categories.show', $category) }}" class="inline-flex items-center px-3 py-1 rounded-lg text-sm transition-colors" style="background-color: {{ $category->color }}20; color: {{ $category->color }}">
                                            {{ $category->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions</h3>
                        <div class="space-y-2">
                            @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}" class="block w-full text-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-900 dark:text-white text-sm font-medium rounded-lg transition-colors duration-150">
                                    Edit Task
                                </a>
                            @endcan
                            
                            @can('sendToQA', $task)
                                @if($task->status !== 'qa_review')
                                    <form action="{{ route('tasks.send-to-qa', $task) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 text-blue-800 dark:text-blue-400 text-sm font-medium rounded-lg transition-colors duration-150">
                                            Send to QA Review
                                        </button>
                                    </form>
                                @else
                                    <div class="block w-full px-4 py-2 bg-blue-50 dark:bg-blue-900/10 text-blue-700 dark:text-blue-300 text-sm font-medium rounded-lg text-center">
                                        ✓ In QA Review
                                    </div>
                                @endif
                            @endcan
                            
                            @can('delete', $task)
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="block w-full px-4 py-2 bg-red-100 hover:bg-red-200 dark:bg-red-900/20 dark:hover:bg-red-900/30 text-red-800 dark:text-red-400 text-sm font-medium rounded-lg transition-colors duration-150">
                                        Delete Task
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
