<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaKelas9Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['tenant_id' => 1, 'nama' => 'ABDUL KHARIS AL FARISI', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Haris'],
            ['tenant_id' => 1, 'nama' => 'AHMAD ANANDA PUTRA', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Ahmad'],
            ['tenant_id' => 1, 'nama' => 'AISYA TSURAYA AZZAHRA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Aisya'],
            ['tenant_id' => 1, 'nama' => 'AMBAR ILKHANI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Ambar'],
            ['tenant_id' => 1, 'nama' => 'ARINA NAURA ZAHIRA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Arina'],
            ['tenant_id' => 1, 'nama' => 'DEWI AYATUL HUSNA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Dewi'],
            ['tenant_id' => 1, 'nama' => 'ILHAM MAULANA ADITYA', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Ilham'],
            ['tenant_id' => 1, 'nama' => 'LAILA AULIA RAHMA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Laila'],
            ['tenant_id' => 1, 'nama' => 'LIVIA NUR AZIZAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Livia'],
            ['tenant_id' => 1, 'nama' => 'LU\'LUUL ULYA RAHMA DINI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Lulu'],
            ['tenant_id' => 1, 'nama' => 'LUSI FITRI PRIHATININGSIH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Lusi'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD AKMAL JAZILUL KHOIR', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Akmal'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD FAIQ AS SA`DY', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Faiq'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD NUR IBNU JULIAN', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Julian'],
            ['tenant_id' => 1, 'nama' => 'MUHAMMAD SIFA`UL UMAM', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Umam'],
            ['tenant_id' => 1, 'nama' => 'NAYDA SYAFA`ATUR ROHMAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Nayda'],
            ['tenant_id' => 1, 'nama' => 'NIKIFA AMALIA SAFITRI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Nikifa'],
            ['tenant_id' => 1, 'nama' => 'QONITA ROFI`ATUL MUNA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Qonita'],
            ['tenant_id' => 1, 'nama' => 'RAHMA NAYLA HASANAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Rahma'],
            ['tenant_id' => 1, 'nama' => 'SASILA KHOIRIL HIDAYAH', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Sasila'],
            ['tenant_id' => 1, 'nama' => 'TOTOK SUGIHARTO', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Totok'],
            ['tenant_id' => 1, 'nama' => 'ULLIL ABZAR RIZQI', 'jenis_kelamin' => 'Laki-laki', 'kelas_id' => 3, 'panggilan' => 'Abzar'],
            ['tenant_id' => 1, 'nama' => 'ZAHROTUS SYIFA', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Syifa'],
            ['tenant_id' => 1, 'nama' => 'ZAKIA AULIA RAMADHANI', 'jenis_kelamin' => 'Perempuan', 'kelas_id' => 3, 'panggilan' => 'Zakia'],
        ];

        DB::table('siswas')->insert($data);
    }
}
