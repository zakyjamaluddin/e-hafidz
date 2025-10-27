<x-filament-panels::page>
    <x-filament::section>
    <x-slot name="heading">
        User details
    </x-slot>

    {{-- Content --}}
    {{ $this->formSatu }}

    <div
                wire:loading.class="opacity-50"
                class="filament-card rounded-xl bg-white dark:bg-gray-800 text-right mt-6"
                dir="rtl"
            >
            <div class="text-2xl leading-loose text-justify min-h-[300px]" style="font-family: 'Arabic'">
                @if (empty($ayahs))
                    <p class="text-center text-gray-500">Gagal memuat ayat atau halaman tidak ditemukan.</p>
                @else
                    @foreach ($ayahs as $ayah)
                        <span class="inline">
                            {{ $ayah['text'] }}
                            <span class="inline-flex items-center justify-center w-7 h-7 rounded-full border-2 border-gray-700 text-sm font-bold mx-1">
                                {{ arabic_number($ayah['numberInSurah']) }}
                            </span>
                        </span>
                    @endforeach
                @endif
            </div>

            <div wire:loading.delay wire:target="fetchAyat, nextHalaman, prevHalaman" class="text-center text-gray-500 mt-4">
                Memuat halaman...
            </div>
        </div>
        <div class="flex justify-between mt-6">
            <x-filament::button
                color="gray"
                tag="button"
                size="md"
                wire:click="prevHalaman"
                wire:loading.attr="disabled"
            >
                Halaman Sebelumnya
            </x-filament::button>

            <x-filament::button
                color="gray"
                tag="button"
                size="md"
                wire:click="nextHalaman"
                wire:loading.attr="disabled"
            >
                Halaman Berikutnya
            </x-filament::button>
        </div>
</x-filament::section>

        

<x-filament::section>
    <x-slot name="heading">
        User details
    </x-slot>

        

        {{ $this->formDua }}
        <div class="mt-6">
            <x-filament::button wire:click="submitFormDua">
                Simpan Data
            </x-filament::button>
        </div>
</x-filament::section>
</x-filament-panels::page>