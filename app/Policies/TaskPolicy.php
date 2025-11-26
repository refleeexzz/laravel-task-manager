<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Task $task): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->role === 'editor';
    }

    public function update(User $user, Task $task): bool
    {
        // owner can edit, qa can review, admin can do anything
        return $user->id === $task->user_id || $user->isAdmin() || $user->isQA();
    }

    public function delete(User $user, Task $task): bool
    {
        // only admin can delete tasks
        return $user->isAdmin();
    }

    public function sendToQA(User $user, Task $task): bool
    {
        // owner can send their tasks to qa
        return $user->id === $task->user_id;
    }

    public function restore(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, Task $task): bool
    {
        return $user->isAdmin();
    }
}
