<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

class ProjectPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Project $project): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->role === 'editor';
    }

    public function update(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->user_id;
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->isAdmin() || $user->id === $project->user_id;
    }

    public function restore(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    public function forceDelete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }
}
