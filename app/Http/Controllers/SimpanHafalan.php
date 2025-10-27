<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SimpanHafalan extends Controller
{
    public function save(Request $request)
    {
        return response()->json(['message' => 'Hafalan berhasil disimpan'], 201);

        // Validasi data yang diterima
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'halaman' => 'required|integer',
            'ayat' => 'required|integer',
            'tanggal' => 'required|date',
        ]);

        // Simpan data hafalan ke database (contoh menggunakan model Hafalan)
        $hafalan = new \App\Models\Hafalan();
        $hafalan->user_id = $validatedData['user_id'];
        $hafalan->surah = $validatedData['surah'];
        $hafalan->ayat = $validatedData['ayat'];
        $hafalan->tanggal = $validatedData['tanggal'];
        $hafalan->save();

        // Kembalikan respons sukses
    }
}
