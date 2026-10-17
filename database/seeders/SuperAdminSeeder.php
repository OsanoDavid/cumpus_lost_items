<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'superadmin@kisiiuniversity.ac.ke'],
            [
                'name' => 'Chief Super Administrator',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'is_admin' => true,
                'is_super_admin' => true,
                'phone' => '+254582030161',
                'reason_for_registering' => 'Super Administrator Authority',
                'email_verified_at' => now(),
            ]
        );
    }
}

