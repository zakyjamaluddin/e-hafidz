<?php

namespace App\Filament\Pages;

use App\Livewire\HafalanSiswaChart;
use App\Livewire\HafalanSiswaChartCustom;
use App\Livewire\InfoDashboard;
use App\Models\Kelas;
use Filament\Pages\Page;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';
    



    protected function getHeaderWidgets(): array
    {


        $widgets = [];
        $widgets[] = InfoDashboard::make();

        foreach (Kelas::all() as $kelas) {
            $widgets[] = HafalanSiswaChart::make(['kelas_id' => $kelas->id]);
        }
        
        return $widgets;
    }
}
