<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_tasks_list(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tasks');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_task(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $project = Project::factory()->create();

        $response = $this->actingAs($admin)->post('/tasks', [
            'title' => 'Test Task',
            'description' => 'Test Description',
            'project_id' => $project->id,
            'status' => 'pending',
            'priority' => 'medium',
        ]);

        $task = Task::where('title', 'Test Task')->first();
        $response->assertRedirect("/tasks/{$task->id}");
        $this->assertDatabaseHas('tasks', [
            'title' => 'Test Task',
        ]);
    }

    public function test_editor_can_update_own_task(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);
        $project = Project::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'user_id' => $editor->id,
        ]);

        $response = $this->actingAs($editor)->put("/tasks/{$task->id}", [
            'title' => 'Updated Task',
            'description' => 'Updated Description',
            'project_id' => $project->id,
            'status' => 'in_progress',
            'priority' => 'high',
        ]);

        $response->assertRedirect("/tasks/{$task->id}");
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => 'Updated Task',
        ]);
    }

    public function test_qa_can_review_task(): void
    {
        $qa = User::factory()->create(['role' => 'qa']);
        $project = Project::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'status' => 'qa_review',
        ]);

        $response = $this->actingAs($qa)->put("/tasks/{$task->id}", [
            'title' => $task->title,
            'description' => $task->description,
            'project_id' => $project->id,
            'status' => 'completed',
            'priority' => $task->priority,
            'qa_status' => 'approved',
        ]);

        $response->assertRedirect("/tasks/{$task->id}");
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'qa_status' => 'approved',
        ]);
    }

    public function test_reader_cannot_create_task(): void
    {
        $reader = User::factory()->create(['role' => 'reader']);
        $project = Project::factory()->create();

        $response = $this->actingAs($reader)->post('/tasks', [
            'title' => 'Reader Task',
            'description' => 'Reader Description',
            'project_id' => $project->id,
            'status' => 'pending',
            'priority' => 'low',
        ]);

        $response->assertStatus(403);
    }

    public function test_task_can_be_sent_to_qa(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);
        $project = Project::factory()->create();
        $task = Task::factory()->create([
            'project_id' => $project->id,
            'user_id' => $editor->id,
            'status' => 'in_progress',
        ]);

        $response = $this->actingAs($editor)->put("/tasks/{$task->id}", [
            'title' => $task->title,
            'description' => $task->description,
            'project_id' => $project->id,
            'status' => 'qa_review',
            'priority' => $task->priority,
        ]);

        $response->assertRedirect("/tasks/{$task->id}");
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'status' => 'qa_review',
        ]);
    }

    public function test_admin_can_delete_task(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $project = Project::factory()->create();
        $task = Task::factory()->create(['project_id' => $project->id]);

        $response = $this->actingAs($admin)->delete("/tasks/{$task->id}");

        $response->assertRedirect('/tasks');
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }
}
