@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Kasir')
@section('page_title', 'Kasir')
@section('page_subtitle', 'Transaksi penjualan produk.')

@section('content')
    <div class="grid grid-cols-12 gap-4 min-h-[calc(100vh-140px)]">

        <!-- Kiri -->
        <div class="col-span-12 xl:col-span-9">
            <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-200">

                <!-- Search Bar -->
                <div class="bg-blue-600 px-4 py-3 flex items-center gap-3">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            placeholder="Tulis nama, kode, zat aktif, atau kategori produk [Shift + q]"
                            class="w-full rounded-full bg-white text-gray-700 placeholder:text-gray-400 px-5 py-2.5 pr-12 text-sm focus:outline-none"
                        >
                        <button
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center"
                        >
                            <i class="fas fa-arrow-left"></i>
                        </button>
                    </div>

                    <button type="button" class="text-white text-lg">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <div class="text-white text-right min-w-[110px]">
                        <p class="text-sm font-semibold">Rp.</p>
                        <p class="text-3xl font-bold leading-none">0,00</p>
                    </div>
                </div>

                <!-- Table Header -->
                <div class="px-4 pt-6">
                    <div class="grid grid-cols-7 text-sm font-semibold text-gray-500 dark:text-gray-400 pb-4 border-b border-gray-100 dark:border-gray-800">
                        <div>No.</div>
                        <div>Produk</div>
                        <div>Kuantitas</div>
                        <div>Satuan</div>
                        <div>Opsi Harga</div>
                        <div>Harga Jual</div>
                        <div>Sub Total</div>
                    </div>
                </div>

                <!-- Empty State -->
                <div class="px-4 pb-4">
                    <div class="min-h-[520px] rounded-b-xl bg-gray-50 dark:bg-gray-900 flex items-start justify-center pt-6 text-gray-700 dark:text-gray-200 transition-colors duration-200">
                        Silahkan Pilih Produk
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan -->
        <div class="col-span-12 xl:col-span-3 space-y-3">

            <!-- Ringkasan -->
            <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 transition-colors duration-200">
                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between gap-3">
                        <label class="font-medium">Sub-total</label>
                        <input type="text" value="0" class="w-32 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-1.5 text-right text-sm">
                    </div>

                    <div class="flex items-center justify-between gap-3 text-sm">
                        <span class="font-medium text-blue-600">Promo hari ini?</span>
                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-red-500 text-white text-xs font-bold">0</span>
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <div>
                            <label class="font-medium">Biaya Servis</label>
                            <div class="mt-1">
                                <span class="inline-block px-2 py-0.5 rounded bg-blue-600 text-white text-[10px]">Ctrl + a</span>
                            </div>
                        </div>
                        <input type="text" value="0" class="w-32 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-1.5 text-right text-sm">
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="font-medium">Biaya Embalase</label>
                        <input type="text" value="0" class="w-32 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-1.5 text-right text-sm">
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="font-medium">Ongkos Kirim</label>
                        <input type="text" value="0" class="w-32 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-1.5 text-right text-sm">
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="font-medium">Biaya Lainnya</label>
                        <input type="text" value="0" class="w-32 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-1.5 text-right text-sm">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 mt-5">
                    <button type="button" class="w-full rounded-lg bg-teal-500 hover:bg-teal-600 text-white py-2.5 font-semibold transition-colors duration-200">
                        Bayar <span class="text-[11px] bg-blue-600 px-1.5 py-0.5 rounded">F2</span>
                    </button>

                    <button type="button" class="w-full rounded-lg bg-blue-600 hover:bg-blue-700 text-white py-2.5 font-semibold transition-colors duration-200">
                        Tunda <span class="text-[11px] bg-blue-800 px-1.5 py-0.5 rounded">F4</span>
                    </button>
                </div>
            </div>

            <!-- Pelanggan -->
            <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 px-4 py-4 flex items-center justify-between transition-colors duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="font-medium">
                        Pelanggan
                        <span class="ml-1 text-[10px] bg-blue-600 text-white px-1.5 py-0.5 rounded">F7</span>
                    </div>
                </div>
                <button type="button" class="text-xl font-bold">+</button>
            </div>

            <!-- Dokter -->
            <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 px-4 py-4 flex items-center justify-between transition-colors duration-200">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-500">
                        <i class="fas fa-user-doctor"></i>
                    </div>
                    <div class="font-medium">
                        Dokter
                        <span class="ml-1 text-[10px] bg-blue-600 text-white px-1.5 py-0.5 rounded">F6</span>
                    </div>
                </div>
                <button type="button" class="text-xl font-bold">+</button>
            </div>

            <!-- Form kanan bawah -->
            <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 space-y-3 transition-colors duration-200">
                <div class="grid grid-cols-2 gap-3 items-center">
                    <label class="text-sm font-medium">Sales/Pelayan</label>
                    <select class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm">
                        <option>Pilih Sales</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3 items-center">
                    <label class="text-sm font-medium">Kanal Penjualan</label>
                    <select class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm">
                        <option>Offline</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-3 items-center">
                    <label class="text-sm font-medium">Kode Invoice Eksternal</label>
                    <input type="text" class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm">
                </div>

                <div class="grid grid-cols-2 gap-3 items-center">
                    <label class="text-sm font-medium">Catatan</label>
                    <input type="text" class="rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-3 py-2 text-sm">
                </div>
            </div>

            <div class="flex justify-center">
                <button type="button" class="px-6 py-2 rounded-lg bg-gray-600 text-white text-xs font-semibold">
                    Perlu Petunjuk?
                </button>
            </div>
        </div>
    </div>
@endsection