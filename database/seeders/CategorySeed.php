<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Web Development',
            ],
            [
                'name' => 'Mobile Development',
            ],
            [
                'name' => 'Data Science',
            ]
        ];
        DB::table('categories')->insert($categories);
    }
}
