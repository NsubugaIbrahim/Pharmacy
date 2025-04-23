<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'description' => 'Administrator','created_at' => now(), 'updated_at' => now()],
            ['name' => 'pharmacist', 'description' => 'Manager','created_at' => now(), 'updated_at' => now()],
            ['name' => 'medical-assistant', 'description' => 'Medical Assistant','created_at' => now(), 'updated_at' => now()],
            ['name' => 'accountant', 'description' => 'Accountant','created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
