<?php

namespace App\Filament\Resources\HafalanResource\Pages;

use App\Filament\Resources\HafalanResource;
use App\Livewire\HafalanSiswaTable;
use App\Models\Hafalan;
use App\Models\Halaman;
use App\Models\Siswa;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\Page;

class ViewHafalan extends Page
{
    protected static string $resource = HafalanResource::class;
    protected static string $view = 'filament.resources.hafalan-resource.pages.detail-hafalan';

    protected ?string $heading = 'Laporan Hafalan Siswa'; // heading override

    public function getSubheading(): ?string
    {
        // return __('Custom Page Subheading');
        return $this->record->nama;
    }

    public Siswa $record;

    public function mount(Siswa $record): void
    {
        $this->record = $record;
    }

    protected function getHeaderActions(): array
    {
            return [
            CreateAction::make()
                    ->model(Hafalan::class)
                    ->label('Tambah Hafalan')
                    ->modalHeading('Tambah Hafalan untuk Siswa')
                    ->form([
                        Hidden::make('siswa_id')
                            ->default($this->record->id),
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

                
                        DatePicker::make('pertemuan')
                            ->required()
                            ->label('Tanggal Pertemuan'),
                        
                        TextInput::make('nilai')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->label('Nilai'),
                        Select::make('selanjutnya')
                            ->options([
                                'Mengulang' => 'Mengulang',
                                'Melanjutkan' => 'Melanjutkan',
                            ])
                            ->required()
                            ->label('Selanjutnya'),
                            
                        Select::make('status')
                            ->options([
                                'Murojaah' => 'Murojaah',
                                'Baru' => 'Baru',
                            ])
                            ->required()
                            ->label('Status'),
                    ])
                    ->slideOver()
                    ->successNotificationTitle('Hafalan berhasil ditambahkan!')
                    ->action(function (array $data): \Illuminate\Database\Eloquent\Model {
                        $return = Hafalan::create($data);
                        $this->dispatch('refresh');
                        return $return;
                    })
                    ->after(function () {
                        $this->dispatch('refresh');
                    }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [

            HafalanSiswaTable::make([
                'siswa' => $this->record, // <-- Kunci perbaikan di sini
            ]),
        ];
    }

}
