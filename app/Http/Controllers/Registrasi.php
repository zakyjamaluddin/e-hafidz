<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Registrasi extends Controller
{
    public function index()
    {
        return view('registrasi');
    }

    public function register(Request $request)
    {
        

        try {

            // Validasi input dari form registrasi
        $validatedData = $request->validate([
            'lembaga' => 'required|string|max:255|unique:tenants,name',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);


            // 1. Membuat Tenant baru
            $tenant = Tenant::create([
                'nama' => $validatedData['lembaga'],
                // Tambahkan kolom lain jika ada
            ]);

            // 2. Membuat User baru dengan tenant_id otomatis
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'tenant_id' => $tenant->id, // Mengisi tenant_id secara otomatis
                'role' => 'admin', // Set role awal sebagai admin
            ]);

            // 3. Memberikan peran 'admin' secara default
            // Pastikan peran 'admin' sudah ada di tabel roles (Spatie/Filament Shield)
            
            // Opsional: Langsung login user
            auth()->login($user);
            
            // Redirect ke halaman login admin atau dashboard
            return redirect()->route('filament.admin.pages.dashboard')
                             ->with('notification', 'Pendaftaran berhasil! Silakan masuk.');

        } catch (\Exception $e) {
            // Tangani error, misalnya validasi unik atau DB error
            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal: ' . $e->getMessage());
            // Session::flash('error', 'Pendaftaran gagal: ' . $e->getMessage());
        }

        // Logika pembuatan tenant dan user baru
        // ...

    }
}
