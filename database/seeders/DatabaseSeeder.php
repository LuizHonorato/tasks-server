<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@tasks.com',
            'password' => Hash::make("admin")
        ]);

        $user = User::where('email', 'admin@tasks.com')->first();

        $category = Category::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'name' => 'Estudos de programação'
        ]);

        Task::create([
           'id' => Str::uuid(),
           'user_id' => $user->id,
           'category_id' => $category->id,
           'title' => 'Estudar Python',
           'description' => 'Estudar Python 3x por semana',
           'status' => 'pending'
        ]);

        Task::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Estudar Golang',
            'description' => 'Estudar Golang 3x por semana',
            'status' => 'pending'
        ]);

        Task::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => 'Estudar DevOps',
            'description' => 'Estudar DevOps 3x por semana',
            'status' => 'pending'
        ]);
    }
}
