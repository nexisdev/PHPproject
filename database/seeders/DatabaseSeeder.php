<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $this->call(RoleSeeder::class);
        $this->call(AssignAdminRoleToAdminUserSeeder::class);
        $this->call(SettingSeeder::class);


        // Dummy User
        \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@user.com',
        ])->assignRole('Unverified');

    }
}
