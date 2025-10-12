<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Administrator', 
                'email' => 'admin@gmail.com', 
                'password' => Hash::make('12345678'),
                'role' => 'super_admin',
                'tenant_id' => null
            ],
            [
                'name' => 'Admin Sekolah', 
                'email' => 'admin_sekolah@gmail.com', 
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'tenant_id' => 1,
            ],
        ];

        DB::table('users')->insert($data);

    }
}
