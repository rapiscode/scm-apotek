@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Riwayat Update')
@section('page_title', 'Riwayat Update')
@section('page_subtitle', 'Lihat pembaruan sistem terbaru.')

@section('content')
<div class="w-full">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 min-h-[calc(100vh-140px)]">

        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 flex items-center justify-center rounded-xl bg-green-100 text-green-600">
                <i class="fas fa-rotate"></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold">Riwayat Update Sistem</h2>
                <p class="text-sm text-gray-500">Daftar perubahan dan fitur pada aplikasi.</p>
            </div>
        </div>

        <div class="border rounded-xl p-5">
            <div class="flex justify-between items-start mb-3">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100">
                    Versi 1.0.0
                </h3>
                <span class="text-sm text-gray-500">
                    15 Maret 2026
                </span>
            </div>

            <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600 dark:text-gray-300">
                <li>Rilis awal sistem Apotek Saya.</li>
                <li>Dashboard ringkasan sistem.</li>
                <li>Transaksi penjualan melalui halaman kasir.</li>
                <li>Daftar riwayat penjualan.</li>
                <li>Fitur penjualan tertunda.</li>
                <li>Pembayaran QRIS statis.</li>
                <li>Manajemen persediaan dan stok produk.</li>
                <li>Stok opname dan penyesuaian stok.</li>
                <li>Master data produk, satuan, rak, dan gudang.</li>
                <li>Manajemen pengguna dan hak akses.</li>
                <li>Pusat bantuan untuk usulan fitur.</li>
            </ul>
        </div>

    </div>
</div>
@endsection