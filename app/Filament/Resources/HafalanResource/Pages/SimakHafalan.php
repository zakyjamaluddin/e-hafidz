<?php

namespace App\Filament\Resources\HafalanResource\Pages;

use App\Models\Siswa;
use App\Models\Halaman;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use App\Filament\Resources\HafalanResource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;

class SimakHafalan extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = HafalanResource::class;

    protected static string $view = 'filament.resources.hafalan-resource.pages.simak-hafalan';

    protected static ?string $title = 'Simak Hafalan';

    public ?array $data = [];
    public ?Siswa $siswa;
    public $ayahs = []; // Data ayat dari API
    public $siswaId;
    public $halamanSaatIni; // ID halaman yang sedang ditampilkan
    public $nomorHalamanSaatIni; // Nomor halaman (page number) yang sedang ditampilkan
    public $juzSaatIni;


    public ?array $dataFormSatu = [];
    public ?array $dataFormDua = [];



    public function mount($record): void
    {
        $this->siswa = Siswa::find($record);
        $this->loadHafalanAwal();
        // $this->form->fill();
        $this->formSatu->fill();
        $this->formDua->fill();
    }

    public function getFormSatuForm(): Form
    {
        return $this->makeForm()
            ->schema([
                Grid::make()->columns(2)->schema([
                    Select::make('juz')
                        ->label('Juz')
                        ->options(
                            \App\Models\Halaman::query()
                                ->select('juz')
                                ->distinct()
                                ->orderBy('juz')
                                ->pluck('juz', 'juz') // key = value = juz
                                ->toArray()
                        )
                        ->reactive() // penting, supaya select halaman tahu nilai Juz berubah
                        ->afterStateUpdated(fn ($state, callable $set) => $set('halaman', null))
                        ->default(function () {
                            $record = $this->siswa;
                            $lastHalamanJuz = optional(optional($record->hafalan[0] ?? null)->halaman)->juz;
                            $lastHalamanNomor = optional(optional($record->hafalan[0] ?? null)->halaman)->nomor;
                            $selanjutnya = optional(optional($record->hafalan[0] ?? null))->selanjutnya;
                            // dd($lastHalamanJuz, $lastHalamanNomor, $selanjutnya);
                            if($selanjutnya == 'mengulang') {
                                return $lastHalamanJuz;
                            } 
                            if($selanjutnya == 'melanjutkan') {
                                if(($lastHalamanNomor - 1) % 20 == 0  && $lastHalamanNomor != 1) {
                                    return $lastHalamanJuz ? $lastHalamanJuz + 1 : 1;
                                } else {
                                    return $lastHalamanJuz ? $lastHalamanJuz : 1;
                                }
                            }                                        
                        }),
    
                    Select::make('halaman')
                        ->label('Halaman')
                        ->required()
                        ->searchable()
                        ->reactive()
                        ->options(function (callable $get) {
                            $juz = $get('juz');
                            if (!$juz) {
                                return [];
                            }
                            return \App\Models\Halaman::where('juz', $juz)
                        ->orderBy('nomor')
                        ->get(['id', 'nomor', 'nama'])
                        ->mapWithKeys(function ($h) {
                            return [$h->id => "{$h->nomor} - {$h->nama}"];
                        })
                        ->toArray();
                        })
                        ->default(function () {
                            $record = $this->siswa;
                            $lastHalamanId = optional(optional($record->hafalan[0] ?? null)->halaman)->id;
                            $selanjutnya = optional(optional($record->hafalan[0] ?? null))->selanjutnya;
    
                            if ($selanjutnya == 'mengulang') {
                                return $lastHalamanId;
                            } 
                            if ($selanjutnya == 'melanjutkan') {
                                return $lastHalamanId ? $lastHalamanId + 1 : 1;
                            }
                        })
                        ->afterStateUpdated(function (?string $state, ?string $old) {
                            $this->submitFormSatu();
                        } ),
                ])
            ])
            ->statePath('dataFormSatu');
    }


    protected function getFormDuaForm(): Form
    {
        return $this->makeForm()
            ->schema([
                Grid::make()->columns(2)->schema([
                    TextInput::make('nilai')
                        ->label('Nilai Hafalan')
                        ->numeric()
                        ->required(),
    
                   
    
                    Select::make('selanjutnya')
                        ->label('Selanjutnya')
                        ->options([
                            'mengulang' => 'Mengulang',
                            'melanjutkan' => 'Melanjutkan',
                        ])
                        ->required(),
                    Radio::make('status')
                        ->label('Status Hafalan')
                        ->options([
                            'baru' => 'Baru',
                            'murojaah' => 'Murojaah',
                        ])
                        ->inline()
                        ->default('baru')
                        ->required(),
                ]),
            ])
            ->statePath('dataFormDua'); // Menyimpan state di properti dataFormDua
    }
    
    // Mendaftarkan formulir yang akan digunakan
    protected function getForms(): array
    {
        return [
            'formSatu' => $this->getFormSatuForm(),
            'formDua' => $this->getFormDuaForm(),
        ];
    }



    public function submitFormSatu(): void
    {
        $data = $this->formSatu->getState();
        $halaman = Halaman::find($data['halaman']);

        $this->halamanSaatIni = $halaman->id;
        $this->nomorHalamanSaatIni = $halaman->nomor;
        $this->juzSaatIni = $halaman->juz;

        $this->fetchAyat();
        // Redirect to the detail page for the selected student
        
        // redirect()->to(HafalanResource::getUrl('detail-hafalan-siswa', ['record' => $siswaId]));
    }

    public function submitFormDua(): void
    {
        $data = $this->formDua->getState();

        // Lakukan penyimpanan data Form 2 (misalnya ke database)
        $this->siswa->hafalan()->create([
            'siswa_id' => $this->siswa->id,
            'halaman_id' => $this->halamanSaatIni,
            'nilai' => $data['nilai'],
            'selanjutnya' => $data['selanjutnya'],
            'status' => $data['status'],
            'user_id' => Auth::user()->id,
            'pertemuan' => now(),
        ]);

        Notification::make()
            ->title('Sukses')
            ->body('Data hafalan telah berhasil disimpan.')
            ->success()
            ->send();

        $this->redirect('/admin/hafalans');
    }



    protected function getFormActions(): array
    {
        return [
            Action::make('submitFormDua')
                ->label('Submit')
                ->button()
                ->color('primary')
                ->submit('submitFormDua'),
        ];
    }

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
        $this->formSatu->fill($this->data);
        
        $this->fetchAyat();
    }

    public function fetchAyat()
    {

        $page = $this->nomorHalamanSaatIni; // Nomor halaman 1-604
        $juz = $this->juzSaatIni; // Juz 1-30

        try {
            if ($juz == 30 ) {
                // Logika API untuk halaman per Juz 30 (lebih spesifik)
                $response = Http::get("https://api.alquran.cloud/v1/surah//{$page}");
                if ($response->successful()) {
                    $this->ayahs = $response->json('data.ayahs');
                } else {
                    $this->ayahs = [];
                }
                return;
            } else {
                $response = Http::get("https://api.alquran.cloud/v1/page/{$page}/quran-uthmani");
            
                if ($response->successful()) {
                    $this->ayahs = $response->json('data.ayahs');
                } else {
                    $this->ayahs = [];
                }
            }
        } catch (\Throwable $th) {
            // Tangani error khusus koneksi
            $this->ayahs = []; // atau default data
            // $this->notify('danger', 'Gagal mengambil data ayat. Coba lagi nanti.');
            Notification::make()
                ->title('Error Mengambil Ayat')
                ->body('Terjadi kesalahan saat menghubungi API Al-Quran. Silakan coba lagi nanti.')
                ->danger()
                ->send();
        }
        
        $this->formSatu->fill([
            'juz' => $this->juzSaatIni,
            'halaman' => $this->halamanSaatIni,
        ]);

    }

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
