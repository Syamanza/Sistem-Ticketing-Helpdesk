<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name' => 'IT Support',
            'email' => 'support@company.com',
            'password' => bcrypt('password'),
            'role' => 'support',
        ]);

        \App\Models\User::create([
            'name' => 'Employee 1',
            'email' => 'employee@company.com',
            'password' => bcrypt('password'),
            'role' => 'user',
        ]);
    }
}
