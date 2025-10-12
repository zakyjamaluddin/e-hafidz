<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaKelas8Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tenant_id' => 1, 'nama' => 'AHMAD HANIFUDIN AZHARI', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Hanif'],
            ['tenant_id' => 1, 'nama' => 'AHMAD RAFA NAUFAL AHSAN', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Rafa'],
            ['tenant_id' => 1, 'nama' => 'ALISA SYAKBANI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Alisa'],
            ['tenant_id' => 1, 'nama' => 'ALIYA SYAKBANI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Aliya'],
            ['tenant_id' => 1, 'nama' => 'ALYA MAHFUDHOTIN AL-MAGHFIROH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Alya'],
            ['tenant_id' => 1, 'nama' => 'ANISA ULLUL AZZMY', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Anisa'],
            ['tenant_id' => 1, 'nama' => 'ASILA QOTRUNNADA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Asila'],
            ['tenant_id' => 1, 'nama' => 'ASWAN FAISAL', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Aswan'],
            ['tenant_id' => 1, 'nama' => 'BILQIS KHOIRUN NISA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Bilqis'],
            ['tenant_id' => 1, 'nama' => 'BIMANTARA NUR ROMADHON', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Bimantara'],
            ['tenant_id' => 1, 'nama' => 'DELFIN DIKA ALFINO', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Delfin'],
            ['tenant_id' => 1, 'nama' => 'ENDHITA MARGARETHA FARHA AUDELSTA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Endhita'],
            ['tenant_id' => 1, 'nama' => 'FELLA FATIMATUL ZAHRA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Fella'],
            ['tenant_id' => 1, 'nama' => 'JESICA CAHAYA PUTRI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Jesica'],
            ['tenant_id' => 1, 'nama' => 'JESIKA DWI RAHMAWATI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Jesika'],
            ['tenant_id' => 1, 'nama' => 'M. IRSYAD AHSAN NURKAIS SAIFUDIN', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Irsyad'],
            ['tenant_id' => 1, 'nama' => 'MAYDA APRILIYA AZZAHRA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Mayda'],
            ['tenant_id' => 1, 'nama' => 'MOCH.AUFAL MAROM BINDA', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Aufal'],
            ['tenant_id' => 1, 'nama' => 'MOCHAMAD ARIYA DHERGA SAKTIAWAN', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Ariya'],
            ['tenant_id' => 1, 'nama' => 'MUAFI NUR FARIHIN', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Muafi'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD FAIZ ASSAFIQ', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Faiz'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD MINANUR ROHMAN', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Minan'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD UMAR SYARIFUDIN', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Umar'],
            ['tenant_id' => 1, 'nama' => 'MUKHAMAD ILHAM MAULANA', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 2, 'panggilan' => 'Ilham'],
            ['tenant_id' => 1, 'nama' => 'NALA SENA MAHARDIKA SUBAGYO', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Nala'],
            ['tenant_id' => 1, 'nama' => 'SELA PUTRI ANGGRAINI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Sela'],
            ['tenant_id' => 1, 'nama' => 'SIKE CAHYA AZZAHRA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Sike'],
            ['tenant_id' => 1, 'nama' => 'SILVIA RAHMAWATI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Silvia'],
            ['tenant_id' => 1, 'nama' => 'SITI MAMLUATUN NASIKHAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Mamlua'],
            ['tenant_id' => 1, 'nama' => 'ZAHIROTUN NIDYA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Zahirotun'],
            ['tenant_id' => 1, 'nama' => 'ZAHROTUL FIRDAUS', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Zahrotul'],
            ['tenant_id' => 1, 'nama' => 'ZAHWA AULA ALFIDA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 2, 'panggilan' => 'Zahwa'],
        ];

        DB::table('siswas')->insert($data);
    }
}
