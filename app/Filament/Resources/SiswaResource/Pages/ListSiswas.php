<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Select;
use App\Filament\Resources\SiswaResource;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Validation\Rules\File;

class ListSiswas extends ListRecords
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {

        return [
            ImportAction::make()
            ->importer(\App\Filament\Imports\SiswaImporter::class)
            ->fileRules([
                File::types(['csv', 'xlsx', 'xls'])->max(1024),
            ])
            ->options([
                    'kelas_id' => true,
                    'user_id' => true,
                    'tenant_id' => true,
            ]),
            // ->form([
            //     FileUpload::make('file') // Gunakan nama 'file' (default ImportAction)
            //             ->label('Unggah File Excel/CSV')
            //             ->required()
            //             ->storeFiles(false),
            //     // Field kustom, pilih kelas untuk siswa yang diimpor
            //     Select::make('kelas_id')
            //         ->label('Kelas')
            //         ->options(function () {
            //             return \App\Models\Kelas::pluck('kelas', 'id')->toArray();
            //         })
            //         ->required(),
            // ]),

            Actions\CreateAction::make(),
        ];
    }
}
