<?php

namespace App\Filament\Resources\HafalanResource\Pages;

use App\Models\Siswa;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\HafalanResource;

use App\Models\Hafalan;
// use App\Models\Siswa;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Forms\Concerns\InteractsWithForms as InputFormTrait;
use Filament\Forms\Contracts\HasForms;
// use Filament\Pages\Page;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;

class SimakHafalan extends Page implements HasForms
{
    protected static string $resource = HafalanResource::class;

    protected static string $view = 'filament.resources.hafalan-resource.pages.simak-hafalan';

     public Siswa $record;

    
    use InteractsWithForms;
    use InputFormTrait {
        // Alias semua method trait untuk form kedua (Input Nilai)
        makeForm as makeInputForm;
        getForm as getInputForm;
        // mountForms as mountInputForms;
        // callFormFieldAction as callInputFormFieldAction;
        // callFormFieldData as callInputFormFieldData;
        // validateForms as validateInputForms;
    }
    
    // Properti Public untuk State Component
    public $siswaId;
    public $halamanSaatIni; // ID halaman yang sedang ditampilkan
    public $nomorHalamanSaatIni; // Nomor halaman (page number) yang sedang ditampilkan
    public $juzSaatIni;


    // 2. Properti untuk menyimpan data form. Inisiasi awal di sini.
    public array $selectionData = [
        'juz' => null,
        'halaman' => null,
    ];

    // 3. State untuk INPUT FORM (Nilai Simak, Catatan)
    public array $inputData = [
        'nilai_simak' => null,
        'catatan' => null,
        'tanggal_simak' => null,
    ];

    public $ayahs = []; // Data ayat dari API
    public $siswa;

    protected Form $inputForm;

    // State untuk Form Hafalan
    public $nilai;
    public $selanjutnya;
    public $status;

    
    // Properti Wajib Filament Page
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $slug = 'hafalan/{siswaId}'; // Gunakan slug dengan parameter
    
    // protected static function shouldRegisterNavigation(): bool
    // {
    //     return false; // Sembunyikan dari navigasi utama
    // }

    public function mount(int $siswaId): void
    {
        $this->siswaId = $siswaId;
        $this->siswa = Siswa::find($siswaId);
        

        if (!$this->siswa) {
            abort(404);
        }

        $this->loadHafalanAwal();
        
        $this->selectionData['juz'] = $this->juzSaatIni;
        $this->form->fill($this->selectionData);

        // 2. Inisialisasi Input Form (Aliased)
        $this->mountInputForms();
        $this->inputForm->fill($this->inputData);
    }
    
    // Logika untuk menentukan hafalan awal
    protected function loadHafalanAwal()
    {
        // Ambil data hafalan terakhir
        $lastHafalan = $this->siswa->hafalan()
                            ->latest('created_at')
                            ->first();

        $halaman = optional($lastHafalan)->halaman;
        $selanjutnya = optional($lastHafalan)->selanjutnya;

        if ($halaman) {
            if ($selanjutnya === 'mengulang') {
                $this->halamanSaatIni = $halaman->id;
                $this->nomorHalamanSaatIni = $halaman->nomor;
                $this->juzSaatIni = $halaman->juz;
                // dd($this->halamanSaatIni, $this->nomorHalamanSaatIni, $this->juzSaatIni);
            } elseif ($selanjutnya === 'melanjutkan') {
                // Asumsi ID halaman berurutan. Cari halaman berikutnya
                $nextHalaman = \App\Models\Halaman::where('id', $halaman->id + 1)->first();
                if ($nextHalaman) {
                    $this->halamanSaatIni = $nextHalaman->id;
                    $this->nomorHalamanSaatIni = $nextHalaman->nomor;
                    $this->juzSaatIni = $nextHalaman->juz;
                } else {
                    // Jika tidak ada halaman berikutnya (mungkin sudah selesai atau halaman terakhir)
                    // Set ke halaman terakhir atau halaman 1 (contoh)
                    $this->halamanSaatIni = $halaman->id;
                    $this->nomorHalamanSaatIni = $halaman->nomor;
                    $this->juzSaatIni = $halaman->juz;
                }
            }
        } else {
            // Jika belum ada hafalan, set default ke halaman 1 (atau surah An-Nas, dll)
            $defaultHalaman = \App\Models\Halaman::where('nomor', 1)->first();
            if ($defaultHalaman) {
                $this->halamanSaatIni = $defaultHalaman->id;
                $this->nomorHalamanSaatIni = $defaultHalaman->nomor;
                $this->juzSaatIni = $defaultHalaman->juz;
            } else {
                // Default fallback jika tabel halaman kosong
                $this->halamanSaatIni = 1;
                $this->nomorHalamanSaatIni = 1; 
                $this->juzSaatIni = 1;
            }
        }

        $this->data['juz'] = $this->juzSaatIni;
        $this->form->fill($this->data);
        
        $this->fetchAyat();
    }

