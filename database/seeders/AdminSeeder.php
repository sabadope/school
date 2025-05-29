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
        // Create default admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('Admin123!'),
            'role_name' => 'Admin',
            'join_date' => Carbon::now()->toDayDateTimeString(),
            'status' => 'Active',
            'avatar' => 'photo_defaults.jpg'
        ]);
    }
} 