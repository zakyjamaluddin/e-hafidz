<?php

namespace App\Livewire;

use App\Models\Siswa;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

class HafalanSiswaChartCustom extends Widget
{
    public $labels;
    public $data;


    protected static string $view = 'livewire.hafalan-siswa-chart-custom';
    public function mount(): void
    {
        $siswaList = Siswa::with(['hafalan' => function ($query) {
            $query->latest('created_at')->with('halaman');
        }])->get();

        $skorPerSiswa = $siswaList->mapWithKeys(function ($siswa) {
            $hafalanTerakhir = $siswa->hafalan->first(); // paling baru
            $skor = 0;

            if ($hafalanTerakhir && $hafalanTerakhir->halaman) {
                $halaman = $hafalanTerakhir->halaman;

                if ($halaman->juz == 30) {
                    // Misalnya halaman punya kolom 'surah_urutan_juz30' (1 untuk An-Nas dst)
                    $skor = 115 - $halaman->nomor;
                } else {
                    // Tambah 37 agar kelanjutan dari juz 30
                    $skor = 37 + $halaman->nomor;
                }
            }

            return [$siswa->nama => $skor];
        });


        $this->labels = $skorPerSiswa->keys()->map(function ($nama) {
                return Str::limit($nama, 15); // maksimal 15 karakter
            })->toArray();
        $this->data = $skorPerSiswa->values();


    }
}
