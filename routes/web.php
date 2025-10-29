<?php

use App\Http\Controllers\Registrasi;
use Illuminate\Support\Facades\Route;
use App\Livewire\TenantRegistrationForm; // Nama class yang akan dibuat

Route::get('/F8hLp7wQzK9A', [Registrasi::class, 'index']);
Route::get('/great', [Registrasi::class, 'great']);
Route::post('/F8hLp7wQzK9A', [Registrasi::class, 'register']);

Route::get('/', function () {
    return redirect('/admin/dashboard');
});