    // Mengambil data ayat dari API
    public function fetchAyat()
    {
        // Sesuaikan logika pengambilan API berdasarkan nomor halaman (nomorHalamanSaatIni)
        // Logika API Juz 30 (Surah by Number) dan Juz Lain (Page by Number)
        // Perlu penyesuaian yang lebih akurat untuk penentuan surah/page number. 
        // Karena kode Anda sebelumnya menggunakan nomor halaman untuk page, kita akan ikuti itu.

        $page = $this->nomorHalamanSaatIni; // Nomor halaman 1-604
        
        // Logika API untuk halaman per Qur'an (lebih umum)
        $response = Http::get("https://api.alquran.cloud/v1/page/{$page}/quran-uthmani");
        
        if ($response->successful()) {
            $this->ayahs = $response->json('data.ayahs');
        } else {
            $this->ayahs = [];
        }
    }
    
    // Definisikan instance Form Input
    protected function getInputForm(): Form
    {
        // Panggil makeInputForm() (alias dari makeForm) dan gunakan statePath yang berbeda
        return $this->makeInputForm()
            ->schema($this->getInputFormSchema())
            ->statePath('inputData'); // PENTING: Hubungkan ke properti $inputData
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('juz')
                ->label('Pilih Juz')
                // Menggunakan 'selectionData.juz' di belakang layar
                ->options(function () {
                    $juzRange = range(1, 30);
                    return array_combine($juzRange, array_map(fn($i) => "Juz $i", $juzRange));
                })
                ->reactive()
                ->afterStateUpdated(function (callable $set) {
                    $set('halaman', null);
                })
                ->searchable()
                ->required(),

            Select::make('halaman')
                ->label('Pilih Halaman')
                // Menggunakan 'selectionData.halaman' di belakang layar
                ->options(function (callable $get) {
                    $juz = $get('juz');
                    if (!$juz) return [];

                    // --- Logika Halaman ---
                    if ($juz == 1) {
                        $start = 1; $end = 21;
                    } elseif ($juz == 30) {
                        $start = 582; $end = 604;
                    } else {
                        $start = (($juz - 1) * 20) + 2; $end = ($juz * 20) + 1;
                    }
                    
                    $halamanRange = range($start, $end);
                    return array_combine($halamanRange, $halamanRange);
                })
                ->hidden(fn (callable $get) => $get('juz') === null)
                ->searchable()
                ->required(),
        ];
    }

    // Metode untuk skema FORM INPUT (Nilai Simak) - Menggunakan nama baru
    protected function getInputFormSchema(): array
    {
        return [
            TextInput::make('nilai_simak')
                ->label('Nilai Simak (0-100)')
                ->numeric()
                ->minValue(0)
                ->maxValue(100)
                ->required(),

        ];
    }
    
    protected function getSelectFormSchema(): array
    {
        return [
            Select::make('juz')
                ->label('Pilih Juz')
                ->options(function () {
                    $juzRange = range(1, 30);
                    // Buat array [1 => "Juz 1", 2 => "Juz 2", ...]
                    return array_combine($juzRange, array_map(fn($i) => "Juz $i", $juzRange));
                })
                ->reactive() // INI PENTING: Memicu update field lain
                ->afterStateUpdated(function (callable $set) {
                    // Reset 'halaman' setiap kali 'juz' berubah
                    $set('halaman', null);
                })
                ->searchable() // Tambahan opsional: agar juz bisa dicari
                ->required(),

            Select::make('halaman')
                ->label('Pilih Halaman')
                // Opsi akan di-load secara dinamis berdasarkan 'juz'
                ->options(function (callable $get) {
                    $juz = $get('juz');

                    // Jika 'juz' belum dipilih, jangan tampilkan opsi
                    if (!$juz) {
                        return [];
                    }

                    // --- Logika Halaman ---
                    if ($juz == 1) {
                        // Juz 1: halaman 1 s/d 21 (sesuai deskripsi Anda)
                        $start = 1;
                        $end = 21;
                    } elseif ($juz == 30) {
                        // Juz 30: halaman 582 s/d 604 (23 halaman)
                        $start = 582;
                        $end = 604;
                    } else {
                        // Juz 2-29: 20 halaman per juz
                        // Rumus ini didasarkan pada Juz 1 (21 hlm) + Juz 2-29 (20 hlm)
                        $start = (($juz - 1) * 20) + 2;
                        $end = ($juz * 20) + 1;
                    }
                    // --- Akhir Logika Halaman ---

                    if ($start > $end) return []; // Jaga-jaga jika ada error logika

                    $halamanRange = range($start, $end);
                    // Buat array [22 => 22, 23 => 23, ...]
                    return array_combine($halamanRange, $halamanRange);
                })
                // --- INI PERBAIKANNYA ---
                // Sembunyikan field ini jika 'juz' (state 'juz') masih kosong (null)
                // Ini akan membuatnya "muncul" setelah juz dipilih.
                ->hidden(fn (callable $get) => $get('juz') === null)
                
                // Alternatif:
                // ->disabled(fn (callable $get) => $get('juz') === null) // Field-nya terlihat tapi nonaktif

                ->searchable() // Tambahan opsional: agar halaman bisa dicari
                ->required(),
                
                // Anda tidak perlu ->reactive() pada field 'halaman'
                // kecuali ada field KETIGA yang bergantung padanya.
        ];
    }

    protected function getSelectForm(): Form
{
    // ✅ Menggunakan $this->makeForm() untuk membuat objek Form
    return $this->makeForm()
        ->schema($this->getSelectFormSchema())
        ->statePath('dataSelect')
        ->columns(2);
}
    
    // Aksi Submit Form
    public function submitHafalan()
    {
        $data = $this->form->getState();

        // Pastikan halaman yang sedang ditampilkan valid
        if (!$this->halamanSaatIni) {
             Notification::make()
                ->title('Gagal menyimpan!')
                ->body('Halaman Al-Qur\'an tidak terdefinisi.')
                ->danger()
                ->send();
            return;
        }

        // Simpan data ke database
        Hafalan::create([
            'siswa_id' => $this->siswaId,
            'halaman_id' => $this->halamanSaatIni, // Ambil dari halaman yang sedang ditampilkan
            'nilai' => $data['nilai'],
            'status' => $data['status'],
            'selanjutnya' => $data['selanjutnya'],
            'user_id' => Auth::user()->id,
            'pertemuan' => now(),
        ]);

        Notification::make()
            ->title('Hafalan disimpan')
            ->body("Hafalan {$this->siswa->nama} (Halaman {$this->nomorHalamanSaatIni}) berhasil disimpan.")
            ->success()
            ->send();
            
        // Reset form setelah simpan
        $this->form->fill(); 
        
        // Opsional: Langsung pindah ke halaman berikutnya setelah simpan
        // $this->nextHalaman(); 
    }
    
    // Aksi Navigasi Halaman Sebelumnya
    public function prevHalaman()
    {
        $currentHalaman = \App\Models\Halaman::find($this->halamanSaatIni);
        if ($currentHalaman && $currentHalaman->id > 1) {
            $prevHalaman = \App\Models\Halaman::where('id', $currentHalaman->id - 1)->first();
            if ($prevHalaman) {
                $this->halamanSaatIni = $prevHalaman->id;
                $this->nomorHalamanSaatIni = $prevHalaman->nomor;
                $this->juzSaatIni = $prevHalaman->juz;
                $this->fetchAyat();
            }
        }
    }

    // Aksi Navigasi Halaman Berikutnya
    public function nextHalaman()
    {
        $currentHalaman = \App\Models\Halaman::find($this->halamanSaatIni);
        if ($currentHalaman) {
            $nextHalaman = \App\Models\Halaman::where('id', $currentHalaman->id + 1)->first();
            if ($nextHalaman) {
                $this->halamanSaatIni = $nextHalaman->id;
                $this->nomorHalamanSaatIni = $nextHalaman->nomor;
                $this->juzSaatIni = $nextHalaman->juz;
                $this->fetchAyat();
            }
        }
    }
}

