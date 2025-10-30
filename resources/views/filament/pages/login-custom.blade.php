
<x-filament-panels::page.simple>
    <div class="text-center">
        <p class="mt-4 text-md">Pastikan anda sudah install aplikasi sebelum masuk</p>
    </div>
    <x-filament::button type="button" id="pwa-install-btn" class="w-full">
            Install Aplikasi
    </x-filament::button>
    {{-- Bungkus form di dalam form Livewire --}}
    <form wire:submit.prevent="authenticate" class="space-y-4">
        {{ $this->form }}

        <x-filament::button
            type="button"
            wire:click="authenticate"
            wire:loading.attr="disabled"
            wire:target="authenticate"
            class="w-full mt-4"
        >
            Masuk
        </x-filament::button>

    </form>
</x-filament-panels::page.simple>