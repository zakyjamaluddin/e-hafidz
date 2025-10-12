<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{

    use BelongsToTenant;

    protected $guarded = [];
    
    public function guru()
    {
        return $this->belongsToMany(User::class, 'guru_kelas');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class); // Jika siswa punya kolom kelas_tahfidz_id
    }

    public function targetHafalan()
    {
        return $this->belongsTo(Halaman::class, 'target');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'target');
    }
}
