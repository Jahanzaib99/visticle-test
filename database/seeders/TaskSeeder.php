<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            Task::create([
                'title' => 'Sample Task 1',
                'description' => 'This is a sample task description.',
                'status' => 'pending',
                'due_date' => now()->addDays(7),
                'created_by' => $user->id,
            ]);

            Task::create([
                'title' => 'Sample Task 2',
                'description' => 'Another sample task.',
                'status' => 'in_progress',
                'due_date' => now()->addDays(3),
                'created_by' => $user->id,
            ]);
        }
    }
}
