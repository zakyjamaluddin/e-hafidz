<?php

namespace App\Filament\Resources;

use App\Filament\Pages\DetailHafalanSiswa;
use App\Filament\Resources\HafalanResource\Pages;
use App\Filament\Resources\HafalanResource\Pages\ViewHafalan;
use App\Filament\Resources\HafalanResource\RelationManagers;
use App\Livewire\SimakHafalan;
use App\Models\Hafalan;
use App\Models\Halaman;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;

class HafalanResource extends Resource
{
    protected static ?string $model = Hafalan::class;

    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';

    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(function () {
            $user = filament()->auth()->user();

            // Ambil semua id kelas yang diampu user dari relasi many-to-many
            $kelasIds = $user->kelas()->pluck('kelas.id');

            return \App\Models\Siswa::with([
                'hafalan' => function ($query) {
                    $query->latest('created_at')->with('halaman');
                }
            ])->whereIn('kelas_id', $kelasIds);
        })
            ->filters([
                SelectFilter::make('kelas_id')
                    ->label('Filter Kelas')
                    ->options(function () {
                        $user = auth()->user();

                        return $user->kelas
                            ->pluck('kelas', 'id')
                            ->toArray();
                    }),

                TernaryFilter::make('sudah_setor')
                    ->label('Setoran Terakhir')
                    ->trueLabel('Sudah setor')
                    ->falseLabel('Belum setor')
                    ->queries(
                        true: fn ($query) => $query->whereHas('hafalan', function ($q) {
                            // Ambil pertemuan terakhir dari semua data
                            $lastPertemuan = \App\Models\Hafalan::max('pertemuan');
                            $q->where('pertemuan', $lastPertemuan);
                        }),
                        false: fn ($query) => $query->whereDoesntHave('hafalan', function ($q) {
                            $lastPertemuan = \App\Models\Hafalan::max('pertemuan');
                            $q->where('pertemuan', $lastPertemuan);
                        }),
                        blank: fn ($query) => $query
                    ),

            ])
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Siswa')
                    ->sortable()
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('hafalan.0.halaman.nama')
                    ->label('Halaman')
                    ->limit(10)
                    ->description(fn (Siswa $record): ?string => $record->hafalan->first()?->selanjutnya ?? null)
                    ->default('-')
            ])
            ->emptyStateHeading('Belum ada data hafalan')
            ->actions([
                Action::make('lihatInfo')
                    ->label('Simak')
                    ->icon('heroicon-o-eye')
                    ->slideOver() 
                    ->modalHeading(fn ($record) => $record->nama)
                    ->modalDescription(fn ($record) => 'Kelas ' . $record->kelas->kelas)
                    ->modalSubmitActionLabel('Simpan Hafalan') // Tidak butuh tombol "Simpan"
                    ->modalCancelActionLabel('Tutup')
                    ->form( fn ($record) =>[

                        Grid::make(2) // 👈 2 kolom
                            ->schema([

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
                                    ->default(function ($record) {
                                        $lastHalamanJuz = optional(optional($record->hafalan[0] ?? null)->halaman)->juz;
                                        $lastHalamanNomor = optional(optional($record->hafalan[0] ?? null)->halaman)->nomor;
                                        $selanjutnya = optional(optional($record->hafalan[0] ?? null))->selanjutnya;
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
                                    ->default(function ($record) {
                                        $lastHalamanId = optional(optional($record->hafalan[0] ?? null)->halaman)->id;
                                        $selanjutnya = optional(optional($record->hafalan[0] ?? null))->selanjutnya;

                                        if ($selanjutnya == 'mengulang') {
                                            return $lastHalamanId;
                                        } 
                                        if ($selanjutnya == 'melanjutkan') {
                                            return $lastHalamanId ? $lastHalamanId + 1 : 1;
                                        }
                                    }),


                                TextInput::make('nilai')
                                    ->label('Nilai Hafalan')
                                    ->numeric()
                                    ->required(),

                                Select::make('status')
                                    ->label('Status Hafalan')
                                    ->options([
                                        'baru' => 'Baru',
                                        'murojaah' => 'Murojaah',
                                    ])
                                    ->required(),

                                Select::make('selanjutnya')
                                    ->label('Selanjutnya')
                                    ->options([
                                        'mengulang' => 'Mengulang',
                                        'melanjutkan' => 'Melanjutkan',
                                    ])
                                    ->required(),

                                
                            ]),
                    ])
                    ->action(function (array $data, $record) {
                        \App\Models\Hafalan::create([
                            'siswa_id' => $record->id,
                            'halaman_id' => $data['halaman'],
                            'nilai' => $data['nilai'],
                            'status' => $data['status'],
                            'selanjutnya' => $data['selanjutnya'],
                            'user_id' => Auth::user()->id,
                            'pertemuan' => now(),
                        ]);

                        Notification::make()
                            ->title('Hafalan disimpan')
                            ->success()
                            ->send();
                    })
                    ->modalContent(function ($record) {
                        if($record->hafalan->count() !== 0) {
                            if($record->hafalan[0]->halaman->juz == 30) {
                                if($record->hafalan[0]->selanjutnya == 'mengulang') {
                                    $number = (int) preg_replace('/\D/', '', $record->hafalan[0]->halaman->nomor ?? '1');
                                } else {
                                    $number = (int) preg_replace('/\D/', '', $record->hafalan[0]->halaman->nomor ?? '1') - 1;
                                    
                                }

                                $response = Http::get("https://api.alquran.cloud/v1/surah/{$number}");
                                if ($number == 77) {
                                    $response = Http::get("https://api.alquran.cloud/v1/page/1/quran-uthmani");
                                }
                                if ($response->successful()) {
                                    $data = $response->json('data.ayahs');
                                    return view('filament.components.quran-slideover', [
                                        'id_siswa' => $record->id,
                                        'ayahs' => $data,
                                        'page' => $number,
                                        'juz' => $record->hafalan[0]->halaman->juz,
                                    ]);
                                }

                            } else {
                                if($record->hafalan[0]->selanjutnya == 'mengulang') {
                                    $page = (int) preg_replace('/\D/', '', $record->hafalan[0]->halaman->nomor ?? '1');
                                } else {
                                    $page = (int) preg_replace('/\D/', '', $record->hafalan[0]->halaman->nomor ?? '1') + 1;
                                }
                                $response = Http::get("https://api.alquran.cloud/v1/page/{$page}/quran-uthmani");
                                
                                if ($response->successful()) {
                                    $data = $response->json('data.ayahs');
                                    return view('filament.components.quran-slideover', [
                                        'id_siswa' => $record->id,
                                        'ayahs' => $data,
                                        'page' => $page,
                                        'juz' => $record->hafalan[0]->halaman->juz,
                                    ]);
                                }
                            }
                        }
                        
                        $number = (int) preg_replace('/\D/', '', $record->hafalan[0]->halaman->nomor ?? '114');
                        $response = Http::get("https://api.alquran.cloud/v1/surah/{$number}");
                        if ($response->successful()) {
                            $data = $response->json('data.ayahs');
                            return view('filament.components.quran-slideover', [
                                'id_siswa' => $record->id,
                                'ayahs' => $data,
                                'page' => $number,
                                'juz' => 30,
                            ]);
                        }
                        
                    
                }),

            ])
            ->recordUrl(fn (Siswa $record): string => route('filament.admin.resources.hafalans.detail-hafalan-siswa', ['record' => $record->id]));
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHafalans::route('/'),
            'create' => Pages\CreateHafalan::route('/create'),
            'edit' => Pages\EditHafalan::route('/{record}/edit'),
            'detail-hafalan-siswa' => Pages\ViewHafalan::route('/siswa/{record}'),
        ];
    }
}
