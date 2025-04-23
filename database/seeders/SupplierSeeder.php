<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->insert([
            ['name' => 'First Pharmacy Uganda Limited', 'contact' => '+256 200901', 'address' => 'Mulago Road', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Joint Medical Stores Limited', 'contact' => '+256 200902', 'address' => 'Nsambya Road', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Renu Pharmacuticals Limited', 'contact' => '+256 200902', 'address' => 'Lumumba Avenue', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
