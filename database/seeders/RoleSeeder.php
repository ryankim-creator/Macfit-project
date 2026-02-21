<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Admin',
            'description' => 'This is an administration'
        ]);

        Role::create([
            'name' => 'User',
            'description' => 'This is a user'
        ]);

        Role::create([
            'name' => 'trainer',
            'description' => 'This is a trainer'
        ]);
         Role::create([
            'name' => 'staff',
            'description' => 'This is staff member'
        ]);
    
   }
}
