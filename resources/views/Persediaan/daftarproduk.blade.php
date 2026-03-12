@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Daftar Produk')
@section('page_title', 'Daftar Produk')
@section('page_subtitle', 'Kelola daftar produk persediaan.')

@section('content')
    <div class="h-[calc(100vh-9rem)]">
        <div class="relative z-0 bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 h-full flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-3">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Daftar Produk</h2>

                <div class="flex items-center gap-2 flex-wrap">
                    <button
                        type="button"
                        id="openCetakBarcodeDrawer"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-qrcode"></i>
                        Cetak Barcode
                    </button>

                    <button
                        type="button"
                        id="openTambahProdukModal"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-circle-plus"></i>
                        Tambah Produk
                    </button>
                </div>
            </div>

            <!-- Search + Action -->
            <div class="flex items-center justify-between gap-3 flex-wrap mb-2">
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
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 flex items-center justify-between rounded-lg bg-green-100 text-green-700 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>

                    <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            @endif

            <!-- Table -->
            <div class="rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden flex-1 flex flex-col">
                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="min-w-[1700px] w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 sticky top-0 z-10">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap w-16">No.</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[420px]">
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fas fa-arrow-up text-green-600 text-xs"></i>
                                        Nama
                                    </span>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[60px]">
                                    <i class="fas fa-search text-xs text-gray-400"></i>
                                </th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[100px]">Rak</th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[60px]">
                                    <i class="fas fa-search text-xs text-gray-400"></i>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[100px]">
                                    Stok
                                    <i class="fas fa-circle-info text-sky-500 text-xs ml-1"></i>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[60px]">
                                    <i class="fas fa-sort text-xs text-gray-400"></i>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">
                                    Harga Pokok
                                    <i class="fas fa-circle-info text-sky-500 text-xs ml-1"></i>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">Harga Jual</th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[60px]">
                                    <i class="fas fa-search text-xs text-gray-400"></i>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[100px]">Status</th>
                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-950">
                            @forelse ($produks as $index => $produk)
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-4 align-top">{{ $index + 1 }}</td>

                                    <td class="px-4 py-4 align-top min-w-[420px]">
                                        <div class="font-medium text-gray-800 dark:text-gray-100">
                                            {{ $produk->nama_produk }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            SKU: {{ $produk->sku }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-center align-top text-gray-400">
                                        <i class="fas fa-search text-xs"></i>
                                    </td>

                                    <td class="px-4 py-4 align-top text-gray-700 dark:text-gray-200">
                                        {{ $produk->rak_penyimpanan ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4 text-center align-top text-gray-400">
                                        <i class="fas fa-search text-xs"></i>
                                    </td>

                                    <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                        {{ $produk->stok ?? 0 }}
                                    </td>

                                    <td class="px-4 py-4 text-center align-top text-gray-400">
                                        <i class="fas fa-sort text-xs"></i>
                                    </td>

                                    <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                        {{ number_format($produk->harga_beli ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                        {{ number_format($produk->harga_jual ?? 0, 0, ',', '.') }}
                                    </td>

                                    <td class="px-4 py-4 text-center align-top text-gray-400">
                                        <i class="fas fa-search text-xs"></i>
                                    </td>

                                    <td class="px-4 py-4 text-center align-top">
                                        @if ($produk->status_penjualan === 'dijual')
                                            <span class="inline-flex items-center px-2 py-1 rounded bg-green-500 text-white text-[11px] font-semibold leading-none">
                                                Dijual
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded bg-red-500 text-white text-[11px] font-semibold leading-none">
                                                Tidak Dijual
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4 text-center align-top">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                type="button"
                                                class="px-3 py-1.5 rounded-lg border border-blue-300 text-blue-600 text-xs font-semibold hover:bg-blue-50 transition-colors duration-200"
                                            >
                                                Kartu Stok
                                            </button>

                                            <button
                                                type="button"
                                                class="w-8 h-8 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors duration-200"
                                            >
                                                <i class="fas fa-ellipsis-vertical"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <td colspan="12" class="text-center py-24 text-gray-500 dark:text-gray-400">
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Tambah Produk -->
<div id="tambahProdukModal" class="fixed inset-0 z-[9999] hidden">
    <div id="tambahProdukOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-8">
        <form
            id="tambahProdukForm"
            method="POST"
            action="{{ route('persediaan.daftarproduk.store') }}"
            class="relative z-[10000] w-full max-w-[650px] h-[92vh] bg-white dark:bg-gray-950 rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf

            <!-- Header -->
            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white leading-none">Tambah Produk</h3>
                <button
                    type="button"
                    id="closeTambahProdukModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto px-8 py-6 space-y-6 bg-white dark:bg-gray-950 transition-colors duration-200">
                <!-- Informasi Dasar -->
                <div>
                    <h4 class="text-2xl font-bold text-blue-700 dark:text-blue-400 mb-3">Informasi Dasar Produk</h4>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Tipe Produk</label>

                        <input type="hidden" name="tipe_produk" id="tipeProdukValuePersediaan" value="umum">

                        <div class="grid grid-cols-4 rounded-lg overflow-hidden border border-blue-600 w-full">
                            <button
                                type="button"
                                data-tipe="umum"
                                class="tipe-produk-btn-persediaan px-3 py-2 text-sm font-semibold border-r border-blue-600 transition-all duration-200 bg-blue-600 text-white"
                            >
                                Umum
                            </button>

                            <button
                                type="button"
                                data-tipe="obat"
                                class="tipe-produk-btn-persediaan px-3 py-2 text-sm font-semibold border-r border-blue-600 transition-all duration-200 bg-white text-blue-600 hover:bg-blue-50"
                            >
                                Obat
                            </button>

                            <button
                                type="button"
                                data-tipe="alkes"
                                class="tipe-produk-btn-persediaan px-3 py-2 text-sm font-semibold border-r border-blue-600 transition-all duration-200 bg-white text-blue-600 hover:bg-blue-50"
                            >
                                Alkes
                            </button>

                            <button
                                type="button"
                                data-tipe="jasa"
                                class="tipe-produk-btn-persediaan px-3 py-2 text-sm font-semibold transition-all duration-200 bg-white text-blue-600 hover:bg-blue-50"
                            >
                                Jasa
                            </button>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Produk *</label>
                            <input
                                type="text"
                                id="namaProdukInputPersediaan"
                                name="nama_produk"
                                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Pabrik</label>
                            <input
                                type="text"
                                name="nama_pabrik"
                                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">SKU (Kode Produk) *</label>
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    id="skuInputPersediaan"
                                    name="sku"
                                    class="flex-1 rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                                >
                                <button
                                    type="button"
                                    id="generateSkuBtnPersediaan"
                                    class="w-11 h-11 rounded-lg bg-blue-600 text-white flex items-center justify-center transition-all duration-200 hover:bg-blue-700 active:scale-95"
                                >
                                    <i class="fas fa-rotate-right"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Barcode</label>
                            <input
                                type="text"
                                name="barcode"
                                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Pajak</label>
                            <select
                                name="pajak"
                                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                            >
                                <option value="PPN">PPN</option>
                                <option value="Non PPN">Non PPN</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Satuan Utama *</label>

                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <input
                                        type="text"
                                        id="satuanUtamaSearchPersediaan"
                                        placeholder="Pilih / cari satuan"
                                        autocomplete="off"
                                        class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                                    >

                                    <input type="hidden" name="satuan_utama" id="satuanUtamaValuePersediaan">

                                    <button
                                        type="button"
                                        id="toggleSatuanDropdownPersediaan"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                                    >
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </button>

                                    <div
                                        id="satuanUtamaDropdownPersediaan"
                                        class="hidden absolute z-[10020] mt-2 w-full rounded-xl border border-gray-200 bg-white shadow-lg overflow-hidden"
                                    >
                                        <div id="satuanUtamaListPersediaan" class="max-h-56 overflow-y-auto py-1">
                                            @forelse ($satuans as $satuan)
                                                <button
                                                    type="button"
                                                    class="satuan-option-persediaan w-full text-left px-4 py-2 text-sm hover:bg-blue-50 text-gray-700"
                                                    data-value="{{ $satuan->nama_satuan }}"
                                                >
                                                    {{ $satuan->nama_satuan }}
                                                </button>
                                            @empty
                                                <div class="px-4 py-3 text-sm text-gray-500">
                                                    Belum ada data satuan
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    class="w-11 h-11 rounded-lg bg-blue-600 text-white text-xl font-bold flex items-center justify-center transition-all duration-200 hover:bg-blue-700 active:scale-95"
                                >
                                    +
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Harga Produk -->
                <div>
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-2xl font-bold text-blue-700">Harga Produk</h4>
                    </div>

                    <div class="space-y-4">
                        <div class="rounded-md bg-sky-200 text-sky-900 text-xs px-3 py-2 transition-colors duration-200">
                            Semua harga adalah per SATUAN UTAMA.
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Referensi Harga Pokok/Modal</label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-700">Rp.</span>
                                <input
                                    type="number"
                                    name="harga_beli"
                                    min="0"
                                    step="0.01"
                                    class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                                >
                                <span class="text-sm text-gray-700">0</span>
                                <span class="text-sm text-gray-700">/</span>
                            </div>
                        </div>

                        <div class="rounded-md bg-sky-200 text-sky-900 text-xs px-3 py-2 transition-colors duration-200">
                            Harga pokok default yang dapat membantu untuk penentuan harga jual. BUKAN untuk penghitungan laba/rugi.
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hrg Jual Utama</label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-700">Rp.</span>
                                <input
                                    type="number"
                                    name="harga_jual"
                                    min="0"
                                    step="0.01"
                                    class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                                >
                                <span class="text-sm text-gray-700">0</span>
                                <span class="text-sm text-gray-700">/</span>
                            </div>
                        </div>

                        <!-- Stok Persediaan -->
                        <div>
                            <h4 class="text-2xl font-bold text-blue-700 mb-3">Stok Persediaan</h4>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimal</label>
                                    <div class="flex">
                                        <input
                                            type="number"
                                            name="stok_minimal"
                                            value="0"
                                            class="w-full rounded-l-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        >
                                        <span class="inline-flex items-center px-4 rounded-r-xl border border-l-0 border-gray-300 bg-gray-100 text-sm text-gray-700">
                                            satuan
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Maksimal</label>
                                    <div class="flex">
                                        <input
                                            type="number"
                                            name="stok_maksimal"
                                            value="0"
                                            class="w-full rounded-l-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                                        >
                                        <span class="inline-flex items-center px-4 rounded-r-xl border border-l-0 border-gray-300 bg-gray-100 text-sm text-gray-700">
                                            satuan
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div>
                            <h4 class="text-2xl font-bold text-blue-700 mb-3">Informasi Tambahan</h4>

                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Rak Penyimpanan</label>

                                    <div class="flex gap-2">
                                        <div class="relative flex-1">
                                            <input
                                                type="text"
                                                id="rakPenyimpananSearchPersediaan"
                                                placeholder="Pilih / cari lokasi rak penyimpanan"
                                                autocomplete="off"
                                                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                                            >

                                            <input type="hidden" name="rak_penyimpanan" id="rakPenyimpananValuePersediaan">

                                            <button
                                                type="button"
                                                id="toggleRakDropdownPersediaan"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500"
                                            >
                                                <i class="fas fa-chevron-down text-sm"></i>
                                            </button>

                                            <div
                                                id="rakPenyimpananDropdownPersediaan"
                                                class="hidden absolute z-[10020] mt-2 w-full rounded-xl border border-gray-200 bg-white shadow-lg overflow-hidden"
                                            >
                                                <div id="rakPenyimpananListPersediaan" class="max-h-56 overflow-y-auto py-1">
                                                    @forelse ($raks as $rak)
                                                        <button
                                                            type="button"
                                                            class="rak-option-persediaan w-full text-left px-4 py-2 text-sm hover:bg-blue-50 text-gray-700"
                                                            data-value="{{ $rak->nama_rak }}"
                                                        >
                                                            {{ $rak->nama_rak }}
                                                        </button>
                                                    @empty
                                                        <div class="px-4 py-3 text-sm text-gray-500">
                                                            Belum ada data rak
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            type="button"
                                            class="w-11 h-11 rounded-lg bg-blue-600 text-white text-xl font-bold flex items-center justify-center transition-all duration-200 hover:bg-blue-700 active:scale-95"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Penjualan</label>

                                    <input type="hidden" name="status_penjualan" id="statusPenjualanValuePersediaan" value="dijual">

                                    <div class="grid grid-cols-2 rounded-xl overflow-hidden border border-blue-600 w-full">
                                        <button
                                            type="button"
                                            data-status-penjualan="dijual"
                                            class="status-penjualan-btn-persediaan px-4 py-3 text-sm font-semibold transition-all duration-200 bg-blue-600 text-white border-r border-blue-600"
                                        >
                                            Dijual
                                        </button>

                                        <button
                                            type="button"
                                            data-status-penjualan="tidak_dijual"
                                            class="status-penjualan-btn-persediaan px-4 py-3 text-sm font-semibold transition-all duration-200 bg-white text-blue-600 hover:bg-blue-50"
                                        >
                                            Tidak Dijual
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Lainnya</label>
                                    <input
                                        type="text"
                                        name="catatan"
                                        class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 transition-colors duration-200"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-end gap-3 bg-white sticky bottom-0 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelTambahProdukModal"
                    class="px-5 py-2.5 rounded-lg text-gray-400 font-semibold hover:text-gray-600 transition-colors duration-200"
                >
                    Kembali
                </button>

                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Drawer Cetak Barcode -->
<div id="cetakBarcodeDrawer" class="fixed inset-0 z-[10050] hidden bg-white">
    <div class="h-full flex flex-col">
        <!-- Header -->
        <div id="barcodeDrawerHeader" class="bg-blue-600 text-white px-5 py-4 flex items-center justify-between shrink-0">
            <button
                type="button"
                id="closeCetakBarcodeDrawer"
                class="text-white text-2xl"
            >
                <i class="fas fa-arrow-left"></i>
            </button>

            <h3 class="text-2xl font-bold text-center flex-1">Cetak Barcode</h3>

            <button
                type="button"
                id="openPrintPreviewBtn"
                class="px-6 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold"
            >
                Cetak
            </button>
        </div>

        <!-- Content -->
        <div id="barcodeConfigView" class="flex-1 overflow-auto bg-white">
            <!-- Filter Atas -->
            <div class="px-5 py-4 border-b border-gray-200">
                <div class="space-y-4">
                    <!-- BARIS INPUT -->
                    <div class="grid grid-cols-1 xl:grid-cols-12 gap-3 items-end">
                        <div class="xl:col-span-1 relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kertas</label>

                            <div class="relative">
                                <button
                                    type="button"
                                    id="jenisKertasButton"
                                    class="w-full h-11 px-4 rounded-xl border border-gray-400 bg-white text-sm text-left text-gray-700 flex items-center justify-between focus:outline-none"
                                >
                                    <span id="jenisKertasText">Label</span>
                                    <i id="jenisKertasIcon" class="fas fa-chevron-up text-xs text-gray-500 transition-transform duration-200"></i>
                                </button>

                                <input type="hidden" id="jenisKertasValue" value="Label" name="jenis_kertas">

                                <div
                                    id="jenisKertasDropdown"
                                    class="hidden absolute left-0 top-full mt-2 w-full rounded-2xl bg-white shadow-lg border border-gray-100 overflow-hidden z-[10080]"
                                >
                                    <button
                                        type="button"
                                        class="jenis-kertas-option w-full text-left px-5 py-3 text-sm text-gray-700 hover:bg-gray-50"
                                        data-value="Label"
                                    >
                                        Label
                                    </button>

                                    <button
                                        type="button"
                                        class="jenis-kertas-option w-full text-left px-5 py-3 text-sm text-gray-700 hover:bg-gray-50"
                                        data-value="Biasa"
                                    >
                                        Biasa
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="xl:col-span-2 relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ukuran Label</label>

                            <div class="relative">
                                <button
                                    type="button"
                                    id="ukuranLabelButton"
                                    class="w-full h-11 px-4 rounded-xl border border-gray-400 bg-white text-sm text-left text-gray-700 flex items-center justify-between focus:outline-none"
                                >
                                    <span id="ukuranLabelText">33 × 15 mm</span>
                                    <i id="ukuranLabelIcon" class="fas fa-chevron-up text-xs text-gray-500 transition-transform duration-200"></i>
                                </button>

                                <input type="hidden" id="ukuranLabelValue" name="ukuran_label" value="33x15">

                                <div
                                    id="ukuranLabelDropdown"
                                    class="hidden absolute left-0 top-full mt-2 w-full rounded-2xl bg-white shadow-lg border border-gray-100 overflow-hidden z-[10080]"
                                >
                                    <button type="button" class="ukuran-label-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100" data-value="33x15">
                                        33 × 15 mm
                                    </button>

                                    <button type="button" class="ukuran-label-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100" data-value="38x18">
                                        38 × 18 mm
                                    </button>

                                    <button type="button" class="ukuran-label-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100" data-value="40x30">
                                        40 × 30 mm
                                    </button>

                                    <button type="button" class="ukuran-label-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100" data-value="100x50">
                                        100 × 50 mm
                                    </button>

                                    <button type="button" class="ukuran-label-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100" data-value="custom">
                                        custom
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="xl:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Line</label>
                            <div class="flex rounded-lg overflow-hidden border border-gray-300">
                                <input type="number" value="1" class="w-full min-w-0 px-3 py-2 text-sm focus:outline-none">
                                <span class="inline-flex items-center px-2 bg-gray-100 text-sm text-gray-700 border-l border-gray-300">line</span>
                            </div>
                        </div>

                        <div class="xl:col-span-2 relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Sumber Kode</label>

                            <div class="relative">
                                <button
                                    type="button"
                                    id="sumberKodeButton"
                                    class="w-full h-11 px-4 rounded-xl border border-gray-400 bg-white text-sm text-left text-gray-700 flex items-center justify-between focus:outline-none"
                                >
                                    <span id="sumberKodeText">Data Barcode</span>
                                    <i id="sumberKodeIcon" class="fas fa-chevron-up text-xs text-gray-500 transition-transform duration-200"></i>
                                </button>

                                <input type="hidden" id="sumberKodeValue" name="sumber_kode" value="barcode">

                                <div
                                    id="sumberKodeDropdown"
                                    class="hidden absolute left-0 top-full mt-2 w-full rounded-2xl bg-white shadow-lg border border-gray-100 overflow-hidden z-[10080]"
                                >
                                    <button
                                        type="button"
                                        class="sumber-kode-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100"
                                        data-value="barcode"
                                    >
                                        Data Barcode
                                    </button>

                                    <button
                                        type="button"
                                        class="sumber-kode-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100"
                                        data-value="sku"
                                    >
                                        Kode Produk (SKU)
                                    </button>

                                    <button
                                        type="button"
                                        class="sumber-kode-option w-full text-left px-5 py-3 text-sm hover:bg-gray-100"
                                        data-value="barcode_or_sku"
                                    >
                                        Data Barcode atau SKU
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- blok jenis kode + checkbox di sini -->
                        <div class="xl:col-span-6">
                            <div class="flex items-end gap-6 flex-wrap">
                                <div class="w-[160px] shrink-0">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kode</label>
                                    <select class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                                        <option>Barcode</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-x-6 gap-y-2 flex-wrap pb-2">
                                    <label class="flex items-center gap-2 text-sm text-gray-700 whitespace-nowrap">
                                        <input id="showNamaProduk" type="checkbox" checked class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-200">
                                        <span>Nama Produk</span>
                                    </label>

                                    <label class="flex items-center gap-2 text-sm text-gray-700 whitespace-nowrap">
                                        <input id="showNamaOutlet" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-200">
                                        <span>Nama Outlet</span>
                                    </label>

                                    <label class="flex items-center gap-2 text-sm text-gray-700 whitespace-nowrap">
                                        <input id="showTeksKode" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-200">
                                        <span>Teks Kode</span>
                                    </label>

                                    <label class="flex items-center gap-2 text-sm text-gray-700 whitespace-nowrap">
                                        <input id="showHargaProduk" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-200">
                                        <span>Harga Produk</span>
                                    </label>

                                    <label class="flex items-center gap-2 text-sm text-gray-700 whitespace-nowrap">
                                        <input id="showSatuan" type="checkbox" class="w-4 h-4 rounded border-gray-300 text-blue-600 focus:ring-blue-200">
                                        <span>Satuan</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel -->
            <div class="border-t border-gray-200">
                <!-- Header Kolom -->
                <div class="grid grid-cols-12 gap-4 px-5 py-4 bg-gray-50 text-sm font-semibold text-gray-700 border-b border-gray-200">
                    <div class="col-span-1">No.</div>
                    <div class="col-span-3">Produk</div>
                    <div class="col-span-1">Satuan</div>
                    <div class="col-span-2">Opsi Harga</div>
                    <div class="col-span-1">Harga Jual</div>
                    <div class="col-span-3">Preview</div>
                    <div class="col-span-1">Kuantitas</div>
                </div>

                <!-- Body -->
                <div id="barcodeTableBody" class="divide-y divide-gray-200"></div>
            </div>
        </div>

        <div id="barcodePrintPreviewView"
            class="hidden absolute inset-0 z-[10060] bg-[#f3f6fb]">
            <div class="w-full h-full flex flex-col">
                <!-- Header Preview -->
                <div class="bg-blue-600 text-white px-4 py-3 flex items-center justify-between gap-4 shrink-0">
                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            id="backToConfigBtn"
                            class="text-white text-2xl"
                        >
                            <i class="fas fa-arrow-left"></i>
                        </button>

                        <h3 class="text-2xl font-bold">Cetak Barcode</h3>
                    </div>

                    <div class="flex items-center gap-2">
                        <div>
                            <label class="block text-[11px] text-white/80 mb-1">Lebar Barcode</label>
                            <input
                                type="number"
                                id="barcodeWidthInput"
                                value="1.2"
                                step="0.1"
                                class="w-48 rounded-lg border border-white/30 bg-white text-gray-700 px-3 py-2 text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-[11px] text-white/80 mb-1">Tinggi Barcode</label>
                            <input
                                type="number"
                                id="barcodeHeightInput"
                                value="30"
                                step="1"
                                class="w-48 rounded-lg border border-white/30 bg-white text-gray-700 px-3 py-2 text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-[11px] text-white/80 mb-1">Ukuran Text</label>
                            <input
                                type="number"
                                id="barcodeFontSizeInput"
                                value="10"
                                step="1"
                                class="w-44 rounded-lg border border-white/30 bg-white text-gray-700 px-3 py-2 text-sm"
                            >
                        </div>

                        <button
                            type="button"
                            id="resetBarcodePreviewBtn"
                            class="mt-5 px-4 py-2 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-semibold"
                        >
                            Default
                        </button>

                        <button
                            type="button"
                            id="printBarcodeBtn"
                            class="mt-5 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold"
                        >
                            Cetak
                        </button>
                    </div>
                </div>

                <!-- Area Preview -->
                <div id="barcodePrintCanvas"
                    class="flex-1 p-4 overflow-auto bg-white">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // =========================
    // MODAL TAMBAH PRODUK
    // =========================
    const openTambahProdukModalBtn = document.getElementById('openTambahProdukModal');
    const tambahProdukModal = document.getElementById('tambahProdukModal');
    const tambahProdukOverlay = document.getElementById('tambahProdukOverlay');
    const closeTambahProdukModalBtn = document.getElementById('closeTambahProdukModal');
    const cancelTambahProdukModalBtn = document.getElementById('cancelTambahProdukModal');

    function openTambahProdukModal() {
        if (!tambahProdukModal) return;
        tambahProdukModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTambahProdukModal() {
        if (!tambahProdukModal) return;
        tambahProdukModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    openTambahProdukModalBtn?.addEventListener('click', openTambahProdukModal);
    closeTambahProdukModalBtn?.addEventListener('click', closeTambahProdukModal);
    cancelTambahProdukModalBtn?.addEventListener('click', closeTambahProdukModal);
    tambahProdukOverlay?.addEventListener('click', closeTambahProdukModal);

    @if($errors->any())
        openTambahProdukModal();
    @endif

    // =========================
    // TIPE PRODUK
    // =========================
    const tipeProdukButtons = document.querySelectorAll('.tipe-produk-btn-persediaan');
    const tipeProdukValue = document.getElementById('tipeProdukValuePersediaan');

    function setActiveTipeProduk(selectedValue) {
        tipeProdukButtons.forEach((btn) => {
            const isActive = btn.dataset.tipe === selectedValue;

            if (isActive) {
                btn.classList.remove('bg-white', 'text-blue-600', 'hover:bg-blue-50');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'text-blue-600', 'hover:bg-blue-50');
            }
        });

        if (tipeProdukValue) {
            tipeProdukValue.value = selectedValue;
        }
    }

    tipeProdukButtons.forEach((btn) => {
        btn.addEventListener('click', function () {
            setActiveTipeProduk(this.dataset.tipe);
        });
    });

    setActiveTipeProduk('umum');

    // =========================
    // STATUS PENJUALAN
    // =========================
    const statusPenjualanButtons = document.querySelectorAll('.status-penjualan-btn-persediaan');
    const statusPenjualanValue = document.getElementById('statusPenjualanValuePersediaan');

    function setActiveStatusPenjualan(selectedValue) {
        statusPenjualanButtons.forEach((btn) => {
            const isActive = btn.dataset.statusPenjualan === selectedValue;

            if (isActive) {
                btn.classList.remove('bg-white', 'text-blue-600', 'hover:bg-blue-50');
                btn.classList.add('bg-blue-600', 'text-white');
            } else {
                btn.classList.remove('bg-blue-600', 'text-white');
                btn.classList.add('bg-white', 'text-blue-600', 'hover:bg-blue-50');
            }
        });

        if (statusPenjualanValue) {
            statusPenjualanValue.value = selectedValue;
        }
    }

    statusPenjualanButtons.forEach((btn) => {
        btn.addEventListener('click', function () {
            setActiveStatusPenjualan(this.dataset.statusPenjualan);
        });
    });

    setActiveStatusPenjualan('dijual');

    // =========================
    // GENERATE SKU
    // =========================
    const namaProdukInput = document.getElementById('namaProdukInputPersediaan');
    const skuInput = document.getElementById('skuInputPersediaan');
    const generateSkuBtn = document.getElementById('generateSkuBtnPersediaan');

    function getPrefixFromKategori(tipe) {
        switch (tipe) {
            case 'obat': return 'OB';
            case 'alkes': return 'AL';
            case 'jasa': return 'JS';
            default: return 'UM';
        }
    }

    function singkatanNamaProduk(nama) {
        return nama
            .toUpperCase()
            .replace(/[^A-Z0-9\s]/g, '')
            .trim()
            .split(/\s+/)
            .filter(Boolean)
            .map(word => word[0])
            .join('');
    }

    function generateSku() {
        if (!skuInput) return;

        const tipe = tipeProdukValue ? tipeProdukValue.value : 'umum';
        const nama = namaProdukInput ? namaProdukInput.value : '';
        const prefix = getPrefixFromKategori(tipe);
        const singkatan = singkatanNamaProduk(nama);

        skuInput.value = singkatan ? `${prefix}-${singkatan}` : `${prefix}-`;
    }

    generateSkuBtn?.addEventListener('click', generateSku);
    namaProdukInput?.addEventListener('input', generateSku);

    // =========================
    // SEARCHABLE DROPDOWN SATUAN
    // =========================
    const satuanUtamaSearch = document.getElementById('satuanUtamaSearchPersediaan');
    const satuanUtamaValue = document.getElementById('satuanUtamaValuePersediaan');
    const satuanUtamaDropdown = document.getElementById('satuanUtamaDropdownPersediaan');
    const toggleSatuanDropdown = document.getElementById('toggleSatuanDropdownPersediaan');

    function openSatuanDropdown() {
        satuanUtamaDropdown?.classList.remove('hidden');
    }

    function closeSatuanDropdown() {
        satuanUtamaDropdown?.classList.add('hidden');
    }

    function filterSatuanOptions(keyword = '') {
        const options = document.querySelectorAll('.satuan-option-persediaan');
        const search = keyword.toLowerCase().trim();

        options.forEach((option) => {
            const text = option.dataset.value.toLowerCase();
            option.classList.toggle('hidden', !text.includes(search));
        });
    }

    satuanUtamaSearch?.addEventListener('focus', function () {
        openSatuanDropdown();
        filterSatuanOptions(this.value);
    });

    satuanUtamaSearch?.addEventListener('input', function () {
        openSatuanDropdown();
        filterSatuanOptions(this.value);
    });

    toggleSatuanDropdown?.addEventListener('click', function (e) {
        e.preventDefault();
        if (satuanUtamaDropdown?.classList.contains('hidden')) {
            openSatuanDropdown();
            filterSatuanOptions(satuanUtamaSearch?.value || '');
            satuanUtamaSearch?.focus();
        } else {
            closeSatuanDropdown();
        }
    });

    document.querySelectorAll('.satuan-option-persediaan').forEach((option) => {
        option.addEventListener('click', function () {
            const value = this.dataset.value;
            if (satuanUtamaSearch) satuanUtamaSearch.value = value;
            if (satuanUtamaValue) satuanUtamaValue.value = value;
            closeSatuanDropdown();
        });
    });

    // =========================
    // SEARCHABLE DROPDOWN RAK
    // =========================
    const rakPenyimpananSearch = document.getElementById('rakPenyimpananSearchPersediaan');
    const rakPenyimpananValue = document.getElementById('rakPenyimpananValuePersediaan');
    const rakPenyimpananDropdown = document.getElementById('rakPenyimpananDropdownPersediaan');
    const toggleRakDropdown = document.getElementById('toggleRakDropdownPersediaan');

    function openRakDropdown() {
        rakPenyimpananDropdown?.classList.remove('hidden');
    }

    function closeRakDropdown() {
        rakPenyimpananDropdown?.classList.add('hidden');
    }

    function filterRakOptions(keyword = '') {
        const options = document.querySelectorAll('.rak-option-persediaan');
        const search = keyword.toLowerCase().trim();

        options.forEach((option) => {
            const text = option.dataset.value.toLowerCase();
            option.classList.toggle('hidden', !text.includes(search));
        });
    }

    rakPenyimpananSearch?.addEventListener('focus', function () {
        openRakDropdown();
        filterRakOptions(this.value);
    });

    rakPenyimpananSearch?.addEventListener('input', function () {
        openRakDropdown();
        filterRakOptions(this.value);
    });

    toggleRakDropdown?.addEventListener('click', function (e) {
        e.preventDefault();
        if (rakPenyimpananDropdown?.classList.contains('hidden')) {
            openRakDropdown();
            filterRakOptions(rakPenyimpananSearch?.value || '');
            rakPenyimpananSearch?.focus();
        } else {
            closeRakDropdown();
        }
    });

    document.querySelectorAll('.rak-option-persediaan').forEach((option) => {
        option.addEventListener('click', function () {
            const value = this.dataset.value;
            if (rakPenyimpananSearch) rakPenyimpananSearch.value = value;
            if (rakPenyimpananValue) rakPenyimpananValue.value = value;
            closeRakDropdown();
        });
    });

    // =========================
    // CLOSE DROPDOWN OUTSIDE
    // =========================
    document.addEventListener('click', function (e) {
        const clickedInsideSatuan =
            satuanUtamaDropdown?.contains(e.target) ||
            satuanUtamaSearch?.contains(e.target) ||
            toggleSatuanDropdown?.contains(e.target);

        if (!clickedInsideSatuan) {
            closeSatuanDropdown();
        }

        const clickedInsideRak =
            rakPenyimpananDropdown?.contains(e.target) ||
            rakPenyimpananSearch?.contains(e.target) ||
            toggleRakDropdown?.contains(e.target);

        if (!clickedInsideRak) {
            closeRakDropdown();
        }
    });

    // =========================
    // DRAWER CETAK BARCODE
    // =========================
    const openCetakBarcodeDrawerBtn = document.getElementById('openCetakBarcodeDrawer');
    const closeCetakBarcodeDrawerBtn = document.getElementById('closeCetakBarcodeDrawer');
    const cetakBarcodeDrawer = document.getElementById('cetakBarcodeDrawer');

    function openCetakBarcodeDrawer() {
        if (!cetakBarcodeDrawer) return;
        cetakBarcodeDrawer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeCetakBarcodeDrawer() {
        if (!cetakBarcodeDrawer) return;
        cetakBarcodeDrawer.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    openCetakBarcodeDrawerBtn?.addEventListener('click', openCetakBarcodeDrawer);
    closeCetakBarcodeDrawerBtn?.addEventListener('click', closeCetakBarcodeDrawer);

    // =========================
    // BARCODE ROW DINAMIS
    // =========================
    const barcodeTableBody = document.getElementById('barcodeTableBody');

    const barcodeProducts = [
        @foreach ($produks as $produk)
        {
            id: {{ $produk->id }},
            nama: @json($produk->nama_produk),
            satuan: @json($produk->satuan_utama ?? ''),
            harga: {{ $produk->harga_jual ?? 0 }},
            barcode: @json($produk->barcode ?? ''),
            sku: @json($produk->sku ?? '')
        },
        @endforeach
    ];

    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(Number(angka || 0));
    }

    function createBarcodePreview(produk) {
        const sumberKode = document.getElementById('sumberKodeValue')?.value || 'barcode';

        let barcodeValue = '';

        if (sumberKode === 'barcode') {
            barcodeValue = String(produk.barcode || '').trim();
        } else if (sumberKode === 'sku') {
            barcodeValue = String(produk.sku || '').trim();
        } else {
            barcodeValue = String(produk.barcode || '').trim() || String(produk.sku || '').trim();
        }

        const safeId = `barcode-svg-${produk.id}-${Date.now()}-${Math.floor(Math.random() * 1000)}`;

        const showNamaProduk = document.getElementById('showNamaProduk')?.checked;
        const showNamaOutlet = document.getElementById('showNamaOutlet')?.checked;
        const showTeksKode = document.getElementById('showTeksKode')?.checked;
        const showHargaProduk = document.getElementById('showHargaProduk')?.checked;
        const showSatuan = document.getElementById('showSatuan')?.checked;

        let html = `
            <div class="inline-flex flex-col items-center rounded-xl bg-white px-3 py-2 shadow-sm border border-gray-200 min-w-[160px]">
        `;

        if (showNamaProduk) {
            html += `
                <div class="text-[10px] leading-tight text-center text-gray-700 max-w-[150px] mb-1">
                    ${produk.nama}
                </div>
            `;
        }

        if (showNamaOutlet) {
            html += `
                <div class="text-[9px] leading-tight text-center text-gray-500 mb-1">
                    Apotek Saya
                </div>
            `;
        }

        html += `
            <svg
                id="${safeId}"
                class="barcode-svg"
                data-barcode-value="${barcodeValue}"
            ></svg>
        `;

        if (showTeksKode) {
            html += `
                <div class="text-[9px] leading-tight text-center text-gray-700 mt-1">
                    ${barcodeValue}
                </div>
            `;
        }

        if (showHargaProduk) {
            html += `
                <div class="text-[10px] leading-tight text-center text-gray-700 mt-1">
                    Rp ${formatRupiah(produk.harga)}
                </div>
            `;
        }

        if (showSatuan) {
            html += `
                <div class="text-[9px] leading-tight text-center text-gray-500 mt-1">
                    ${produk.satuan || '-'}
                </div>
            `;
        }

        html += `</div>`;

        return html;
    }

    function renderAllBarcodes() {
        const barcodeElements = document.querySelectorAll('.barcode-svg');

        barcodeElements.forEach((el) => {
            const value = el.dataset.barcodeValue || '';

            if (!value) {
                el.outerHTML = '<div class="text-xs text-red-500">Barcode kosong</div>';
                return;
            }

            try {
                JsBarcode(el, value, {
                    format: 'CODE128',
                    width: 1.5,
                    height: 36,
                    displayValue: false,
                    margin: 0
                });
            } catch (error) {
                el.outerHTML = '<div class="text-xs text-red-500">Barcode tidak valid</div>';
            }
        });
    }

    function updateAllBarcodePreviews() {
        const rows = barcodeTableBody.querySelectorAll('.barcode-selected-row');

        rows.forEach((row) => {
            const produk = {
                id: row.dataset.id,
                nama: row.dataset.nama,
                satuan: row.dataset.satuan,
                harga: Number(row.dataset.harga || 0),
                barcode: row.dataset.barcode,
                sku: row.dataset.sku
            };

            const previewCell = row.querySelector('.barcode-preview-cell');
            if (previewCell) {
                previewCell.innerHTML = createBarcodePreview(produk);
            }
        });

        renderAllBarcodes();
    }

    function createSelectedProductRow(produk, index) {
        return `
            <div 
                class="grid grid-cols-12 gap-4 px-5 py-4 items-start barcode-selected-row"
                data-id="${produk.id}"
                data-nama="${produk.nama}"
                data-satuan="${produk.satuan || ''}"
                data-harga="${produk.harga || 0}"
                data-barcode="${produk.barcode || ''}"
                data-sku="${produk.sku || ''}"
            >
                <div class="col-span-1 pt-2 text-sm text-gray-700 barcode-row-number">${index}</div>

                <div class="col-span-3">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-sm font-medium text-gray-800">
                                ${produk.nama}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                SKU: ${produk.sku || '-'}
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            <button
                                type="button"
                                class="remove-barcode-row w-6 h-6 rounded bg-red-500 text-white text-xs hover:bg-red-600"
                                data-id="${produk.id}"
                                title="Hapus"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-span-1">
                    <select class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option selected>${produk.satuan || '-'}</option>
                    </select>
                </div>

                <div class="col-span-2">
                    <select class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200">
                        <option selected>#1 Harga Utama</option>
                    </select>
                </div>

                <div class="col-span-1">
                    <input
                        type="text"
                        value="${formatRupiah(produk.harga)}"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm text-right bg-gray-50 focus:outline-none"
                        readonly
                    >
                </div>

                <div class="col-span-3 barcode-preview-cell">
                    ${createBarcodePreview(produk)}
                </div>

                <div class="col-span-1">
                    <input
                        type="number"
                        value="1"
                        min="1"
                        class="w-24 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                </div>
            </div>
        `;
    }

    function createInputRow() {
        const optionsHtml = barcodeProducts.map(produk => `
            <button
                type="button"
                class="barcode-produk-option w-full text-left px-4 py-3 text-sm hover:bg-blue-50 text-gray-700"
                data-id="${produk.id}"
            >
                ${produk.nama}
            </button>
        `).join('');

        return `
            <div class="grid grid-cols-12 gap-4 px-5 py-4 items-start barcode-input-row">
                <div class="col-span-1 pt-2 text-2xl text-gray-700">+</div>

                <div class="col-span-3 relative">
                    <div class="relative w-full">
                        <input
                            type="text"
                            placeholder="Pilih Produk"
                            autocomplete="off"
                            class="barcode-produk-search w-full rounded-lg border border-gray-400 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >

                        <div class="barcode-produk-dropdown hidden absolute left-0 top-full mt-2 w-full rounded-xl border border-gray-200 bg-white shadow-2xl z-[99999] overflow-hidden">
                            <div class="barcode-produk-list max-h-72 overflow-y-auto py-1">
                                ${optionsHtml}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-1 pt-2 text-sm text-gray-700"></div>
                <div class="col-span-2 pt-2 text-sm text-gray-700">Harga Jual</div>
                <div class="col-span-1 pt-2 text-sm text-gray-700"></div>
                <div class="col-span-3 pt-2 text-sm text-gray-400">-</div>

                <div class="col-span-1">
                    <input
                        type="number"
                        value="1"
                        min="1"
                        class="w-24 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                    >
                </div>
            </div>
        `;
    }

    function renumberBarcodeRows() {
        const rows = barcodeTableBody.querySelectorAll('.barcode-selected-row');
        rows.forEach((row, index) => {
            const noCell = row.querySelector('.barcode-row-number');
            if (noCell) {
                noCell.textContent = index + 1;
            }
        });
    }

    function bindRemoveBarcodeRowEvents() {
        const removeButtons = barcodeTableBody.querySelectorAll('.remove-barcode-row');

        removeButtons.forEach((btn) => {
            btn.onclick = function () {
                const row = this.closest('.barcode-selected-row');
                row?.remove();
                renumberBarcodeRows();
            };
        });
    }

    function bindBarcodeInputRowEvents() {
        const inputRow = barcodeTableBody.querySelector('.barcode-input-row');
        if (!inputRow) return;

        const searchInput = inputRow.querySelector('.barcode-produk-search');
        const dropdown = inputRow.querySelector('.barcode-produk-dropdown');
        const list = inputRow.querySelector('.barcode-produk-list');
        const options = inputRow.querySelectorAll('.barcode-produk-option');

        function openDropdown() {
            dropdown?.classList.remove('hidden');
        }

        function closeDropdown() {
            dropdown?.classList.add('hidden');
        }

        function filterOptions(keyword = '') {
            const search = keyword.toLowerCase().trim();
            let visibleCount = 0;

            options.forEach((option) => {
                const text = option.textContent.toLowerCase();
                const match = text.includes(search);

                option.classList.toggle('hidden', !match);
                if (match) visibleCount++;
            });

            let emptyState = list.querySelector('.barcode-empty-state');

            if (visibleCount === 0) {
                if (!emptyState) {
                    emptyState = document.createElement('div');
                    emptyState.className = 'barcode-empty-state px-4 py-3 text-sm text-gray-500';
                    emptyState.textContent = 'Produk tidak ditemukan';
                    list.appendChild(emptyState);
                }
            } else {
                emptyState?.remove();
            }
        }

        searchInput?.addEventListener('focus', function () {
            openDropdown();
            filterOptions(this.value);
        });

        searchInput?.addEventListener('input', function () {
            openDropdown();
            filterOptions(this.value);
        });

        options.forEach((option) => {
            option.addEventListener('click', function () {
                const produkId = Number(this.dataset.id);
                const produk = barcodeProducts.find(item => item.id === produkId);
                if (!produk) return;

                const selectedCount = barcodeTableBody.querySelectorAll('.barcode-selected-row').length + 1;

                inputRow.remove();
                barcodeTableBody.insertAdjacentHTML('beforeend', createSelectedProductRow(produk, selectedCount));
                barcodeTableBody.insertAdjacentHTML('beforeend', createInputRow());

                bindBarcodeInputRowEvents();
                bindRemoveBarcodeRowEvents();
                renderAllBarcodes();
            });
        });

        document.addEventListener('click', function (e) {
            if (!inputRow.contains(e.target)) {
                closeDropdown();
            }
        });
    }

    function renderInitialBarcodeInputRow() {
        if (!barcodeTableBody) return;
        barcodeTableBody.innerHTML = createInputRow();
        bindBarcodeInputRowEvents();
    }

    renderInitialBarcodeInputRow();

    [
        'showNamaProduk',
        'showNamaOutlet',
        'showTeksKode',
        'showHargaProduk',
        'showSatuan'
    ].forEach((id) => {
        document.getElementById(id)?.addEventListener('change', updateAllBarcodePreviews);
    });

    // =========================
    // CUSTOM DROPDOWN JENIS KERTAS
    // =========================
    const jenisKertasButton = document.getElementById('jenisKertasButton');
    const jenisKertasDropdown = document.getElementById('jenisKertasDropdown');
    const jenisKertasText = document.getElementById('jenisKertasText');
    const jenisKertasValue = document.getElementById('jenisKertasValue');
    const jenisKertasIcon = document.getElementById('jenisKertasIcon');
    const jenisKertasOptions = document.querySelectorAll('.jenis-kertas-option');

    function openJenisKertasDropdown() {
        jenisKertasDropdown?.classList.remove('hidden');
        jenisKertasIcon?.classList.add('rotate-180');
    }

    function closeJenisKertasDropdown() {
        jenisKertasDropdown?.classList.add('hidden');
        jenisKertasIcon?.classList.remove('rotate-180');
    }

    jenisKertasButton?.addEventListener('click', function (e) {
        e.stopPropagation();

        if (jenisKertasDropdown?.classList.contains('hidden')) {
            openJenisKertasDropdown();
        } else {
            closeJenisKertasDropdown();
        }
    });

    jenisKertasOptions.forEach((option) => {
        option.addEventListener('click', function () {
            const value = this.dataset.value;

            if (jenisKertasText) jenisKertasText.textContent = value;
            if (jenisKertasValue) jenisKertasValue.value = value;

            closeJenisKertasDropdown();
        });
    });

    document.addEventListener('click', function (e) {
        const clickedInsideJenisKertas =
            jenisKertasButton?.contains(e.target) ||
            jenisKertasDropdown?.contains(e.target);

        if (!clickedInsideJenisKertas) {
            closeJenisKertasDropdown();
        }
    });

    // =========================
    // DROPDOWN UKURAN LABEL
    // =========================
    const ukuranLabelButton = document.getElementById('ukuranLabelButton');
    const ukuranLabelDropdown = document.getElementById('ukuranLabelDropdown');
    const ukuranLabelText = document.getElementById('ukuranLabelText');
    const ukuranLabelValue = document.getElementById('ukuranLabelValue');
    const ukuranLabelIcon = document.getElementById('ukuranLabelIcon');
    const ukuranLabelOptions = document.querySelectorAll('.ukuran-label-option');

    function openUkuranLabelDropdown() {
        ukuranLabelDropdown?.classList.remove('hidden');
        ukuranLabelIcon?.classList.add('rotate-180');
    }

    function closeUkuranLabelDropdown() {
        ukuranLabelDropdown?.classList.add('hidden');
        ukuranLabelIcon?.classList.remove('rotate-180');
    }

    ukuranLabelButton?.addEventListener('click', function(e){
        e.stopPropagation();

        if(ukuranLabelDropdown.classList.contains('hidden')){
            openUkuranLabelDropdown();
        } else {
            closeUkuranLabelDropdown();
        }
    });

    ukuranLabelOptions.forEach(option => {
        option.addEventListener('click', function(){
            const value = this.dataset.value;
            const text = this.textContent;

            ukuranLabelText.textContent = text;
            ukuranLabelValue.value = value;

            closeUkuranLabelDropdown();
        });
    });

    document.addEventListener('click', function(e){
        if(!ukuranLabelButton.contains(e.target) && !ukuranLabelDropdown.contains(e.target)){
            closeUkuranLabelDropdown();
        }
    });

    // =========================
    // DROPDOWN SUMBER KODE
    // =========================
    const sumberKodeButton = document.getElementById('sumberKodeButton');
    const sumberKodeDropdown = document.getElementById('sumberKodeDropdown');
    const sumberKodeText = document.getElementById('sumberKodeText');
    const sumberKodeValue = document.getElementById('sumberKodeValue');
    const sumberKodeIcon = document.getElementById('sumberKodeIcon');
    const sumberKodeOptions = document.querySelectorAll('.sumber-kode-option');

    function openSumberKodeDropdown() {
        sumberKodeDropdown?.classList.remove('hidden');
        sumberKodeIcon?.classList.add('rotate-180');
    }

    function closeSumberKodeDropdown() {
        sumberKodeDropdown?.classList.add('hidden');
        sumberKodeIcon?.classList.remove('rotate-180');
    }

    sumberKodeButton?.addEventListener('click', function (e) {
        e.stopPropagation();

        if (sumberKodeDropdown?.classList.contains('hidden')) {
            openSumberKodeDropdown();
        } else {
            closeSumberKodeDropdown();
        }
    });

    sumberKodeOptions.forEach((option) => {
        option.addEventListener('click', function () {
            const value = this.dataset.value;
            const text = this.textContent.trim();

            if (sumberKodeText) sumberKodeText.textContent = text;
            if (sumberKodeValue) sumberKodeValue.value = value;

            closeSumberKodeDropdown();
            updateAllBarcodePreviews?.();
        });
    });

    document.addEventListener('click', function (e) {
        const clickedInsideSumberKode =
            sumberKodeButton?.contains(e.target) ||
            sumberKodeDropdown?.contains(e.target);

        if (!clickedInsideSumberKode) {
            closeSumberKodeDropdown();
        }
    });

    // =========================
    // PRINT PREVIEW BARCODE
    // =========================
    const openPrintPreviewBtn = document.getElementById('openPrintPreviewBtn');
    const backToConfigBtn = document.getElementById('backToConfigBtn');
    const barcodeConfigView = document.getElementById('barcodeConfigView');
    const barcodePrintPreviewView = document.getElementById('barcodePrintPreviewView');
    const barcodePrintCanvas = document.getElementById('barcodePrintCanvas');

    const barcodeWidthInput = document.getElementById('barcodeWidthInput');
    const barcodeHeightInput = document.getElementById('barcodeHeightInput');
    const barcodeFontSizeInput = document.getElementById('barcodeFontSizeInput');
    const resetBarcodePreviewBtn = document.getElementById('resetBarcodePreviewBtn');
    const printBarcodeBtn = document.getElementById('printBarcodeBtn');

    function getSelectedBarcodeRowsData() {
        const rows = barcodeTableBody.querySelectorAll('.barcode-selected-row');

        return Array.from(rows).map((row) => ({
            id: row.dataset.id,
            nama: row.dataset.nama,
            satuan: row.dataset.satuan,
            harga: Number(row.dataset.harga || 0),
            barcode: row.dataset.barcode,
            sku: row.dataset.sku
        }));
    }

    function buildPrintPreviewItems() {
        const items = getSelectedBarcodeRowsData();
        const showNamaProduk = document.getElementById('showNamaProduk')?.checked;
        const showNamaOutlet = document.getElementById('showNamaOutlet')?.checked;
        const showTeksKode = document.getElementById('showTeksKode')?.checked;
        const showHargaProduk = document.getElementById('showHargaProduk')?.checked;
        const showSatuan = document.getElementById('showSatuan')?.checked;

        if (!barcodePrintCanvas) return;

        if (items.length === 0) {
            barcodePrintCanvas.innerHTML = `
                <div class="text-sm text-gray-500">Belum ada barcode yang dipilih.</div>
            `;
            return;
        }

        barcodePrintCanvas.innerHTML = items.map((produk, index) => {
            const barcodeValue = (produk.barcode && String(produk.barcode).trim() !== '')
                ? String(produk.barcode).trim()
                : String(produk.sku || '').trim();

            return `
                <div class="inline-flex flex-col items-center justify-center rounded-2xl border border-gray-200 bg-white px-4 py-3 mr-4 mb-4 shadow-sm">
                    ${showNamaProduk ? `<div class="text-[10px] text-center text-gray-700 mb-1">${produk.nama}</div>` : ''}
                    ${showNamaOutlet ? `<div class="text-[9px] text-center text-gray-500 mb-1">Apotek Saya</div>` : ''}
                    <svg
                        class="barcode-print-svg"
                        data-barcode-value="${barcodeValue}"
                        data-barcode-index="${index}"
                    ></svg>
                    ${showTeksKode ? `<div class="text-[9px] text-center text-gray-700 mt-1">${barcodeValue}</div>` : ''}
                    ${showHargaProduk ? `<div class="text-[10px] text-center text-gray-700 mt-1">Rp ${formatRupiah(produk.harga)}</div>` : ''}
                    ${showSatuan ? `<div class="text-[9px] text-center text-gray-500 mt-1">${produk.satuan || '-'}</div>` : ''}
                </div>
            `;
        }).join('');

        renderPrintPreviewBarcodes();
    }

    function renderPrintPreviewBarcodes() {
        const width = parseFloat(barcodeWidthInput?.value || 1.2);
        const height = parseInt(barcodeHeightInput?.value || 30);
        const fontSize = parseInt(barcodeFontSizeInput?.value || 10);

        document.querySelectorAll('.barcode-print-svg').forEach((el) => {
            const value = el.dataset.barcodeValue || '';

            if (!value) return;

            try {
                JsBarcode(el, value, {
                    format: 'CODE128',
                    width: width,
                    height: height,
                    displayValue: false,
                    margin: 0,
                    fontSize: fontSize
                });
            } catch (error) {
                el.outerHTML = '<div class="text-xs text-red-500">Barcode tidak valid</div>';
            }
        });
    }

    const barcodeDrawerHeader = document.getElementById('barcodeDrawerHeader');

    function openBarcodePrintPreview() {
        barcodeDrawerHeader?.classList.add('hidden');
        barcodeConfigView?.classList.add('hidden');
        barcodePrintPreviewView?.classList.remove('hidden');
        buildPrintPreviewItems();
    }

    function closeBarcodePrintPreview() {
        barcodePrintPreviewView?.classList.add('hidden');
        barcodeConfigView?.classList.remove('hidden');
        barcodeDrawerHeader?.classList.remove('hidden');
    }

    openPrintPreviewBtn?.addEventListener('click', openBarcodePrintPreview);
    backToConfigBtn?.addEventListener('click', closeBarcodePrintPreview);

    [barcodeWidthInput, barcodeHeightInput, barcodeFontSizeInput].forEach((input) => {
        input?.addEventListener('input', renderPrintPreviewBarcodes);
    });

    resetBarcodePreviewBtn?.addEventListener('click', function () {
        if (barcodeWidthInput) barcodeWidthInput.value = 1.2;
        if (barcodeHeightInput) barcodeHeightInput.value = 30;
        if (barcodeFontSizeInput) barcodeFontSizeInput.value = 10;
        renderPrintPreviewBarcodes();
    });

    function printBarcodeOnly() {
        const preview = document.getElementById('barcodePrintCanvas');
        if (!preview) return;

        const existingFrame = document.getElementById('barcode-print-frame');
        if (existingFrame) {
            existingFrame.remove();
        }

        const printFrame = document.createElement('iframe');
        printFrame.id = 'barcode-print-frame';
        printFrame.style.position = 'fixed';
        printFrame.style.right = '0';
        printFrame.style.bottom = '0';
        printFrame.style.width = '0';
        printFrame.style.height = '0';
        printFrame.style.border = '0';
        printFrame.style.visibility = 'hidden';

        document.body.appendChild(printFrame);

        const frameDoc = printFrame.contentWindow.document;

        frameDoc.open();
        frameDoc.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>Cetak Barcode</title>
                <style>
                    * {
                        box-sizing: border-box;
                    }

                    html, body {
                        margin: 0;
                        padding: 0;
                        background: white;
                        font-family: Arial, sans-serif;
                    }

                    body {
                        padding: 10px;
                    }

                    .print-area {
                        display: flex;
                        flex-wrap: wrap;
                        align-items: flex-start;
                        gap: 12px;
                    }

                    .print-area > * {
                        break-inside: avoid;
                        page-break-inside: avoid;
                    }

                    svg {
                        display: block;
                        max-width: 100%;
                    }

                    @page {
                        margin: 8mm;
                        size: auto;
                    }

                    @media print {
                        html, body {
                            margin: 0;
                            padding: 0;
                            background: white;
                        }

                        body {
                            padding: 10px;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="print-area">
                    ${preview.innerHTML}
                </div>
            </body>
            </html>
        `);
        frameDoc.close();

        printFrame.onload = function () {
            setTimeout(() => {
                printFrame.contentWindow.focus();
                printFrame.contentWindow.print();
            }, 300);

            printFrame.contentWindow.onafterprint = function () {
                setTimeout(() => {
                    printFrame.remove();
                }, 200);
            };
        };
    }

    printBarcodeBtn?.addEventListener('click', function () {
        printBarcodeOnly();
    });

    // =========================
    // ESC
    // =========================
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;

        if (tambahProdukModal && !tambahProdukModal.classList.contains('hidden')) {
            closeTambahProdukModal();
        }

        if (cetakBarcodeDrawer && !cetakBarcodeDrawer.classList.contains('hidden')) {
            closeCetakBarcodeDrawer();
        }
    });
});
</script>
@endpush