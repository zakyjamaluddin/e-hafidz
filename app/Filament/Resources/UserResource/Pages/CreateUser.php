<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = Auth::user();
        
        // Jika bukan super admin, tenant_id otomatis ikut tenant user yang sedang login
        if ($user->role === 'admin') {
            $data['tenant_id'] = $user->tenant_id;
        }
        // dd('testing', $user, $data['role'], $data['tenant_id']);

        return $data;
    }
}
