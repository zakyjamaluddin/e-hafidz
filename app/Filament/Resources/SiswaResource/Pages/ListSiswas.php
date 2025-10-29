<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Select;
use App\Filament\Resources\SiswaResource;
use App\Imports\SiswaImport;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Maatwebsite\Excel\Facades\Excel;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {

        return [
            Actions\Action::make('importExcel')
                ->label('Import Siswa')
                ->button()
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('Pilih File Excel')
                        ->required()
                        ->acceptedFileTypes([
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.ms-excel',
                            'text/csv',
                        ]),
                    Select::make('kelas_id')
                        ->label('Kelas')
                        ->options(function () {
                            return \App\Models\Kelas::pluck('kelas', 'id')->toArray();
                        })
                        ->required(),
                ])
                ->action(function (array $data) {
                    try {
                        // Dapatkan path file di storage
                        $path = storage_path('app/public/' . $data['file']);
                        
                        // Jalankan import langsung
                        Excel::import(new SiswaImport($data['kelas_id']), $path);

                        // Hapus file setelah import (opsional)
                        Storage::disk('public')->delete($data['file']);

                        Notification::make()
                            ->title('Import Berhasil')
                            ->body('Data siswa berhasil diimport.')
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Gagal Import')
                            ->body('Terjadi kesalahan: ' . $e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),


            Actions\CreateAction::make(),
        ];
    }
}
