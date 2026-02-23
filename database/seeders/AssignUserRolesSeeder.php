<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AssignUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user and make them an admin
        $firstUser = User::first();
        if ($firstUser && !$firstUser->hasRole('admin')) {
            $firstUser->assignRole('admin');
            $this->command->info("User '{$firstUser->email}' assigned admin role.");
        }

        // Assign 'user' role to all other users without a role
        $usersWithoutRole = User::doesntHave('roles')->get();
        foreach ($usersWithoutRole as $user) {
            $user->assignRole('user');
            $this->command->info("User '{$user->email}' assigned user role.");
        }

        if ($usersWithoutRole->isEmpty() && !$firstUser) {
            $this->command->warn('No users found in the database.');
        }
    }
}

