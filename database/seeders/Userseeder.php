<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@argon.com',
            'password' => bcrypt('secret'),
            'role_id' => 1
            ]);

        User::create([
            
            'username' => 'krahim',
            'firstname' => 'Kayiwa',
            'lastname' => 'Rahim',
            'email' => 'kayiwarahim@gmail.com',
            'password' => bcrypt('Admin@1234'),
            'role_id' => 1
            ]);
    }
}
