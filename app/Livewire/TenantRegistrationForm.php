<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

// Pastikan model User menggunakan trait HasRoles dari Spatie
// dan Anda telah menginstal Filament Shield

class TenantRegistrationForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Kolom Nama Lembaga (untuk tabel 'tenant')
                TextInput::make('lembaga_name')
                    ->label('Nama Lembaga')
                    ->required()
                    ->maxLength(255)
                    ->unique(Tenant::class, 'name'), // Sesuaikan dengan kolom nama di tabel tenant
                
                // Kolom Nama (untuk tabel 'users')
                TextInput::make('name')
                    ->label('Nama Pengguna')
                    ->required()
                    ->maxLength(255),
                    
                // Kolom Email (untuk tabel 'users')
                TextInput::make('email')
                    ->required()
                    ->email()
                    ->unique(User::class, 'email'),

                // Kolom Password (untuk tabel 'users')
                TextInput::make('password')
                    ->required()
                    ->password()
                    ->confirmed()
                    ->minLength(8),
                
                TextInput::make('password_confirmation')
                    ->required()
                    ->password()
                    ->label('Konfirmasi Password'),
            ])
            ->statePath('data');
    }

    public function register()
    {
        try {
            $data = $this->form->getState();

            // 1. Membuat Tenant baru
            $tenant = Tenant::create([
                'name' => $data['lembaga_name'],
                // Tambahkan kolom lain jika ada
            ]);

            // 2. Membuat User baru dengan tenant_id otomatis
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'tenant_id' => $tenant->id, // Mengisi tenant_id secara otomatis
                'role' => 'admin', // Set role awal sebagai admin
            ]);

            // 3. Memberikan peran 'admin' secara default
            // Pastikan peran 'admin' sudah ada di tabel roles (Spatie/Filament Shield)
            
            // Opsional: Langsung login user
            auth()->login($user);
            
            // Redirect ke halaman login admin atau dashboard
            return redirect()->route('filament.admin.pages.dashboard')
                             ->with('notification', 'Pendaftaran berhasil! Silakan masuk.');

        } catch (\Exception $e) {
            // Tangani error, misalnya validasi unik atau DB error
            // Session::flash('error', 'Pendaftaran gagal: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.tenant-registration-form');
    }
}