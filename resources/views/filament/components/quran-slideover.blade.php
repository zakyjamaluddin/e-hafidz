@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/custom-font.css') }}">
    @endpush
@endonce


<div 
    x-data="{
        page: {{ $page ?? 1 }},
        juz: {{ $juz ?? 1 }}, // ← tambahkan ini
        ayahs: @js($ayahs),
        loading: false,
        async fetchAyat() {
            this.loading = true;
            try {
                let url = '';
                if (this.juz === 30) {
                    // Contoh: Tampilkan surah terakhir (An-Nas)
                    url = `https://api.alquran.cloud/v1/surah//${this.page}`;
                } else {
                    url = `https://api.alquran.cloud/v1/page/${this.page}/quran-uthmani`;
                }

                const res = await fetch(url);
                const data = await res.json();

                // Jika API surah, ambil `data.ayahs`, bukan `data.data.ayahs`
                this.ayahs = this.juz === 30 ? data.data.ayahs : data.data.ayahs;
            } catch (e) {
                this.ayahs = [];
            } finally {
                this.loading = false;
            }
        },
        arabicNumber(number) {
            const western = ['0','1','2','3','4','5','6','7','8','9'];
            const eastern = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            return String(number).split('').map(d => eastern[western.indexOf(d)]).join('');
        }



    }"
    x-init="
        // Dengarkan event dari Select Filament
        window.addEventListener('halaman-changed', e => {
            page = e.detail.page;
            juz  = e.detail.juz;
            fetchAyat();
        });
    "
    class="p-4 space-y-4 text-right"
    dir="rtl"
>

    @php
    if (!function_exists('arabic_number')) {
        function arabic_number($number)
        {
            $western = ['0','1','2','3','4','5','6','7','8','9'];
            $eastern = ['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'];
            return str_replace($western, $eastern, $number);
        }
    }
    @endphp
    <!-- Tampilkan Ayat -->
    <div class="text-2xl leading-loose text-justify min-h-[300px]" style="font-family: 'Arabic'">
        <template x-if="ayahs.length > 0">
            <div>
                <template x-for="ayah in ayahs" :key="ayah.number">
                    <span class="inline">
                        <span x-text="ayah.text"></span>
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full border-2 border-gray-700 text-sm font-bold mx-1">
                            <span x-text="arabicNumber(ayah.numberInSurah)"></span>
                        </span>
                    </span>
                </template>
            </div>
        </template>

        <template x-if="ayahs.length === 0">
            <p class="text-center text-gray-500">Gagal memuat ayat.</p>
        </template>
    </div>

    <!-- Loading -->
    <div x-show="loading" class="text-center text-gray-500">Memuat halaman...</div>

    <!-- Tombol Navigasi -->
    <div class="flex justify-between mt-6">
        <x-filament::button
        color="gray"
        tag="button"
        size="sm"
        x-bind:disabled="page <= 1"
        x-on:click.prevent.stop="page--; fetchAyat()"
    >
        Halaman Sebelumnya
    </x-filament::button>

    <x-filament::button
        color="gray"
        tag="button"
        size="sm"
        x-on:click.prevent.stop="page++; fetchAyat()"
    >
        Halaman Berikutnya
    </x-filament::button>

    </div>
    <br>
    <hr>

</div>
