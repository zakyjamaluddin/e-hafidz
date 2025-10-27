<div 
    x-data="{
        juz: {{ $juz ?? 1 }},
        page: {{ $page ?? 1 }},
        allHalaman: @js($halaman), // seluruh data halaman dikirim dari backend
        ayahs: @js($ayahs),
        loading: false,

        get filteredHalaman() {
            return this.allHalaman.filter(h => h.juz === this.juz);
        },

        async fetchAyat() {
            this.loading = true;
            try {
                let url = '';
                if (this.juz === 30) {
                    url = `https://api.alquran.cloud/v1/surah//${this.page}`;
                } else {
                    url = `https://api.alquran.cloud/v1/page/${this.page}/quran-uthmani`;
                }

                const res = await fetch(url);
                const data = await res.json();
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
        },
    }"
    x-init="
        window.addEventListener('halaman-changed', e => {
            page = e.detail.page;
            juz = e.detail.juz;
            fetchAyat();
        });
    "
    class="p-4 space-y-4 text-right"

    
>

    <div class="flex gap-4" dir="ltr">
        {{-- Select Juz --}}
        <div class="w-1/2">
            <label for="juz-select" class="block text-sm font-medium text-gray-700 mb-1">Juz</label>
            <select id="juz-select"
                x-model.number="juz"
                x-init="
                    $nextTick(() => { $el.value = juz; });
                "
                @change="
                    page = 1;
                    fetchAyat();
                    window.dispatchEvent(new CustomEvent('halaman-changed', { detail: { juz, page } }));
                "
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                <template x-for="j in [...new Set(allHalaman.map(h => h.juz))]" :key="j">
                    <option :value="j" x-text="'Juz ' + j"></option>
                </template>
            </select>
        </div>

        {{-- Select Halaman (Reactive) --}}
        <div class="w-1/2">
            <label for="halaman-select" class="block text-sm font-medium text-gray-700 mb-1">Halaman</label>
            <select id="halaman-select"
                x-model.number="page"
                @change="
                    fetchAyat();
                    window.dispatchEvent(new CustomEvent('halaman-changed', { detail: { juz, page } }));
                "
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
                <template x-for="h in filteredHalaman" :key="h.nomor">
                    <option :value="h.nomor" x-text='h.nomor + " - " + h.nama'></option>
                </template>
            </select>
        </div>
    </div>



        {{-- Area Ayat --}}
        <div class="text-2xl leading-loose text-justify min-h-[300px]" style="font-family: 'Arabic'" dir="rtl">
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

    {{-- Loading --}}
    <div x-show="loading" class="text-center text-gray-500">Memuat halaman...</div>


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



</div>
