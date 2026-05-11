<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Hardware', 'Software', 'Network', 'Account / Access', 'Other'];
        
        foreach ($categories as $category) {
            \App\Models\Category::create(['name' => $category]);
        }
    }
}
