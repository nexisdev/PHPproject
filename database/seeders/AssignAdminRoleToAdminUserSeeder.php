<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AssignAdminRoleToAdminUserSeeder extends Seeder
{
    private const ADMIN_ROLE = 'Admin';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password')
        ]);

        $user->assignRole(self::ADMIN_ROLE);
    }
}
