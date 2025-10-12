<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class);
    }
    public function hafalan()
    {
        return $this->hasMany(Hafalan::class);
    }

    /** @return HasMany<\App\Models\Hafalan, self> */
    public function hafalans(): HasMany
    {
        return $this->hasMany(\App\Models\Hafalan::class);
    }


    /** @return HasMany<\App\Models\Siswa, self> */
    public function siswas(): HasMany
    {
        return $this->hasMany(\App\Models\Siswa::class);
    }


    /** @return HasMany<\App\Models\User, self> */
    public function users(): HasMany
    {
        return $this->hasMany(\App\Models\User::class);
    }

}
