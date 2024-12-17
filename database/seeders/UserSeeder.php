<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'username' => 'driver1',
                'name' => 'John Driver',
                'email' => 'driver1@example.com',
                'password' => Hash::make('password'),
                'role' => 'driver',
                'department_id' => 3, // Operations
                'region_id' => 2, // Sulawesi Branch
            ],
            [
                'username' => 'supervisor1',
                'name' => 'Jane Supervisor',
                'email' => 'supervisor1@example.com',
                'password' => Hash::make('password'),
                'role' => 'supervisor_driver',
                'department_id' => 3,
                'region_id' => 2,
            ],
            [
                'username' => 'admin1',
                'name' => 'Admin Vehicle',
                'email' => 'admin1@example.com',
                'password' => Hash::make('password'),
                'role' => 'vehicle_admin',
                'department_id' => 3,
                'region_id' => 2,
            ],
        ];

        DB::table('users')->insert($users);
    }
}
