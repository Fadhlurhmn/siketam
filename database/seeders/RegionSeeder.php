<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            [
                'name' => 'Jakarta HQ',
                'location_type' => 'HQ',
                'address' => 'Jl. Sudirman No. 123, Jakarta',
            ],
            [
                'name' => 'Sulawesi Branch',
                'location_type' => 'Branch',
                'address' => 'Jl. Malioboro No. 45, Makassar',
            ],
            [
                'name' => 'Mine Site A',
                'location_type' => 'Mine',
                'address' => 'Sorowako, Sulawesi Selatan',
            ],
            [
                'name' => 'Mine Site B',
                'location_type' => 'Mine',
                'address' => 'Morowali, Sulawesi Tengah',
            ],
            // Add more mine sites as needed
        ];

        DB::table('regions')->insert($regions);
    }
}
