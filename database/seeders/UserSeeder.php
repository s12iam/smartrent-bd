<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tenant account
        User::create([
            'name'     => 'Test Tenant',
            'email'    => 'tenant@test.com',
            'password' => Hash::make('password'),
            'role'     => 'tenant',
        ]);

        // Owner account
        User::create([
            'name'     => 'Test Owner',
            'email'    => 'owner@test.com',
            'password' => Hash::make('password'),
            'role'     => 'owner',
        ]);
    }
}