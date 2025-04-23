<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
           
        ];

        foreach ($stocks as $stock) {
            DB::table('stock_entries')->insert(array_merge($stock, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
