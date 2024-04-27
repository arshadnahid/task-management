<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'user_id' => 1,
                'title' => fake()->title(),
                'description' => fake()->text(),
                'due_date' => now(),
                'status' => 'pending',
                'tags' => json_encode('["php", "laravel", "Javascript"]'),
            ],
            [
                'user_id' => 1,
                'title' => fake()->title(),
                'description' => fake()->text(),
                'due_date' => now(),
                'status' => 'pending',
                'tags' => json_encode('["Java", "GoLan", "Javascript"]'),
            ],
            [
                'user_id' => 1,
                'title' => fake()->title(),
                'description' => fake()->text(),
                'due_date' => now(),
                'status' => 'completed',
                'tags' => json_encode('["Python", "GoLan"]'),
            ],
            [
                'user_id' => 2,
                'title' => fake()->title(),
                'description' => fake()->text(),
                'due_date' => now(),
                'status' => 'pending',
                'tags' => json_encode('["Python", "GoLan"]'),
            ],
            [
                'user_id' => 2,
                'title' => fake()->title(),
                'description' => fake()->text(),
                'due_date' => now(),
                'status' => 'pending',
                'tags' => json_encode('["Raw Php", "OOP"]'),
            ],
            [
                'user_id' => 2,
                'title' => fake()->title(),
                'description' => fake()->text(),
                'due_date' => now(),
                'status' => 'pending',
                'tags' => json_encode('["Auth", "OOP"]'),
            ],
            [
                'user_id' => 2,
                'title' => fake()->title(),
                'description' => fake()->text(),
                'due_date' => now(),
                'status' => 'completed',
                'tags' => json_encode('["Python", "OOP"]'),
            ],

        ];
        DB::table('tasks')->insert($tasks);
    }
}
