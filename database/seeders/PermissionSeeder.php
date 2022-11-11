<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $permissions = [
            'submit-kyc',
            'edit-users',
            'edit-kyc',
            'view-kyc',
            'delete-kyc',
            'view-user',
            'delete-user',
//            ''
        ];
    }
}
