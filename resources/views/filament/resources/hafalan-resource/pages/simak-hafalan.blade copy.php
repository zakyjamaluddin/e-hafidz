<x-filament-panels::page>
    @once
        @push('styles')
            <link rel="stylesheet" href="{{ asset('css/custom-font.css') }}">
        @endpush
    @endonce


    <div class="space-y-6">
        <div class="filament-card p-6 shadow-sm rounded-xl bg-white dark:bg-gray-800">
            <h2 class="text-xl font-bold dark:text-white">{{ $siswa->nama }} (Kelas {{ $siswa->kelas->kelas ?? '-' }}) {{ $this->juzSaatIni }}</h2>
            <p class="text-lg text-primary-600 dark:text-primary-500">Juz Berapa ya</p>
            {{-- ✅ Tampilkan form untuk Juz dan Halaman --}}
            {{ $this->selectForm }}
        </div>

        <div
            wire:loading.class="opacity-50"
            class="filament-card p-6 shadow-sm rounded-xl bg-white dark:bg-gray-800 text-right"
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

        <hr class="dark:border-gray-700">

        <form wire:submit.prevent="submitHafalan" class="space-y-6">
            {{ $this->form }}

            <x-filament::button
                type="submit"
                size="md"
                wire:loading.attr="disabled"
                wire:target="submitHafalan"
            >
                Simpan Hafalan
            </x-filament::button>
        </form>

    </div>
</x-filament-panels::page>


