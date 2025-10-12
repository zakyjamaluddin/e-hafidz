<?php

namespace App\Services;

use App\Models\Kelas;

class PenilaianService
{
    public function buatBarisEkspor(Kelas $kelas, float $minTarget, float $maxTarget): array
    {
        // ambil siswa + relasi hafalan terakhir + halaman
        $siswas = $kelas->siswa()->with('lastHafalan.halaman')->get();

        // hitung skor mentah per siswa
        $rowsRaw = $siswas->map(function ($s) use ($kelas) {
            return [
                'nama'  => $s->nama ?? '',
                'kelas' => $kelas->kelas ?? '',
                'raw'   => (float) $s->score, // ← langsung pake accessor
                'tanggal_terakhir' => optional($s->lastHafalan)->created_at,
            ];
        });

        // cari min & max mentah (untuk normalisasi min–max)
        $rawMin = $rowsRaw->min('raw') ?? 0.0;
        $rawMax = $rowsRaw->max('raw') ?? 0.0;

        // normalisasi ke rentang [minTarget, maxTarget]
        $rows = [];
        foreach ($rowsRaw->values() as $i => $r) {
            $norm = $this->normalize($r['raw'], $rawMin, $rawMax, $minTarget, $maxTarget);
            $rows[] = [
                'No'        => $i + 1,
                'Nama'      => $r['nama'],
                'Kelas'     => $r['kelas'],
                'Skor Mentah' => round($r['raw'], 2),
                'Skor Normalisasi' => round($norm, 2),
                'Tanggal Hafalan Terakhir' => optional($r['tanggal_terakhir'])->format('Y-m-d H:i:s') ?? '',
            ];
        }

        return $rows;
    }

    private function normalize(float $raw, float $rawMin, float $rawMax, float $minT, float $maxT): float
    {
        if ($rawMax <= $rawMin) {
            // semua nilai sama → taruh di tengah rentang
            return ($minT + $maxT) / 2;
        }
        $val = $minT + ($raw - $rawMin) * ($maxT - $minT) / ($rawMax - $rawMin);
        // jaga-jaga clamp
        return max(min($val, $maxT), $minT);
    }
}
