<?php

namespace App\Livewire;

use App\Models\Hafalan;
use App\Models\Siswa;
use Carbon\Carbon;
use Filament\Tables\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class HafalanSiswaTable extends BaseWidget
{
    public static ?string $heading = 'Detail hafalan';

    public ?Siswa $siswa = null;

    protected int|string|array $columnSpan = 'full';




    protected function getTableQuery(): Builder
    {
        return Hafalan::query();
    }

    protected function getTablePollingInterval(): ?string
    {
        return null;
    }

    protected function getListeners(): array
    {
        return ['refresh' => '$refresh'];
    }

    
    public function table(Table $table): Table
    {

         if (!$this->siswa) {
            // Jika jamaah tidak ada (misalnya, widget dimuat tanpa data),
            // kembalikan query kosong atau null.
            return $table->query(Hafalan::query()->where('id', -1)); // Mengembalikan query yang tidak akan menampilkan data
        }
        return $table
            ->query(
                $this->siswa->hafalan()->getQuery()->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('pertemuan')
                    ->label('Tgl')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->translatedFormat('j M'))
                    ->sortable()
                    ->description(fn (Hafalan $record): string => Str::limit($record->user->name ?? '', 13)), // saya ingin membatasi karakter di deskripsi ini

                
                Tables\Columns\TextColumn::make('halaman.nama')
                    ->label('Halaman')
                    ->limit(10)
                    ->description(function (Hafalan $record): ?string {
                        $halaman = $record->halaman;

                        if (!$halaman) {
                            return null;
                        }

                        $juz = $halaman->juz;
                        $nomor = $halaman->nomor;

                        return $juz == 30
                            ? "Juz {$juz}"
                            : "Juz {$juz} - No {$nomor}";
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->description(fn (Hafalan $record): string => 'Nilai : ' . $record->nilai),

            ])
            ->actions([
            ActionGroup::make([
                Action::make('edit')
                    ->label('Ubah')
                    ->icon('heroicon-o-pencil-square')
                    ->modalHeading('Ubah Hafalan')
                    ->slideOver()
                    ->mountUsing(function (Hafalan $record, $form) {
                        $form->fill([
                            'status' => $record->status,
                            'nilai' => $record->nilai,
                        ]);
                    })
                    ->form([
                        //TODO: Hapus pemanggilan disini
                        Select::make('halaman_id')
                            ->relationship('halaman', 'nama')
                            ->required()
                            ->searchable()
                            ->label('Halaman'),

        

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
                    ->action(function (array $data, Hafalan $record) {
                        //TODO: Tambahkan ini disini
                        $data['siswa_id']= $this->siswa->id;
                        $record->update($data);
                    }),

                DeleteAction::make()
                    ->label('Hapus'),
            ])
        ])
        ->recordAction('edit');
    }

    
}
