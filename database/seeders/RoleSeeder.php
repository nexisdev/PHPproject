<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Database seeder for roles.
     *
     * @return void
     */
    public function run(): void
    {
        $roles = ['Admin', 'Moderator', 'Investor', 'Verified', 'Unverified', 'Banned'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
