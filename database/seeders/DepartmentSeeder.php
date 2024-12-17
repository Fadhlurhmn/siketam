<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            // HQ Departments
            [
                'name' => 'Finance',
                'description' => 'Financial Management Department',
                'region_id' => 1, // Jakarta HQ
            ],
            [
                'name' => 'HR',
                'description' => 'Human Resources Department',
                'region_id' => 1,
            ],
            // Branch Departments
            [
                'name' => 'Operations',
                'description' => 'Branch Operations Department',
                'region_id' => 2, // Sulawesi Branch
            ],
            // Mine Site Departments
            [
                'name' => 'Mining Operations',
                'description' => 'Mining Operations Department',
                'region_id' => 3, // Mine Site A
            ],
            [
                'name' => 'Maintenance',
                'description' => 'Equipment Maintenance Department',
                'region_id' => 3,
            ],
        ];

        DB::table('departments')->insert($departments);
    }
}
