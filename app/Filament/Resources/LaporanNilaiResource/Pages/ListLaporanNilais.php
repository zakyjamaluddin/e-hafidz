<?php

namespace App\Filament\Resources\LaporanNilaiResource\Pages;

use App\Filament\Resources\LaporanNilaiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaporanNilais extends ListRecords
{
    protected static string $resource = LaporanNilaiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
