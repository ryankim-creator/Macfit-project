<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         Category::create([
            'name' => 'Admin',
            'description' => 'This is an administration'
        ]);

        Category::create([
            'name' => 'User',
            'description' => 'This is a user'
        ]);

        Category::create([
            'name' => 'trainer',
            'description' => 'This is a trainer'
        ]);
         Category::create([
            'name' => 'staff',
            'description' => 'This is staff member'
        ]);
    }
}
