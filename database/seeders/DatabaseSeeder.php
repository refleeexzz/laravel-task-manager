<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * seed the application's database with sample data.
     * creates users, projects, tasks, categories, and comments
     * for development and testing purposes.
     *
     * @return void
     */
    public function run(): void
    {
        // seed predefined categories
        $this->call([
            CategorySeeder::class,
        ]);

        // create a main test user
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // create 5 additional random users
        $users = User::factory(5)->create();

        // combine all users for task assignment
        $users->push($user);

        // create 10 projects distributed among users
        $projects = Project::factory(10)
            ->recycle($users)
            ->create();

        // create 50 tasks linked to projects and users
        $tasks = Task::factory(50)
            ->recycle($users)
            ->recycle($projects)
            ->create();

        // attach random categories to each task (1-3 categories per task)
        $categories = Category::all();
        $tasks->each(function ($task) use ($categories) {
            $task->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')
            );
        });

        // create 100 comments distributed across tasks
        Comment::factory(100)
            ->recycle($users)
            ->recycle($tasks)
            ->create();
    }
}
