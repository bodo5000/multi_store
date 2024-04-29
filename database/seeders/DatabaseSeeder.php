<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '01096379831'
        ]);

        User::factory()->create([
            'name' => 'UserOne',
            'email' => 'userOne@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '01096379833'
        ]);

        User::factory()->create([
            'name' => 'userTwo',
            'email' => 'userTwo@example.com',
            'password' => Hash::make('password'),
            'phone_number' => '01096379832'
        ]);

        Store::factory(5)->create();
        Category::factory(10)->create();
        Product::factory(100)->create();
    }
}
