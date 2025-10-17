<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@fieldengineer.pro',
            'password' => Hash::make('admin123!'),  // You should change this password after first login
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Output a message to the console
        $this->command->info('Admin user created with email: admin@fieldengineer.pro and password: admin123!');
        $this->command->warn('Please change the password after your first login!');
    }
}