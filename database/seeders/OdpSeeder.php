<?php

namespace Database\Seeders;

use App\Models\Odp;
use Illuminate\Database\Seeder;

class OdpSeeder extends Seeder
{
    public function run(): void
    {
        $odps = [
            [
                'name' => 'ODP-JKT-001',
                'code' => 'ODP-001',
                'location_name' => 'Tiang Listrik Depan Indomaret',
                'latitude' => -6.175110,
                'longitude' => 106.865036,
                'capacity' => 16,
                'available_ports' => 12,
                'status' => 'active',
            ],
            [
                'name' => 'ODP-JKT-002',
                'code' => 'ODP-002',
                'location_name' => 'Pertigaan Jl. Mawar',
                'latitude' => -6.176110,
                'longitude' => 106.866036,
                'capacity' => 8,
                'available_ports' => 2,
                'status' => 'active',
            ],
            [
                'name' => 'ODP-JKT-003',
                'code' => 'ODP-003',
                'location_name' => 'Depan Masjid Al-Huda',
                'latitude' => -6.177110,
                'longitude' => 106.867036,
                'capacity' => 16,
                'available_ports' => 0,
                'status' => 'full',
            ],
        ];

        foreach ($odps as $odp) {
            Odp::create($odp);
        }
    }
}
