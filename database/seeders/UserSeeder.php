<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        //admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        //user
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@laundry.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
