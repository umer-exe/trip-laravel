<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default admin user
        User::firstOrCreate(
            ['email' => 'admin@atlastours.pk'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );

        $this->command->info('✓ Admin user created: admin@atlastours.pk / password123');
    }
}
