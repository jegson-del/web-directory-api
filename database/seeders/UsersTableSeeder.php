<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create users
        User::factory()->count(10)->create()->each(function ($user) {
            // Assign a random role to each user
            $role = Role::inRandomOrder()->first();
            $user->roles()->attach($role->id);
        });

        // Assign specific roles to specific users if needed
        $adminRole = Role::where('name', 'admin')->first();
        $userRole = Role::where('name', 'user')->first();

        User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ])->roles()->attach($adminRole);

        User::factory()->create([
                'name' => 'Normal User',
                'email' => 'user@example.com',
                'password' => bcrypt('password'),
            ])->roles()->attach($userRole);
    }
}
