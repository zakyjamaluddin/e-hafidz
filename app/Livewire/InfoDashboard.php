<?php

namespace App\Livewire;

use App\Models\Hafalan;
use App\Models\Kelas;
use App\Models\Siswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InfoDashboard extends BaseWidget
{
    protected function getStats(): array
    {

        $stats = [];
        foreach (Kelas::all() as $kelas) {
        $kelasId = 2; // misal

        $siswaIds = Siswa::where('kelas_id', $kelas->id)->pluck('id');


        // Ambil hafalan terakhir tiap siswa
        $latestHafalans = Hafalan::whereIn('siswa_id', $siswaIds)
            ->selectRaw('MAX(id) as id') // diasumsikan id auto-increment, jadi terbesar = terbaru
            ->groupBy('siswa_id')
            ->pluck('id');


        if($kelas->targetHafalan) {
            $target = optional($kelas->targetHafalan);
            if ($target->juz == 30) {
                $skorTarget = (115 - $target->nomor);
            } else {
                $skorTarget = (37 + $target->nomor);
            }
            $totalSkor = Hafalan::with('halaman')
                ->whereIn('id', $latestHafalans)
                ->get()
                ->sum(function ($hafalan) use ($skorTarget) {
                    if ($hafalan->halaman->juz == 30) {
                        // Misalnya halaman punya kolom 'surah_urutan_juz30' (1 untuk An-Nas dst)
                        $skor = 115 - $hafalan->halaman->nomor;
                    } else {
                        // Tambah 37 agar kelanjutan dari juz 30
                        $skor = 37 + $hafalan->halaman->nomor;
                    }
                    // return $hafalan->halaman->nomor ?? 0;
                    if($skor > $skorTarget) {
                        return $skorTarget;
                    };
                    return $skor ?? 0;
                });
            $pembagi = $skorTarget * $kelas->siswa->count();
            $persentase = $pembagi > 0
                ? ($totalSkor / $pembagi) * 100
                : 0;
        }
        else {
            $persentase = 0;
        }
        
        



        
            $stats[] = 
            Stat::make('Capaian Target Kelas ' .$kelas->kelas, number_format($persentase, 2) . ' %')
            ->description('Target : Juz ' . optional($kelas->targetHafalan)->juz . ' - ' . optional($kelas->targetHafalan)->nama)
            ->descriptionIcon('heroicon-m-cursor-arrow-rays', position: 'before')
            ->color('success');
        }
        return $stats;
    }
}
