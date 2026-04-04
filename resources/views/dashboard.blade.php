<x-app-layout>
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Dashboard Utama</h1>
        <p class="text-sm text-slate-500 mt-1">Ringkasan performa finansial perkebunan nanas</p>
    </div>

    <div class="space-y-6">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-[#EF4444] rounded-2xl p-6 shadow-md text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-semibold opacity-90 mb-1">Total Biaya Operasional</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalBiaya, 0, ',', '.') }}</h3>
                    <p class="text-xs opacity-80 mt-2">Seluruh pengeluaran</p>
                </div>
            </div>

            <div class="bg-[#F59E0B] rounded-2xl p-6 shadow-md text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-semibold opacity-90 mb-1">Total Hasil Panen</p>
                    <h3 class="text-2xl font-bold">{{ number_format($totalPanen, 0, ',', '.') }} <span class="text-base font-medium">Biji/Kg</span></h3>
                    <p class="text-xs opacity-80 mt-2">Seluruh periode panen</p>
                </div>
            </div>

            <div class="bg-[#10B981] rounded-2xl p-6 shadow-md text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-semibold opacity-90 mb-1">Total Pendapatan</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                    <p class="text-xs opacity-80 mt-2">Pemasukan penjualan kotor</p>
                </div>
            </div>

            <div class="bg-[#2563EB] rounded-2xl p-6 shadow-md text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-20 h-20 bg-white/20 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="relative z-10">
                    <p class="text-sm font-semibold opacity-90 mb-1">Saldo Bersih</p>
                    <h3 class="text-2xl font-bold">Rp {{ number_format($saldo, 0, ',', '.') }}</h3>
                    <p class="text-xs opacity-80 mt-2">Pendapatan - Pengeluaran</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 mb-4 border-b border-slate-100 pb-2">Grafik Pemasukan & Pengeluaran ({{ $tahunIni }})</h3>
                <div class="relative h-[250px] w-full">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-sm font-bold text-slate-700 mb-4 border-b border-slate-100 pb-2">Perbandingan Bulanan ({{ $tahunIni }})</h3>
                <div class="relative h-[250px] w-full">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="text-sm font-bold text-slate-700 mb-4 border-b border-slate-100 pb-2">Aktivitas Terbaru</h3>
            
            <div class="space-y-3">
                @forelse($aktivitasTerbaru as $aktivitas)
                    <div class="flex items-center justify-between p-3 rounded-xl border border-slate-100 bg-slate-50 hover:bg-slate-100 transition-colors">
                        <div>
                            <p class="text-sm font-semibold text-slate-700">{{ $aktivitas->deskripsi }}</p>
                            <p class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($aktivitas->tanggal)->translatedFormat('d M Y') }}</p>
                        </div>
                        @if($aktivitas->jenis === 'Pemasukan')
                            <p class="text-sm font-bold text-green-600">+ Rp {{ number_format($aktivitas->nominal, 0, ',', '.') }}</p>
                        @else
                            <p class="text-sm font-bold text-red-600">- Rp {{ number_format($aktivitas->nominal, 0, ',', '.') }}</p>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-sm text-slate-400 py-4">
                        Belum ada aktivitas tercatat.
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataPemasukan = @json($chartPemasukan);
            const dataPengeluaran = @json($chartPengeluaran);
            const labelsBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            
            // Konfigurasi umum untuk format Rupiah di Tooltip & Axis Y
            const commonOptions = {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.parsed.y !== null) {
                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                if(value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                if(value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                                return 'Rp ' + value;
                            }
                        }
                    }
                }
            };

            // 1. Render Line Chart (Kiri)
            new Chart(document.getElementById('lineChart').getContext('2d'), {
                type: 'line',
                data: {
                    labels: labelsBulan,
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: dataPemasukan,
                            borderColor: '#10B981',
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Pengeluaran',
                            data: dataPengeluaran,
                            borderColor: '#EF4444',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            borderWidth: 3,
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: commonOptions
            });

            // 2. Render Bar Chart (Kanan)
            new Chart(document.getElementById('barChart').getContext('2d'), {
                type: 'bar',
                data: {
                    labels: labelsBulan,
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: dataPemasukan,
                            backgroundColor: '#10B981',
                            borderRadius: 4
                        },
                        {
                            label: 'Pengeluaran',
                            data: dataPengeluaran,
                            backgroundColor: '#9CA3AF', /* Warna Abu-abu sesuai wireframe */
                            borderRadius: 4
                        }
                    ]
                },
                options: commonOptions
            });
        });
    </script>
</x-app-layout>