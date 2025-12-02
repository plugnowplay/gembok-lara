<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherPricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pricings = [
            [
                'package_name' => '3K',
                'customer_price' => 3000,
                'agent_price' => 2000,
                'commission_amount' => 1000,
                'duration' => 24,
                'description' => 'Voucher 3K - 24 jam',
                'is_active' => true,
            ],
            [
                'package_name' => '5K',
                'customer_price' => 5000,
                'agent_price' => 3500,
                'commission_amount' => 1500,
                'duration' => 24,
                'description' => 'Voucher 5K - 24 jam',
                'is_active' => true,
            ],
            [
                'package_name' => '10K',
                'customer_price' => 10000,
                'agent_price' => 8000,
                'commission_amount' => 2000,
                'duration' => 24,
                'description' => 'Voucher 10K - 24 jam',
                'is_active' => true,
            ],
            [
                'package_name' => '20K',
                'customer_price' => 20000,
                'agent_price' => 16000,
                'commission_amount' => 4000,
                'duration' => 24,
                'description' => 'Voucher 20K - 24 jam',
                'is_active' => true,
            ],
            [
                'package_name' => '50K',
                'customer_price' => 50000,
                'agent_price' => 40000,
                'commission_amount' => 10000,
                'duration' => 24,
                'description' => 'Voucher 50K - 24 jam',
                'is_active' => true,
            ],
        ];

        foreach ($pricings as $pricing) {
            \App\Models\VoucherPricing::create($pricing);
        }
    }
}
