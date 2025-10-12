<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class Hafalan extends Model
{
    use BelongsToTenant;
    protected $guarded = [];
    
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function halaman()
    {
        return $this->belongsTo(Halaman::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'target');
    }
}
