<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TenantSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(KelasSeeder::class);
        $this->call(GuruKelasSeeder::class);
        // $this->call(SiswaKelas7Seeder::class);
        // $this->call(SiswaKelas8Seeder::class);
        // $this->call(SiswaKelas9Seeder::class);
        $this->call(HalamanSeeder::class);
        // $this->call(HafalanSeeder::class);

    }
}
