<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use App\Models\Coffee;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create departments
        Department::create(['name' => 'IT']);
        Department::create(['name' => 'HR']);
        Department::create(['name' => 'Marketing']);

        // Create users
        User::create([
            'name' => 'Apple Man',
            'email' => 'testing@gmail.com',
            'password' => bcrypt('password'),
            'department_id' => 1
        ]);
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => bcrypt('password'),
            'department_id' => 2
        ]);
        User::create([
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'password' => bcrypt('password'),
            'department_id' => 3
        ]);
    }
}
