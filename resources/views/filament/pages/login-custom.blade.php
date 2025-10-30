
<x-filament-panels::page.simple>
    <div class="text-center mb-6">
        <h2 class="mt-4 text-lg font-semibold">Selamat Datang Kembali</h2>
    </div>

    {{-- Bungkus form di dalam form Livewire --}}
    <form wire:submit="authenticate" class="space-y-4">
        {{ $this->form }}

        <x-filament::button type="submit" class="w-full mt-4">
            Masuk
        </x-filament::button>
    </form>
</x-filament-panels::page.simple>