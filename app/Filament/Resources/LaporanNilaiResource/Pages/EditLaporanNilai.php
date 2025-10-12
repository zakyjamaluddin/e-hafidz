<?php

namespace App\Filament\Resources\LaporanNilaiResource\Pages;

use App\Filament\Resources\LaporanNilaiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporanNilai extends EditRecord
{
    protected static string $resource = LaporanNilaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
