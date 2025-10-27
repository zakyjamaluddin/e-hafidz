<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    public function hafalan()
    {
        return $this->hasMany(Hafalan::class)->latest('created_at');
    }
    // return $this->hasOne(Hafalan::class)->latestOfMany('created_at');

    public function lastHafalan()
    {
        return $this->hasOne(Hafalan::class)
            ->ofMany([
                'halaman_id' => 'max', // Ambil hafalan dengan halaman_id terbesar
            ]);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'target');
    }

    //TODO: Buat method score:
    protected function score(): Attribute
    {
        return Attribute::make(
            get: function () {
                $hafalanTerakhir = $this->lastHafalan()->with('halaman')->first();

                if (! $hafalanTerakhir || ! $hafalanTerakhir->halaman) {
                    return 0;
                }

                $halaman = $hafalanTerakhir->halaman;

                if ($halaman->juz == 30) {
                    // skor: 115 - nomor halaman di juz 30
                    return 115 - $halaman->nomor;
                }

                // selain juz 30 → skor = 37 + nomor
                return 37 + $halaman->nomor;
            }
        );
    }
}
