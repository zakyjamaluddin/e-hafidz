<?php

use App\Http\Controllers\SimpanHafalan;
use Illuminate\Support\Facades\Route;




Route::post('/simpan-hafalan', [SimpanHafalan::class, 'save']);

