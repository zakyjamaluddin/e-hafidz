<x-filament::widget>
    <x-filament::card>
        <div class="text-lg font-bold mb-4">Grafik Skor Hafalan</div>
        <canvas id="myChart" class="w-full h-auto"></canvas>
    </x-filament::card>
</x-filament::widget>

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Ahmad', 'Budi', 'Cici', 'Dewi', 'Eka'],
                    datasets: [{
                        label: 'Skor Hafalan',
                        data: [12, 8, 15, 9, 11],
                        backgroundColor: '#10B981'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Grafik Skor Hafalan Siswa'
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                autoSkip: false,
                                maxRotation: 45,
                                minRotation: 0
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
