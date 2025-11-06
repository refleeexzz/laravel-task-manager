<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class QAUserSeeder extends Seeder
{
    public function run(): void
    {
        // create qa users
        $qaUsers = [
            [
                'name' => 'QA Tester 1',
                'email' => 'qa1@taskmanager.com',
                'password' => Hash::make('password'),
                'role' => 'qa',
            ],
            [
                'name' => 'QA Tester 2',
                'email' => 'qa2@taskmanager.com',
                'password' => Hash::make('password'),
                'role' => 'qa',
            ],
            [
                'name' => 'Maria Silva',
                'email' => 'maria.qa@taskmanager.com',
                'password' => Hash::make('password'),
                'role' => 'qa',
            ],
        ];

        foreach ($qaUsers as $userData) {
            User::create($userData);
        }
    }
}
