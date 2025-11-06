<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * seed predefined categories for task organization.
     * creates common categories with associated colors.
     *
     * @return void
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Work', 'color' => '#3B82F6'],
            ['name' => 'Personal', 'color' => '#10B981'],
            ['name' => 'Urgent', 'color' => '#EF4444'],
            ['name' => 'Important', 'color' => '#F59E0B'],
            ['name' => 'Meeting', 'color' => '#8B5CF6'],
            ['name' => 'Development', 'color' => '#06B6D4'],
            ['name' => 'Design', 'color' => '#EC4899'],
            ['name' => 'Bug', 'color' => '#DC2626'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
