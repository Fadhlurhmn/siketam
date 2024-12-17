<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $vehicles = [
            [
                'plate_number' => 'B 1234 ABC',
                'type' => 'passenger',
                'brand' => 'Toyota',
                'model' => 'Innova',
                'ownership_type' => 'owned',
                'capacity' => 7,
                'status' => 'available',
                'region_id' => 1, // Jakarta HQ
            ],
            [
                'plate_number' => 'DD 5678 XY',
                'type' => 'cargo',
                'brand' => 'Mitsubishi',
                'model' => 'Fuso',
                'ownership_type' => 'owned',
                'capacity' => 8000,
                'status' => 'available',
                'region_id' => 2, // Sulawesi Branch
            ],
            [
                'plate_number' => 'DD 9012 ZZ',
                'type' => 'passenger',
                'brand' => 'Toyota',
                'model' => 'Fortuner',
                'ownership_type' => 'rental',
                'capacity' => 7,
                'status' => 'available',
                'region_id' => 3, // Mine Site A
            ],
        ];

        DB::table('vehicles')->insert($vehicles);
    }
}
