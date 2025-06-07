<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'administrator',
            'email' => 'administrator@example.com',
            'password' => 'administrator',
            'role' => 'admin'
        ]);
        User::factory()->create([
            'name' => 'librarian',
            'email' => '@example.com',
            'password' => 'librarian',
            'role' => 'librarian'
        ]);
        User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
            'password' => 'user12345',
            'role' => 'user'
        ]);
    }
}
