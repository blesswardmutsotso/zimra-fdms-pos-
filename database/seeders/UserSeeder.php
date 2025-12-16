<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user
        User::create([
            'name' => 'Nyasha Mutsotso',
            'email' => 'nyasha@gmail.com',
            'password' => Hash::make('password'), // replace with secure password
            'department' => 'Management',
            'dob' => '1990-01-01',
            'phone_number' => '0771234567',
            'passport_number' => 'AB123456',
            'user_type' => 1, 
        ]);

        // General user 1
        User::create([
            'name' => 'Blessward Mutsotso',
            'email' => 'blesswardmutsotso404@gmail.com',
            'password' => Hash::make('password'),
            'department' => 'Sales',
            'dob' => '2001-04-03',
            'phone_number' => '0787780405',
            'passport_number' => 'CD987654',
            'user_type' => 0, 
        ]);

        // General user 2
        User::create([
            'name' => 'Nenyasha Mutsotso',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'department' => 'Finance',
            'dob' => '1992-08-20',
            'phone_number' => '0771112223',
            'passport_number' => 'EF456789',
            'user_type' => 0, 
        ]);
    }
}
