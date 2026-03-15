@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Dashboard')
@section('page_title', 'Dashboard Umum')
@section('page_subtitle', 'Ringkasan data penjualan, analisis toko, dan status persediaan.')

@section('content')
<div class="space-y-8">

    <!-- Ringkasan Penjualan -->
    <div>
        <h2 class="text-2xl font-bold text-blue-700 mb-4">- Ringkasan Penjualan</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-green-100 flex items-center justify-center text-green-500 text-3xl">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                    <p class="text-gray-700 text-lg">Total Penjualan</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-400 text-3xl">
                    <i class="fas fa-rotate-left"></i>
                </div>
                <div>
                    <p class="text-gray-700 text-lg">Retur Penjualan</p>
                    <h3 class="text-4xl font-bold text-gray-900">{{ $returPenjualan }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-red-400 text-3xl">
                    <i class="fas fa-receipt"></i>
                </div>
                <div>
                    <p class="text-gray-700 text-lg">Penjualan Tertolak</p>
                    <h3 class="text-4xl font-bold text-gray-900">≥ {{ $penjualanTertolak }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Analisis Toko -->
    <div>
        <h2 class="text-2xl font-bold text-blue-700 mb-4">- Analisis Toko</h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 h-64">
                <p class="text-center text-gray-600 font-medium mb-4">
                    Freq. Penjualan 7 Hari Terakhir Berdasarkan Jam
                </p>
                <div class="relative h-[190px]">
                    <canvas id="chartPenjualanPerJam"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 h-64">
                <p class="text-center text-gray-600 font-medium mb-4">
                    Freq. Penjualan 4 Pekan Terakhir Berdasarkan Hari
                </p>
                <div class="relative h-[190px]">
                    <canvas id="chartPenjualanPerHari"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Database Apotek -->
    <div>
        <h2 class="text-2xl font-bold text-blue-700 mb-4">- Database Apotek</h2>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-teal-100 flex items-center justify-center text-teal-500 text-3xl">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 text-lg">Database Pelanggan</p>
                        <h3 class="text-4xl font-bold text-gray-900">{{ $databasePelanggan }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-orange-100 flex items-center justify-center text-orange-500 text-3xl">
                        <i class="fas fa-file-medical"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 text-lg">Database Supplier</p>
                        <h3 class="text-4xl font-bold text-gray-900">{{ $databaseSupplier }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-blue-100 flex items-center justify-center text-blue-500 text-3xl">
                        <i class="fas fa-boxes-stacked"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 text-lg">Database Produk</p>
                        <h3 class="text-4xl font-bold text-gray-900">{{ number_format($databaseProduk, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-red-100 flex items-center justify-center text-red-500 text-3xl">
                        <i class="fas fa-user-doctor"></i>
                    </div>
                    <div>
                        <p class="text-gray-700 text-lg">Database Dokter</p>
                        <h3 class="text-4xl font-bold text-gray-900">{{ $databaseDokter }}</h3>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5">
                <div class="bg-green-50 rounded-2xl px-4 py-3 flex items-center justify-between mb-4">
                    <span class="font-bold text-blue-700">Tipe Produk</span>
                    <i class="fas fa-chevron-right text-blue-600"></i>
                </div>

                <div class="flex items-center justify-center h-[220px]">
                    <canvas id="tipeProdukChart" class="max-h-[180px]"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Persediaan -->
    <div>
        <h2 class="text-2xl font-bold text-blue-700 mb-4">- Status Persediaan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4">
                <div class="bg-red-100 rounded-2xl px-4 py-3 flex items-center justify-between mb-6">
                    <span class="font-bold text-blue-700">Berpotensi Rugi</span>
                    <i class="fas fa-chevron-right text-blue-600"></i>
                </div>
                <div class="text-center py-4">
                    <div class="text-5xl font-bold text-gray-900">{{ $berpotensiRugi }}</div>
                    <div class="text-2xl text-gray-800 mt-2">produk</div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4">
                <div class="bg-orange-100 rounded-2xl px-4 py-3 flex items-center justify-between mb-6">
                    <span class="font-bold text-blue-700">Stok Negatif</span>
                    <i class="fas fa-chevron-right text-blue-600"></i>
                </div>
                <div class="text-center py-4">
                    <div class="text-5xl font-bold text-gray-900">{{ $stokNegatif }}</div>
                    <div class="text-2xl text-gray-800 mt-2">produk</div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4">
                <div class="bg-blue-100 rounded-2xl px-4 py-3 flex items-center justify-between mb-6">
                    <span class="font-bold text-blue-700">Dekat Kadaluarsa</span>
                    <i class="fas fa-chevron-right text-blue-600"></i>
                </div>
                <div class="text-center py-4">
                    <div class="text-5xl font-bold text-gray-900">{{ $dekatKadaluarsa }}</div>
                    <div class="text-2xl text-gray-800 mt-2">stok</div>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4">
                <div class="bg-purple-100 rounded-2xl px-4 py-3 flex items-center justify-between mb-6">
                    <span class="font-bold text-blue-700">Sudah Kadaluarsa</span>
                    <i class="fas fa-chevron-right text-blue-600"></i>
                </div>
                <div class="text-center py-4">
                    <div class="text-5xl font-bold text-gray-900">{{ $sudahKadaluarsa }}</div>
                    <div class="text-2xl text-gray-800 mt-2">stok</div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // =========================
    // CHART PENJUALAN PER JAM
    // =========================
    const ctxJam = document.getElementById('chartPenjualanPerJam');

    if (ctxJam) {
        new Chart(ctxJam, {
            type: 'line',
            data: {
                labels: @json($jamLabels),
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: @json($jamData),
                    borderColor: '#4fd1c5',
                    backgroundColor: 'rgba(79, 209, 197, 0.18)',
                    fill: true,
                    tension: 0.35,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#e5e7eb'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 8
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // =========================
    // CHART PENJUALAN PER HARI
    // =========================
    const ctxHari = document.getElementById('chartPenjualanPerHari');

    if (ctxHari) {
        new Chart(ctxHari, {
            type: 'bar',
            data: {
                labels: @json($hariLabels),
                datasets: [{
                    label: 'Jumlah Penjualan',
                    data: @json($hariData),
                    backgroundColor: 'rgba(79, 209, 197, 0.75)',
                    borderColor: '#4fd1c5',
                    borderWidth: 1.5,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        },
                        grid: {
                            color: '#e5e7eb'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
});
</script>
@endpush