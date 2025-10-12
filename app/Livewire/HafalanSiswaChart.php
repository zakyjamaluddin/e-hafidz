<?php

namespace App\Livewire;

use App\Models\Siswa;
use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Support\Str;

class HafalanSiswaChart extends ChartWidget
{
    // protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '800px';
    public ?string $kelasId = null;

    public static function make(array $properties = []): WidgetConfiguration
    {
        return parent::make([
            'kelasId' => $properties['kelas_id'] ?? null,
        ]);
    }

    public function getHeading(): ?string
    {
        $kelas = \App\Models\Kelas::find($this->kelasId);
        return 'Progress Hafalan - Kelas ' . ($kelas->kelas ?? 'Tidak Diketahui');

    }

    protected function getData(): array
    {
        $siswaList = Siswa::where('kelas_id', $this->kelasId)->with(['hafalan' => function ($query) {
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

            return [$siswa->panggilan => $skor];
        });

        // dd($skorPerSiswa);

        return [
            'datasets' => [
                [
                    'label' => 'Skor Hafalan',
                    'data' => $skorPerSiswa->values(),
                ],
            ],
            'labels' => $skorPerSiswa->keys()->map(function ($nama) {
                return Str::limit($nama, 15); // maksimal 15 karakter
            })->toArray(),
        ];
    }

    protected function getOptions(): RawJs|array
    {

        return [
            'indexAxis' => 'x', // Bar horizontal
            'responsive' => true,
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks' => [
                            'autoSkip' => false, // Menonaktifkan autoSkip label
                            'maxRotation' => 90,
                            'minRotation' => 90,
                            'font'=> [
                                'size' => 7 // ukuran font label Y (opsional)
                            ]
                        ],
                ],
            ],
        ];
    }


    protected function getType(): string
    {
        return 'bar';
    }
}
