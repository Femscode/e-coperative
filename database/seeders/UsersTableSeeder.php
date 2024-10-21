<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Admin',
        //     'user_type' => 'Admin',
        //     'email' => 'onemillionhands@test.com',
        //     'password' => Hash::make('password123'),
        // ]);
        User::create([
            'name' => 'Admin',
            'user_type' => 'Admin',
            'email' => 'creator@admin.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
