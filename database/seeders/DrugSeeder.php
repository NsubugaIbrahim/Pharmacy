<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DrugSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $drugs = [
            ['name' => 'Paracetamol'],
            ['name' => 'Ibuprofen'],
            ['name' => 'Amoxicillin'],
            ['name' => 'Cough Syrup'],
            ['name' => 'Aspirin'],
            ['name' => 'Lisinopril'],
            ['name' => 'Metformin'],
            ['name' => 'Simvastatin'],
            ['name' => 'Omeprazole'],
            ['name' => 'Levothyroxine'],
        ];

        foreach ($drugs as $drug) {
            DB::table('drugs')->insert(array_merge($drug, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
