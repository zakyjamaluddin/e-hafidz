<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'kelas' => 7,
                'tenant_id' => 1,  
            ],
            [
                'kelas' => 8,
                'tenant_id' => 1,  
            ],
            [
                'kelas' => 9,
                'tenant_id' => 1,  
            ],
        ];

        DB::table('kelas')->insert($data);
    }
}
