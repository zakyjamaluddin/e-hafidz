<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KelasResource\Pages;
use App\Filament\Resources\KelasResource\RelationManagers;
use App\Models\Kelas;
use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KelasResource extends Resource
{
    protected static ?string $model = Kelas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
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
        return $form
            ->schema([
                Forms\Components\TextInput::make('kelas')
                    ->required(),
                Select::make('target')
                    ->options(
                        \App\Models\Halaman::all()->mapWithKeys(function ($halaman) {
                            return [
                                $halaman->id => "{$halaman->nomor} - {$halaman->nama}",
                            ];
                        })
                    )
                    ->required()
                    ->default($record->hafalan[0]->halaman->id ?? '')
                    ->label('Halaman'),
                // Kalau super admin, boleh pilih tenant
                Select::make('tenant_id')
                    ->label('Tenant')
                    ->relationship('tenant', 'nama')
                    ->visible(fn () => auth()->user()->is_super_admin)
                    ->required(),

                // Kalau bukan super admin, tenant_id diisi otomatis
                Hidden::make('tenant_id')
                    ->default(fn () => auth()->user()->tenant_id)
                    ->visible(fn () => !auth()->user()->is_super_admin),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kelas')
                    ->searchable(),
                TextColumn::make('targetHafalan.nama')
                    ->label('Target'),
               
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    // 👉 Custom Action "Ubah/Naik Kelas"
                    Tables\Actions\Action::make('ubahNaikKelas')
                        ->label('Ubah/Naik Kelas')
                        ->icon('heroicon-o-arrow-up-circle')
                        ->form([
                            Forms\Components\TextInput::make('kelas_baru')
                                ->label('Nama Kelas Baru')
                                ->required(),
                        ])
                        ->action(function ($record, array $data): void {
                            // Simpan perubahan ke field "kelas"
                            $record->update([
                                'kelas' => $data['kelas_baru'],
                            ]);
                        })
                        ->modalHeading('Ubah / Naik Kelas')
                        ->modalButton('Simpan Perubahan')
                        ->requiresConfirmation(),
                ])
            ]);
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
            'index' => Pages\ListKelas::route('/'),
            'create' => Pages\CreateKelas::route('/create'),
            'edit' => Pages\EditKelas::route('/{record}/edit'),
        ];
    }
}
