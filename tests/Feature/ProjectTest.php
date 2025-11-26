<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_projects_list(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/projects');

        $response->assertStatus(200);
    }

    public function test_admin_can_create_project(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/projects', [
            'name' => 'Test Project',
            'description' => 'Test Description',
            'status' => 'active',
            'color' => '#3b82f6',
        ]);

        $project = Project::where('name', 'Test Project')->first();
        $response->assertRedirect("/projects/{$project->id}");
        $this->assertDatabaseHas('projects', [
            'name' => 'Test Project',
        ]);
    }

    public function test_editor_can_create_project(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $response = $this->actingAs($editor)->post('/projects', [
            'name' => 'Editor Project',
            'description' => 'Editor Description',
            'status' => 'active',
            'color' => '#10b981',
        ]);

        $project = Project::where('name', 'Editor Project')->first();
        $response->assertRedirect("/projects/{$project->id}");
        $this->assertDatabaseHas('projects', [
            'name' => 'Editor Project',
        ]);
    }

    public function test_reader_cannot_create_project(): void
    {
        $reader = User::factory()->create(['role' => 'reader']);

        $response = $this->actingAs($reader)->post('/projects', [
            'name' => 'Reader Project',
            'description' => 'Reader Description',
            'status' => 'active',
            'color' => '#ef4444',
        ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_update_project(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $project = Project::factory()->create();

        $response = $this->actingAs($admin)->put("/projects/{$project->id}", [
            'name' => 'Updated Project',
            'description' => 'Updated Description',
            'status' => 'completed',
            'color' => $project->color,
        ]);

        $response->assertRedirect("/projects/{$project->id}");
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Project',
        ]);
    }

    public function test_admin_can_delete_project(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $project = Project::factory()->create();

        $response = $this->actingAs($admin)->delete("/projects/{$project->id}");

        $response->assertRedirect('/projects');
        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);
    }

    public function test_reader_cannot_delete_project(): void
    {
        $reader = User::factory()->create(['role' => 'reader']);
        $project = Project::factory()->create();

        $response = $this->actingAs($reader)->delete("/projects/{$project->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
        ]);
    }
}
