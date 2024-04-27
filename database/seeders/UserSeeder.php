<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Mahmud Arshad Nahid',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ],
            [
                'first_name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('123456'),
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        ];
        DB::table('users')->insert($users);
    }
}
