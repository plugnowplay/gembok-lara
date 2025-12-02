<?php

namespace Database\Seeders;

use App\Models\Agent;
use Illuminate\Database\Seeder;

class AgentSeeder extends Seeder
{
    public function run(): void
    {
        $agents = [
            [
                'name' => 'Warung Berkah',
                'phone' => '083134567890',
                'email' => 'berkah@agent.com',
                'address' => 'Jl. Kebon Jeruk No. 12',
                'balance' => 500000,
                'status' => 'active',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Counter Pulsa Jaya',
                'phone' => '083134567891',
                'email' => 'jaya@agent.com',
                'address' => 'Jl. Raya Bogor KM 25',
                'balance' => 150000,
                'status' => 'active',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($agents as $agent) {
            Agent::create($agent);
        }
    }
}
