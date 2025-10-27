<?php

namespace App\Filament\Imports;

use App\Models\Siswa;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Models\Import;

class SiswaImporter extends Importer
{
    protected static ?string $model = Siswa::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('nama')
                ->requiredMapping() // Wajib dipetakan dari file Excel
                ->rules(['required', 'max:255']),

            ImportColumn::make('panggilan')
                ->requiredMapping(),

            ImportColumn::make('jenis_kelamin')
                ->requiredMapping(),

            
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            // Coba koma (paling umum)
            'delimiter' => ',', 
            
            // Jika koma tidak berhasil, coba titik koma (sering digunakan di Indonesia/Eropa)
            // 'delimiter' => ';', 
        ];
    }

    public function resolveRecord(): ?Siswa
    {
        // 1. Ambil data dari file Excel/CSV (sudah divalidasi)
        $excelData = $this->data;

        // 2. Ambil data dari field kustom di modal
        $additionalData = $this->options;

        // 3. Gabungkan kedua data tersebut.
        $finalData = array_merge($excelData, [
            // Tambahkan nilai dari field kustom
            'kelas_id' => $additionalData['kelas_id'],
            'tenant_id' => $additionalData['tenant_id'],
        ]);

        return new Siswa($finalData);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your siswa import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }

    public static function getOptionsFormComponents(): array
    {
        $kelasOptions = \App\Models\Kelas::pluck('kelas', 'id')->toArray();
        return [

            Select::make('kelas_id')
                    ->label('Kelas')
                    ->options($kelasOptions)
                    ->required(),

            Hidden::make('user_id')
                ->default(auth()->id()),
            // 💡 Tambahkan ini:
            Hidden::make('tenant_id') 
                ->default(auth()->user()->tenant_id),
            // ...
        ];
    }

    public function shouldEnforceFilamentActionsJob(): bool
    {
        // Mengembalikan FALSE akan memaksa job berjalan secara sinkron (non-queued)
        return false;
    }
}
