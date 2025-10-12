<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaKelas7Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tenant_id' => 1, 'nama' => 'AHMAD FIKRY AZMI', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 1, 'panggilan' => 'Fikry'],
            ['tenant_id' => 1, 'nama' => 'AHMAD SYAUQI AL FAWWAZ', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 1, 'panggilan' => 'Syauqi'],
            ['tenant_id' => 1, 'nama' => 'AINUN AULIA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Ainun'],
            ['tenant_id' => 1, 'nama' => 'AINUN BAROTUT TAQIYAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Ainun'],
            ['tenant_id' => 1, 'nama' => 'AINUN NAFISA SIDNI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Ainun'],
            ['tenant_id' => 1, 'nama' => 'ANA ROHMATUS TSANI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Ana'],
            ['tenant_id' => 1, 'nama' => 'CHURIN\'IN SIDQIA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Churin'],
            ['tenant_id' => 1, 'nama' => 'DWI SRI WAHYU NINGSIH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Dwi'],
            ['tenant_id' => 1, 'nama' => 'ELOK ZAHWA MARJUA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Elok'],
            ['tenant_id' => 1, 'nama' => 'FAIRUZ YHUANA AUCHA MOSIHA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Fairuz'],
            ['tenant_id' => 1, 'nama' => 'ITHMA ANNA MAHYA KHILDA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Ithma'],
            ['tenant_id' => 1, 'nama' => 'KARUNIA DWI NURUL RAMADHANI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Karunia'],
            ['tenant_id' => 1, 'nama' => 'M. DANI MUSTOFA', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 1, 'panggilan' => 'Dani'],
            ['tenant_id' => 1, 'nama' => 'MIFTHAKUL KHASANAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Mifthakul'],
            ['tenant_id' => 1, 'nama' => 'MOCH. REYHAN ARKA NAUFAL', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 1, 'panggilan' => 'Reyhan'],
            ['tenant_id' => 1, 'nama' => 'MUCHAMMAD FAHMI HIDAYATULLAH', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 1, 'panggilan' => 'Fahmi'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD NAUFAL ALTAF ASSAYGHONI', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 1, 'panggilan' => 'Naufal'],
            ['tenant_id' => 1, 'nama' => 'NIZAM MAULANA BACHTIAR', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 1, 'panggilan' => 'Nizam'],
            ['tenant_id' => 1, 'nama' => 'NUR YAHYA EKA APRILIA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Yahya'],
            ['tenant_id' => 1, 'nama' => 'QURROTUL \'AINI MANSHUROH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Qurrotul'],
            ['tenant_id' => 1, 'nama' => 'SAHRUNI ALFIYATUL QOMARIYAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Sahruni'],
            ['tenant_id' => 1, 'nama' => 'SHINTA KARIMATUL', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Shinta'],
            ['tenant_id' => 1, 'nama' => 'SITI HANIFAH AZZAHRO', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 1, 'panggilan' => 'Hanifah'],
        ];
        

        DB::table('siswas')->insert($data);
    }
}
