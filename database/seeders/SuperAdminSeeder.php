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
                'reg_number' => 'SUPER/001/ADMIN',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'is_admin' => true,
                'is_super_admin' => true,
                'phone' => '+254582030161',
                'school' => 'School of Information Sciences & Technology (SIST)',
                'course' => 'Administration & Security Oversight',
                'year_of_study' => 'Staff / Admin',
                'reason_for_registering' => 'Super Administrator Authority',
                'email_verified_at' => now(),
            ]
        );
    }
}

