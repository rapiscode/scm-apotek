@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Master Produk')
@section('page_title', 'Master Produk')
@section('page_subtitle', 'Kelola data master produk.')

@section('content')
    <div class="space-y-4">
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 transition-colors duration-200">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-4">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Master Produk</h2>

                <div class="flex items-center gap-2 flex-wrap">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-file-pen"></i>
                        Ubah Sekaligus
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-file-circle-plus"></i>
                        Tambah Sekaligus
                    </button>

                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-circle-plus"></i>
                        Produk Baru
                    </button>
                </div>
            </div>

            <!-- Search + action -->
            <div class="flex items-center justify-between gap-3 flex-wrap mb-3">
                <div class="relative w-full max-w-xs">
                    <input
                        type="text"
                        placeholder="Cari data"
                        class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-bars-staggered text-sm"></i>
                        <i class="fas fa-search text-sm"></i>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-filter text-sm"></i>
                        <span>Filter</span>
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-white text-xs font-semibold">0</span>
                    </button>

                    <button
                        type="button"
                        class="w-10 h-10 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-sparkles"></i>
                    </button>

                    <button
                        type="button"
                        class="w-10 h-10 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>

            <!-- Tabel -->
            <div class="rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden">
                <div class="overflow-x-auto max-h-[620px] overflow-y-auto">
                    <table class="min-w-[1900px] w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap w-16">No.</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[300px]">Nama</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[150px]">Kode Produk (SKU)</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">Barcode</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[200px]">Nama Pabrik</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[130px]">Satuan Utama</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[130px]">Semua Satuan</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[160px]">Referensi Harga Beli</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[150px]">Harga Jual Utama</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[160px]">Opsi Harga Jual</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[100px]">Rak</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[130px]">Stok Minimal</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[100px]">Status</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[180px]">Catatan Lainnya</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-950">
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td colspan="15" class="text-center py-20 text-gray-500 dark:text-gray-400">
                                    Data tidak ditemukan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kondisi Produk -->
            <div class="mt-3 rounded-xl border border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-950 overflow-hidden transition-colors duration-200">
                <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-2xl font-bold text-blue-700 dark:text-blue-400">Kondisi Produk</h3>
                    <button type="button" class="text-gray-700 dark:text-gray-300">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 py-4 text-sm text-gray-700 dark:text-gray-200">
                    <div class="flex items-center justify-between">
                        <span>Produk Dijual</span>
                        <span>: 0 produk</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>Produk Tidak Dijual</span>
                        <span>: 0 produk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection