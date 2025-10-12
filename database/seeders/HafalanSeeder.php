<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB as FacadesDB;

class HafalanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hafalan = [
            ['siswa_id' => 1, 'halaman_id' => 45, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 2, 'halaman_id' => 62, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 3, 'halaman_id' => 38, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 4, 'halaman_id' => 54, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 5, 'halaman_id' => 67, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 6, 'halaman_id' => 33, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 7, 'halaman_id' => 60, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 8, 'halaman_id' => 49, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 9, 'halaman_id' => 42, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 10, 'halaman_id' => 65, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 11, 'halaman_id' => 37, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 12, 'halaman_id' => 58, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 13, 'halaman_id' => 31, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 14, 'halaman_id' => 69, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 15, 'halaman_id' => 46, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 16, 'halaman_id' => 53, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 17, 'halaman_id' => 64, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 18, 'halaman_id' => 40, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 19, 'halaman_id' => 57, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 20, 'halaman_id' => 35, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 21, 'halaman_id' => 68, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 22, 'halaman_id' => 50, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 23, 'halaman_id' => 85, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 24, 'halaman_id' => 103, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 25, 'halaman_id' => 76, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 26, 'halaman_id' => 92, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 27, 'halaman_id' => 108, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 28, 'halaman_id' => 80, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 29, 'halaman_id' => 97, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 30, 'halaman_id' => 71, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 31, 'halaman_id' => 105, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 32, 'halaman_id' => 88, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 33, 'halaman_id' => 94, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 34, 'halaman_id' => 77, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 35, 'halaman_id' => 101, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 36, 'halaman_id' => 83, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 37, 'halaman_id' => 109, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 38, 'halaman_id' => 90, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 39, 'halaman_id' => 74, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 40, 'halaman_id' => 98, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 41, 'halaman_id' => 81, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 42, 'halaman_id' => 106, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 43, 'halaman_id' => 93, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 44, 'halaman_id' => 78, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 45, 'halaman_id' => 100, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 46, 'halaman_id' => 86, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 47, 'halaman_id' => 104, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 48, 'halaman_id' => 91, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 49, 'halaman_id' => 75, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 50, 'halaman_id' => 99, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 51, 'halaman_id' => 62, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 52, 'halaman_id' => 134, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 53, 'halaman_id' => 87, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 54, 'halaman_id' => 120, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 55, 'halaman_id' => 73, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 56, 'halaman_id' => 141, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 57, 'halaman_id' => 95, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 58, 'halaman_id' => 112, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 59, 'halaman_id' => 66, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 60, 'halaman_id' => 128, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 61, 'halaman_id' => 80, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 62, 'halaman_id' => 105, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 63, 'halaman_id' => 53, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 64, 'halaman_id' => 137, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 65, 'halaman_id' => 98, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 66, 'halaman_id' => 115, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 67, 'halaman_id' => 70, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 68, 'halaman_id' => 124, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 69, 'halaman_id' => 88, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 70, 'halaman_id' => 130, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 71, 'halaman_id' => 76, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 72, 'halaman_id' => 109, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 73, 'halaman_id' => 64, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 74, 'halaman_id' => 140, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 75, 'halaman_id' => 92, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 76, 'halaman_id' => 119, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru'],
            ['siswa_id' => 77, 'halaman_id' => 81, 'pertemuan' => '2025-07-03', 'nilai' => 90, 'status' => 'baru']
        ];
        FacadesDB::table('hafalans')->insert($hafalan);
    }
}
