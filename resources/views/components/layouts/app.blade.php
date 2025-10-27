<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pendaftaran Tahfidz Web Madrasah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- Jika Anda menggunakan Vite --}}
    @livewireStyles
    <style>
        /* Tambahkan style dasar, misalnya agar form di tengah */
        body {
            background-color: #f7f7f7;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-6">
        {{ $slot }} {{-- Livewire akan menempatkan komponen TenantRegistrationForm di sini --}}
    </div>
    @livewireScripts
</body>
</html>