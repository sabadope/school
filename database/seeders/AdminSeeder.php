<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Delete existing admin user if exists
        User::where('email', 'admin@gmail.com')->delete();

        // Create new admin user with complete information
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123!'),
            'status' => 'Active',
            'role_name' => 'admin',
            'join_date' => Carbon::now()->toDayDateTimeString(),
            'phone_number' => '+1234567890',
            'avatar' => 'photo_defaults.jpg',
            'position' => 'System Administrator',
            'department' => 'Administration',
        ]);
    }
} 