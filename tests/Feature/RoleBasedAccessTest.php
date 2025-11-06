<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleBasedAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_user_management(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/users');

        $response->assertStatus(200);
    }

    public function test_qa_cannot_access_user_management(): void
    {
        $qa = User::factory()->create(['role' => 'qa']);

        $response = $this->actingAs($qa)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_editor_cannot_access_user_management(): void
    {
        $editor = User::factory()->create(['role' => 'editor']);

        $response = $this->actingAs($editor)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_reader_cannot_access_user_management(): void
    {
        $reader = User::factory()->create(['role' => 'reader']);

        $response = $this->actingAs($reader)->get('/admin/users');

        $response->assertStatus(403);
    }

    public function test_all_roles_can_access_dashboard(): void
    {
        $roles = ['admin', 'qa', 'editor', 'reader'];

        foreach ($roles as $role) {
            $user = User::factory()->create(['role' => $role]);
            $response = $this->actingAs($user)->get('/dashboard');
            $response->assertStatus(200);
        }
    }
}
