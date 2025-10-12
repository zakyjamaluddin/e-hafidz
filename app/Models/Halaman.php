<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Halaman extends Model
{
    protected $guarded = [];
    protected $table = 'halamans';

    public function hafalan()
    {
        return $this->hasMany(Hafalan::class);
    }
}
