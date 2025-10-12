<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Services\PenilaianService;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenilaianKelasExport implements FromArray, WithHeadings, ShouldAutoSize
{
    public function __construct(protected Kelas $kelas, protected float $min, protected float $max) {}

    public function array(): array
    {
        $rows = app(PenilaianService::class)->buatBarisEkspor($this->kelas, $this->min, $this->max);
        return $rows;
    }

    public function headings(): array
    {
        return [
            'No', 'Nama', 'Kelas', 'Skor Mentah', 'Skor Normalisasi', 'Tanggal Hafalan Terakhir',
        ];
    }
}