<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'nick@cara.dev',
        ], [
            'name' => 'Nick Cara',
            'password' => 'password',
            'email_verified_at' => Carbon::now(),
        ]);

        // Seed roles and permissions
        $this->call([
            RolePermissionSeeder::class,
            AssignUserRolesSeeder::class,
        ]);
    }
}
