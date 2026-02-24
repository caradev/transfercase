<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::query()->firstOrCreate(['name' => 'admin']);
        $adminUser = User::query()->where('email', 'nick@cara.dev')->first();

        if ($adminUser) {
            $adminUser->syncRoles([$adminRole->name]);
            $this->command->info("User '{$adminUser->email}' assigned admin role.");
        }

        // Assign 'user' role to all other users without a role
        $usersWithoutRole = User::doesntHave('roles')->get();
        foreach ($usersWithoutRole as $user) {
            $user->assignRole('user');
            $this->command->info("User '{$user->email}' assigned user role.");
        }

        if ($usersWithoutRole->isEmpty() && ! $adminUser) {
            $this->command->warn('No users found in the database.');
        }
    }
}
