<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    protected $kelas_id;
    public function __construct($kelas_id)
    {
        $this->kelas_id = $kelas_id;
    }
    public function model(array $row)
    {

        return new Siswa([
            'nama'  => $row['nama'],
            'panggilan'   => $row['panggilan'],
            'jenis_kelamin'   => $row['jenis_kelamin'],
            'kelas_id'  => $this->kelas_id
        ]);
    }
}
