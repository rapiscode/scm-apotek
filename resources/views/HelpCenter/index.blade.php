@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Help Center')
@section('page_title', 'Help Center')
@section('page_subtitle', 'Pusat bantuan dan informasi penggunaan aplikasi.')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <i class="fas fa-circle-question text-green-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">FAQ</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pertanyaan yang sering ditanyakan pengguna.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Bagaimana cara menambah produk?</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Masuk ke menu Master Data lalu pilih Master Produk untuk menambahkan data produk baru.</p>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Bagaimana cara menunda transaksi?</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Di halaman Kasir, pilih produk lalu klik tombol Tunda untuk menyimpan transaksi sementara.</p>
                </div>

                <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">Bagaimana cara melihat QRIS?</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">Masuk ke menu Penjualan lalu pilih QRIS untuk menampilkan QR code pembayaran.</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Panduan Singkat</h2>
            <ol class="space-y-3 text-sm text-gray-600 dark:text-gray-300 list-decimal pl-5">
                <li>Kelola data produk melalui menu Master Data.</li>
                <li>Lakukan transaksi di halaman Kasir.</li>
                <li>Pantau stok melalui menu Persediaan.</li>
                <li>Gunakan Pusat Bantuan jika menemukan kendala.</li>
            </ol>
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Kontak Bantuan</h3>
            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                <p><span class="font-semibold">Email:</span> refree06@gmail.com</p>
                <p><span class="font-semibold">WhatsApp:</span> 0813-9835-7731</p>
                <p><span class="font-semibold">Jam Layanan:</span> 08.00 - 17.00</p>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Tentang Aplikasi</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Apotek Saya adalah sistem manajemen apotek yang membantu pengelolaan penjualan, persediaan, master data, dan layanan bantuan dalam satu dashboard.
            </p>
        </div>
    </div>
</div>
@endsection