<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AppSettingSeeder::class,
            PackageSeeder::class,
            VoucherPricingSeeder::class,
            TechnicianSeeder::class,
            CollectorSeeder::class,
            AgentSeeder::class,
            OdpSeeder::class,
        ]);

        // Create Dummy Customers
        $packages = \App\Models\Package::all();
        
        if ($packages->count() > 0) {
            // Customer 1: Active, Paid
            $c1 = \App\Models\Customer::create([
                'name' => 'Ahmad Customer',
                'username' => 'ahmad123',
                'phone' => '081299887766',
                'email' => 'ahmad@gmail.com',
                'address' => 'Jl. Merdeka No. 45',
                'package_id' => $packages->first()->id,
                'status' => 'active',
                'join_date' => now()->subMonths(3),
            ]);

            // Invoice for C1
            \App\Models\Invoice::create([
                'invoice_number' => 'INV-000001',
                'customer_id' => $c1->id,
                'package_id' => $c1->package_id,
                'amount' => $packages->first()->price,
                'status' => 'paid',
                'invoice_type' => 'monthly',
                'created_at' => now()->subMonth(),
                'paid_date' => now()->subMonth()->addDays(2),
            ]);

            // Customer 2: Active, Unpaid
            $c2 = \App\Models\Customer::create([
                'name' => 'Bambang User',
                'username' => 'bambang_net',
                'phone' => '081255443322',
                'email' => 'bambang@yahoo.com',
                'address' => 'Jl. Sudirman Kav. 10',
                'package_id' => $packages->last()->id,
                'status' => 'active',
                'join_date' => now()->subMonth(),
            ]);

            // Invoice for C2
            \App\Models\Invoice::create([
                'invoice_number' => 'INV-000002',
                'customer_id' => $c2->id,
                'package_id' => $c2->package_id,
                'amount' => $packages->last()->price,
                'status' => 'unpaid',
                'invoice_type' => 'monthly',
                'created_at' => now()->subDays(5),
                'due_date' => now()->addDays(2),
            ]);
        }
    }
}
