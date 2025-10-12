<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanNilaiResource\Pages;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LaporanNilaiResource extends Resource
{
    protected static ?string $model = Kelas::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';
    protected static ?string $navigationLabel = 'Laporan Nilai';
    protected static ?string $pluralLabel = 'Laporan Nilai';
    protected static ?string $label = 'Laporan Nilai';
    public static function getNavigationGroup(): ?string
    {
        return 'Admin';
    }
    public static function canViewAny(): bool
    {
        return auth()->user()?->role !== 'guru';
    }

    public static function form(Form $form): Form
    {
        return $form; // tidak dipakai
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas')->label('Kelas')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('siswa_count')
                    ->label('Jumlah Siswa')
                    ->counts('siswa'),
            ])
            ->actions([
                Tables\Actions\Action::make('unduh_penilaian')
                    ->label('Unduh Penilaian')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->form([
                        Forms\Components\TextInput::make('min')
                            ->label('Nilai terendah')
                            ->numeric()
                            ->required()
                            ->default(0),
                        Forms\Components\TextInput::make('max')
                            ->label('Nilai tertinggi')
                            ->numeric()
                            ->required()
                            ->default(100)
                            ->gt('min'),   // harus > min
                    ])
                    ->action(function (Kelas $record, array $data) {
                        $min = (float) $data['min'];
                        $max = (float) $data['max'];

                        $file = 'penilaian-kelas-'.($record->kelas ?? 'kelas').'-'.now()->format('Ymd-His').'.xlsx';

                        return \Maatwebsite\Excel\Facades\Excel::download(
                            new \App\Exports\PenilaianKelasExport($record, $min, $max),
                            $file
                        );
                    }),
            ])
            ->bulkActions([]); // tidak perlu
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanNilais::route('/'),
        ];
    }

}