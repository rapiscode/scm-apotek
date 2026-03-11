@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Master Produk')
@section('page_title', 'Master Produk')
@section('page_subtitle', 'Kelola data master produk.')

@section('content')
    <div class="h-[calc(100vh-9rem)]">
        <div class="relative z-0 bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 h-full flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-4">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Master Produk</h2>

                <div class="flex items-center gap-2 flex-wrap">
                    <button
                        type="button"
                        id="openUbahSekaligusDrawer"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-file-pen"></i>
                        Ubah Sekaligus
                    </button>

                    <button
                        type="button"
                        id="openTambahSekaligusDrawer"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-file-circle-plus"></i>
                        Tambah Sekaligus
                    </button>

                    <button
                        type="button"
                        id="openProdukBaruModal"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                    >
                        <i class="fas fa-circle-plus"></i>
                        Produk Baru
                    </button>
                </div>
            </div>

            <!-- Search + action -->
            <div class="flex items-center justify-between gap-3 flex-wrap mb-3">
                <div class="relative z-0 w-full max-w-xs">
                    <input
                        type="text"
                        id="searchProdukInput"
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
                        id="openFilterModal"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-filter text-sm"></i>
                        <span>Filter</span>
                        <span id="filterCountBadge" class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-white text-xs font-semibold">0</span>
                    </button>

                    <a
                        href="{{ route('masterdata.masterproduk.download') }}"
                        class="w-10 h-10 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200 inline-flex items-center justify-center"
                        title="Unduh Data Produk"
                    >
                        <i class="fas fa-download"></i>
                    </a>
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

            @if($errors->has('file_edit_produk'))
                <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                    {{ $errors->first('file_edit_produk') }}
                </div>
            @endif

            <!-- Tabel -->
            <div class="rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden flex-1 flex flex-col">
                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="min-w-[1900px] w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap w-16">No.</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[300px]">Nama</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[150px]">Kode Produk (SKU)</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">Barcode</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[200px]">Nama Pabrik</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[130px]">Satuan Utama</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-40">Referensi Harga Beli</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[150px]">Harga Jual Utama</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[100px]">Rak</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[130px]">Stok Minimal</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[100px]">Status</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[180px]">Catatan Lainnya</th>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="produkTableBody" class="bg-white dark:bg-gray-950">
                            @forelse ($produks as $index => $produk)
                                <tr
                                    class="produk-row border-t border-gray-100 dark:border-gray-800"
                                    data-status="{{ $produk->status_penjualan }}"
                                    data-rak="{{ $produk->rak_penyimpanan ?? '' }}"
                                >
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 min-w-[300px]">{{ $produk->nama_produk }}</td>
                                    <td class="px-4 py-3 min-w-[150px]">{{ $produk->sku }}</td>
                                    <td class="px-4 py-3 min-w-[120px]">{{ $produk->barcode ?? '-' }}</td>
                                    <td class="px-4 py-3 min-w-[200px]">{{ $produk->nama_pabrik ?? '-' }}</td>
                                    <td class="px-4 py-3 min-w-[130px]">{{ $produk->satuan_utama }}</td>
                                    <td class="px-4 py-3 min-w-40">Rp {{ number_format($produk->harga_beli, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 min-w-[150px]">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3 min-w-[100px]">{{ $produk->rak_penyimpanan ?? '-' }}</td>
                                    <td class="px-4 py-3 min-w-[130px]">{{ $produk->stok_minimal }}</td>
                                    <td class="px-4 py-3 min-w-[100px]">
                                        @if ($produk->status_penjualan === 'dijual')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                Dijual
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                                Tidak Dijual
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 min-w-[180px]">{{ $produk->catatan ?? '-' }}</td>
                                    <td class="px-4 py-3 min-w-[120px]">
                                        <div class="flex items-center gap-2">
                                            <button
                                                type="button"
                                                class="openEditProdukModal w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100"
                                                data-id="{{ $produk->id }}"
                                                data-tipe_produk="{{ $produk->tipe_produk }}"
                                                data-nama_produk="{{ $produk->nama_produk }}"
                                                data-nama_pabrik="{{ $produk->nama_pabrik }}"
                                                data-sku="{{ $produk->sku }}"
                                                data-barcode="{{ $produk->barcode }}"
                                                data-pajak="{{ $produk->pajak }}"
                                                data-satuan_utama="{{ $produk->satuan_utama }}"
                                                data-harga_beli="{{ $produk->harga_beli }}"
                                                data-harga_jual="{{ $produk->harga_jual }}"
                                                data-stok_minimal="{{ $produk->stok_minimal }}"
                                                data-stok_maksimal="{{ $produk->stok_maksimal }}"
                                                data-rak_penyimpanan="{{ $produk->rak_penyimpanan }}"
                                                data-status_penjualan="{{ $produk->status_penjualan }}"
                                                data-catatan="{{ $produk->catatan }}"
                                            >
                                                <i class="fas fa-pen text-sm"></i>
                                            </button>

                                            <button
                                                type="button"
                                                class="openDeleteProdukModal w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100"
                                                data-id="{{ $produk->id }}"
                                                data-nama="{{ $produk->nama_produk }}"
                                            >
                                                <i class="fas fa-trash text-sm"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyTableRow" class="border-t border-gray-100 dark:border-gray-800">
                                    <td colspan="13" class="text-center py-20 text-gray-500 dark:text-gray-400">
                                        Data tidak ditemukan
                                    </td>
                                </tr>
                            @endforelse
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
                        <span>: {{ $produkStats->dijual ?? 0 }} produk</span>
                    </div>

                    <div class="flex items-center justify-between">
                        <span>Produk Tidak Dijual</span>
                        <span>: {{ $produkStats->tidak_dijual ?? 0 }} produk</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Tambah Produk -->
<div id="produkBaruModal" class="fixed inset-0 z-[9999] hidden">
    <div id="produkBaruOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-8">
        <form
            id="produkForm"
            action="{{ route('masterdata.masterproduk.store') }}"
            method="POST"
            class="relative z-[10000] w-full max-w-[650px] h-[92vh] bg-white dark:bg-gray-950 rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf
            <input type="hidden" name="_method" id="produkFormMethod" value="POST">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 id="produkModalTitle" class="text-2xl font-bold text-white leading-none">Tambah Produk</h3>
                <button
                    type="button"
                    id="closeProdukBaruModal"
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

                        <input type="hidden" name="tipe_produk" id="tipeProdukValue" value="umum">

                        <div class="grid grid-cols-4 rounded-lg overflow-hidden border border-blue-600 w-full">
                            <button
                                type="button"
                                data-tipe="umum"
                                class="tipe-produk-btn px-3 py-2 text-sm font-semibold border-r border-blue-600 transition-all duration-200 bg-blue-600 text-white"
                            >
                                Umum
                            </button>

                            <button
                                type="button"
                                data-tipe="obat"
                                class="tipe-produk-btn px-3 py-2 text-sm font-semibold border-r border-blue-600 transition-all duration-200 bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20"
                            >
                                Obat
                            </button>

                            <button
                                type="button"
                                data-tipe="alkes"
                                class="tipe-produk-btn px-3 py-2 text-sm font-semibold border-r border-blue-600 transition-all duration-200 bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20"
                            >
                                Alkes
                            </button>

                            <button
                                type="button"
                                data-tipe="jasa"
                                class="tipe-produk-btn px-3 py-2 text-sm font-semibold transition-all duration-200 bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20"
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
                                id="namaProdukInput"
                                name="nama_produk"
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Nama Pabrik</label>
                            <input
                                type="text"
                                id="namaPabrikInput"
                                name="nama_pabrik"
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">SKU (Kode Produk) *</label>
                            <div class="flex gap-2">
                                <input
                                    type="text"
                                    id="skuInput"
                                    name="sku"
                                    class="flex-1 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                                >
                                <button
                                    type="button"
                                    id="generateSkuBtn"
                                    class="w-11 h-11 rounded-lg bg-blue-600 text-white flex items-center justify-center transition-all duration-200 hover:bg-blue-700 active:scale-95"
                                >
                                    <i id="generateSkuIcon" class="fas fa-rotate-right transition-transform duration-300"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Barcode</label>
                            <input
                                type="text"
                                id="barcodeInput"
                                name="barcode"
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Pajak</label>
                            <select
                                id="pajakInput"
                                name="pajak"
                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
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
                                        id="satuanUtamaSearch"
                                        placeholder="Pilih / cari satuan"
                                        autocomplete="off"
                                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                                    >

                                    <input type="hidden" name="satuan_utama" id="satuanUtamaValue">

                                    <button
                                        type="button"
                                        id="toggleSatuanDropdown"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400"
                                    >
                                        <i class="fas fa-chevron-down text-sm"></i>
                                    </button>

                                    <div
                                        id="satuanUtamaDropdown"
                                        class="hidden absolute z-[10020] mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-lg overflow-hidden"
                                    >
                                        <div id="satuanUtamaList" class="max-h-56 overflow-y-auto py-1">
                                            @forelse ($satuans as $satuan)
                                                <button
                                                    type="button"
                                                    class="satuan-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200"
                                                    data-value="{{ $satuan->nama_satuan }}"
                                                >
                                                    {{ $satuan->nama_satuan }}
                                                </button>
                                            @empty
                                                <div class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">
                                                    Belum ada data satuan
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>

                                <button
                                    type="button"
                                    id="openSatuanKemasanModal"
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
                        <div class="rounded-md bg-sky-200 dark:bg-sky-900/40 text-sky-900 dark:text-sky-100 text-xs px-3 py-2 transition-colors duration-200">
                            Semua harga adalah per SATUAN UTAMA.
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Referensi Harga Pokok/Modal</label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-700">Rp.</span>
                                <input
                                    type="number"
                                    id="hargaBeliInput"
                                    name="harga_beli"
                                    min="0"
                                    step="0.01"
                                    class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                                >
                                <span class="text-sm text-gray-700">0</span>
                                <span class="text-sm text-gray-700">/</span>
                            </div>
                        </div>

                        <div class="rounded-md bg-sky-200 dark:bg-sky-900/40 text-sky-900 dark:text-sky-100 text-xs px-3 py-2 transition-colors duration-200">
                            Harga pokok default yang dapat membantu untuk penentuan harga jual. BUKAN untuk penghitungan laba/rugi.
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Hrg Jual Utama</label>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-700">Rp.</span>
                                <input
                                    type="number"
                                    id="hargaJualInput"
                                    name="harga_jual"
                                    min="0"
                                    step="0.01"
                                    class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
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
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Stok Minimal</label>
                                    <div class="flex">
                                        <input
                                            type="number"
                                            id="stokMinimalInput"
                                            name="stok_minimal"
                                            value="0"
                                            class="w-full rounded-l-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900"
                                        >
                                        <span
                                            class="inline-flex items-center px-4 rounded-r-xl border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200"
                                        >
                                            satuan
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Stok Maksimal</label>
                                    <div class="flex">
                                        <input
                                            type="number"
                                            id="stokMaksimalInput"
                                            name="stok_maksimal"
                                            value="0"
                                            class="w-full rounded-l-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900"
                                        >
                                        <span
                                            class="inline-flex items-center px-4 rounded-r-xl border border-l-0 border-gray-300 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-200"
                                        >
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
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Rak Penyimpanan</label>

                                    <div class="flex gap-2">
                                        <div class="relative flex-1">
                                            <input
                                                type="text"
                                                id="rakPenyimpananSearch"
                                                placeholder="Pilih / cari lokasi rak penyimpanan"
                                                autocomplete="off"
                                                class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                                            >

                                            <input type="hidden" name="rak_penyimpanan" id="rakPenyimpananValue">

                                            <button
                                                type="button"
                                                id="toggleRakDropdown"
                                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 dark:text-gray-400"
                                            >
                                                <i class="fas fa-chevron-down text-sm"></i>
                                            </button>

                                            <div
                                                id="rakPenyimpananDropdown"
                                                class="hidden absolute z-[10020] mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-lg overflow-hidden"
                                            >
                                                <div id="rakPenyimpananList" class="max-h-56 overflow-y-auto py-1">
                                                    <button type="button" class="rak-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200" data-value="Rak A1">Rak A1</button>
                                                    <button type="button" class="rak-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200" data-value="Rak A2">Rak A2</button>
                                                    <button type="button" class="rak-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200" data-value="Rak B1">Rak B1</button>
                                                    <button type="button" class="rak-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200" data-value="Rak B2">Rak B2</button>
                                                    <button type="button" class="rak-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200" data-value="Rak Gudang">Rak Gudang</button>
                                                    <button type="button" class="rak-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200" data-value="Rak Etalase">Rak Etalase</button>
                                                </div>
                                            </div>
                                        </div>

                                        <button
                                            type="button"
                                            id="openRakModal"
                                            class="w-11 h-11 rounded-lg bg-blue-600 text-white text-xl font-bold flex items-center justify-center transition-all duration-200 hover:bg-blue-700 active:scale-95"
                                        >
                                            +
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pengaturan Tambahan Penjualan -->
                        <div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">Status Penjualan</label>

                                    <input type="hidden" name="status_penjualan" id="statusPenjualanValue" value="dijual">

                                    <div class="grid grid-cols-2 rounded-xl overflow-hidden border border-blue-600 w-full">
                                        <button
                                            type="button"
                                            data-status-penjualan="dijual"
                                            class="status-penjualan-btn px-4 py-3 text-sm font-semibold transition-all duration-200 active:scale-[0.98] bg-blue-600 text-white border-r border-blue-600"
                                        >
                                            Dijual
                                        </button>

                                        <button
                                            type="button"
                                            data-status-penjualan="tidak_dijual"
                                            class="status-penjualan-btn px-4 py-3 text-sm font-semibold transition-all duration-200 active:scale-[0.98] bg-white dark:bg-gray-900 text-blue-600 dark:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20"
                                        >
                                            Tidak Dijual
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Catatan Lainnya</label>
                                    <input
                                        type="text"
                                        id="catatanInput"
                                        name="catatan"
                                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-800 flex items-center justify-end gap-3 bg-white dark:bg-gray-950 sticky bottom-0 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelProdukBaruModal"
                    class="px-5 py-2.5 rounded-lg text-gray-400 dark:text-gray-500 font-semibold hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200"
                >
                    Kembali
                </button>

                <button
                    type="submit"
                    id="saveProdukSubmitBtn"
                    class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Satuan Kemasan -->
<div id="satuanKemasanModal" class="fixed inset-0 z-[10050] hidden">
    <div id="satuanKemasanOverlay" class="absolute inset-0 bg-black/40"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <form
            id="ajaxTambahSatuanForm"
            class="w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf

            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Tambah Satuan Kemasan</h3>
                <button
                    type="button"
                    id="closeSatuanKemasanModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-5 space-y-5 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Satuan Kemasan *
                    </label>
                    <input
                        type="text"
                        id="namaSatuanKemasanInput"
                        name="nama_satuan"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                    <p id="satuanKemasanError" class="mt-2 text-sm text-red-500 hidden"></p>
                </div>

                <div class="rounded-[22px] bg-yellow-400 dark:bg-yellow-500 px-6 py-5 transition-colors duration-200">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-exclamation text-yellow-400 text-lg"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-900 font-medium">
                            Sebelum membuat satuan kemasan baru, pastikan sebelumnya benar-benar belum terdaftar agar tidak menyebabkan kebingungan ketika memilih.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelSatuanKemasanModal"
                    class="px-5 py-2.5 rounded-lg text-gray-400 dark:text-gray-500 font-semibold hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    id="saveSatuanKemasanModal"
                    class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold transition-colors duration-200"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Tambah Rak -->
<div id="rakModal" class="fixed inset-0 z-[10060] hidden">
    <div id="rakOverlay" class="absolute inset-0 bg-black/40"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Tambah Rak</h3>
                <button
                    type="button"
                    id="closeRakModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 space-y-5 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Rak *
                    </label>
                    <input
                        type="text"
                        id="namaRakInput"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                </div>

                <div class="rounded-[22px] bg-yellow-400 dark:bg-yellow-500 px-6 py-5 transition-colors duration-200">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-exclamation text-yellow-400 text-lg"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-900 font-medium">
                            Sebelum membuat Rak baru, pastikan sebelumnya benar-benar belum terdaftar agar tidak menyebabkan kebingungan ketika memilih.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelRakModal"
                    class="px-5 py-2.5 rounded-lg text-gray-400 dark:text-gray-500 font-semibold hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200"
                >
                    Batal
                </button>

                <button
                    type="button"
                    id="saveRakModal"
                    class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold transition-colors duration-200"
                >
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Drawer Tambah Sekaligus -->
<div id="tambahSekaligusDrawer" class="fixed inset-0 z-[9998] hidden">
    <!-- Overlay -->
    <div id="tambahSekaligusOverlay" class="absolute inset-0 bg-black/50"></div>

    <!-- Panel -->
    <div
        id="tambahSekaligusPanel"
        class="absolute inset-0 bg-white dark:bg-gray-950 shadow-2xl translate-y-full transition-transform duration-300 ease-out flex flex-col overflow-hidden"
    >
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shrink-0 sticky top-0 z-10">
            <button type="button" id="closeTambahSekaligusDrawer" class="text-white text-2xl">
                <i class="fas fa-arrow-left"></i>
            </button>

            <h3 class="text-xl font-bold text-center flex-1">Tambahkan Produk Sekaligus</h3>

            <div class="w-8"></div>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="flex justify-center mb-6">
                <a
                    href="{{ route('masterdata.masterproduk.template.download') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-teal-500 hover:bg-teal-600 text-white font-semibold transition-colors duration-200"
                >
                    <i class="fas fa-cloud-download-alt"></i>
                    Download Template
                </a>
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 shadow-sm overflow-hidden">
                <div class="px-4 py-4 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-2xl font-bold text-blue-700 dark:text-blue-400">Tips dan Ketentuan</h3>
                    <button type="button" class="text-gray-700 dark:text-gray-300">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>

                <div class="p-4">
                    <div class="rounded-xl border border-sky-400 bg-sky-50 dark:bg-sky-950/20 px-5 py-4">
                        <div class="flex gap-4">
                            <div class="pt-1 text-sky-500 text-xl">
                                <i class="fas fa-info-circle"></i>
                            </div>

                            <div class="text-blue-800 dark:text-sky-200 leading-8">
                                <p>Silahkan download template excel pada tombol di atas</p>
                                <p>Ubah file excel dengan memasukkan master data (produk, satuan, kategori, rak, dan membership)</p>
                                <p>Harap tidak mengganti template/format excel karena sistem tidak akan mengenalinya.</p>
                                <p>Untuk sheet "MasterProduk", hanya dapat digunakan untuk menambahkan data yang sku(kode produk) nya belum dikenali oleh sistem.</p>
                                <p>Untuk sheet SELAIN "MasterProduk" dapat digunakan untuk menambahkan master data dengan cara membuat data baru pada baris tepat dibawah data yang ada</p>
                                <p>Jika menemukan kendala dapat hubungi Tim Support kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-8 border-t border-gray-200 dark:border-gray-800"></div>
        </div>

        <!-- Footer -->
        <div class="shrink-0 border-t border-dashed border-gray-300 dark:border-gray-700 px-6 py-5 bg-white dark:bg-gray-950 flex items-center justify-end gap-6 flex-wrap sticky bottom-0">
            <label class="inline-flex items-center gap-3 text-gray-700 dark:text-gray-200">
                <input id="checkboxPahamImport" type="checkbox" class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-200">
                <span class="font-medium">Saya Mengerti</span>
            </label>

            <form id="formImportProduk" action="{{ route('masterdata.masterproduk.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" id="inputFileProduk" name="file_import" accept=".xlsx,.xls" class="hidden">

                <div class="flex items-center gap-3">
                    <button
                        id="btnPilihFile"
                        type="button"
                        class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-500 font-semibold cursor-not-allowed"
                        disabled
                    >
                        Pilih File
                    </button>

                    <button
                        id="btnKirimFile"
                        type="button"
                        class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-500 font-semibold cursor-not-allowed"
                        disabled
                    >
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- modal hapus -->
<div id="deleteProdukModal" class="fixed inset-0 z-[10070] hidden">
    <div id="deleteProdukOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-[520px] rounded-3xl bg-white dark:bg-gray-950 shadow-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="px-8 py-10 text-center">
                <div class="mx-auto mb-6 w-20 h-20 rounded-full border-4 border-orange-300 flex items-center justify-center">
                    <i class="fas fa-exclamation text-4xl text-orange-300"></i>
                </div>

                <h3 class="text-4xl font-extrabold text-gray-700 dark:text-gray-100 mb-4">
                    Yakin nih?
                </h3>

                <p class="text-2xl leading-9 text-gray-600 dark:text-gray-300 mb-8">
                    Pastikan produk <span id="deleteProdukNama" class="font-semibold"></span> benar-benar ingin dihapus.
                </p>

                <form id="deleteProdukForm" method="POST" class="flex items-center justify-center gap-3">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-500 hover:bg-blue-600 text-white font-bold text-xl"
                    >
                        Yup, Hapus Sekarang!
                    </button>

                    <button
                        type="button"
                        id="cancelDeleteProdukBtn"
                        class="px-6 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold text-xl"
                    >
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Drawer Ubah Sekaligus -->
<div id="ubahSekaligusDrawer" class="fixed inset-0 z-[9998] hidden">
    <div id="ubahSekaligusOverlay" class="absolute inset-0 bg-black/50"></div>

    <div
        id="ubahSekaligusPanel"
        class="absolute inset-0 bg-white dark:bg-gray-950 shadow-2xl translate-y-full transition-transform duration-300 ease-out flex flex-col overflow-hidden"
    >
        <!-- Header -->
        <div class="bg-blue-600 text-white px-6 py-4 flex items-center justify-between shrink-0 sticky top-0 z-10">
            <button type="button" id="closeUbahSekaligusDrawer" class="text-white text-2xl">
                <i class="fas fa-arrow-left"></i>
            </button>

            <h3 class="text-xl font-bold text-center flex-1">Edit Produk Sekaligus</h3>

            <div class="w-8"></div>
        </div>

        <!-- Body -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="flex justify-center mb-6">
                <a
                    href="{{ route('masterdata.masterproduk.export') }}"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-teal-500 hover:bg-teal-600 text-white font-semibold transition-colors duration-200"
                >
                    <i class="fas fa-cloud-download-alt"></i>
                    Download Data Terakhir
                </a>
            </div>

            <div class="rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-950 shadow-sm overflow-hidden">
                <div class="px-4 py-4 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-2xl font-bold text-blue-700 dark:text-blue-400">Tips dan Ketentuan</h3>
                    <button type="button" class="text-gray-700 dark:text-gray-300">
                        <i class="fas fa-chevron-up"></i>
                    </button>
                </div>

                <div class="p-4">
                    <div class="rounded-xl border border-sky-400 bg-sky-50 dark:bg-sky-950/20 px-5 py-4">
                        <div class="flex gap-4">
                            <div class="pt-1 text-sky-500 text-xl">
                                <i class="fas fa-info-circle"></i>
                            </div>

                            <div class="text-blue-800 dark:text-sky-200 leading-8">
                                <p>Silahkan download data terakhir pada tombol di atas</p>
                                <p>Ubah file excel dengan memasukkan master data (produk, satuan, kategori, rak, dan kategori pelanggan)</p>
                                <p>Harap tidak mengganti template/format excel karena sistem tidak akan mengenalinya.</p>
                                <p>Kolom ID pada setiap sheet diabaikan saja. Sistem akan menolak jika ID diubah sehingga tidak dikenali</p>
                                <p>Untuk sheet "MasterProduk", hanya dapat digunakan untuk menyubah data yang sudah dikenali oleh sistem.</p>
                                <p>Jika ingin menambahkan produk baru, maka dapat menggunakan fitur "Tambah Produk Sekaligus"</p>
                                <p>Untuk sheet SELAIN "MasterProduk" dapat digunakan untuk menambahkan master data dengan cara membuat data baru pada baris tepat dibawah data yang ada, dan biarkan kolom ID dalam keadaan kosong</p>
                                <p>Jika menemukan kendala dapat hubungi Tim Support kami.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-8 border-t border-gray-200 dark:border-gray-800"></div>
        </div>

        <!-- Footer -->
        <div class="shrink-0 border-t border-dashed border-gray-300 dark:border-gray-700 px-6 py-5 bg-white dark:bg-gray-950 flex items-center justify-between gap-6 flex-wrap">
            <label class="inline-flex items-center gap-3 text-gray-700 dark:text-gray-200">
                <input id="checkboxPahamEdit" type="checkbox" class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-200">
                <span class="font-medium">Saya Mengerti</span>
            </label>

            <form
                id="formEditProdukMassal"
                action="{{ route('masterdata.masterproduk.importUpdate') }}"
                method="POST"
                enctype="multipart/form-data"
                class="flex items-center gap-3"
            >
                @csrf

                <input
                    type="file"
                    id="inputFileEditProduk"
                    name="file_edit_produk"
                    accept=".xlsx,.xls"
                    class="hidden"
                >

                <button
                    id="btnPilihFileEdit"
                    type="button"
                    class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-500 font-semibold cursor-not-allowed"
                    disabled
                >
                    Pilih File
                </button>

                <button
                    id="btnKirimFileEdit"
                    type="button"
                    class="px-5 py-2.5 rounded-lg bg-gray-200 text-gray-500 font-semibold cursor-not-allowed"
                    disabled
                >
                    Kirim
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Filter Produk -->
<div id="filterProdukModal" class="fixed inset-0 z-[10080] hidden">
    <div id="filterProdukOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-[620px] rounded-3xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Filter Data</h3>
                <button
                    type="button"
                    id="closeFilterModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-6 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div class="space-y-4">
                    <div class="grid grid-cols-[180px_20px_1fr] items-center gap-3">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                        <span class="text-gray-500 dark:text-gray-400">:</span>
                        <select
                            id="filterStatus"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                        >
                            <option value="">Semua Produk</option>
                            @php
                                $statusList = $produks->pluck('status_penjualan')->filter()->unique()->values();
                            @endphp
                            @foreach ($statusList as $status)
                                <option value="{{ $status }}">{{ $status === 'dijual' ? 'Dijual' : 'Tidak Dijual' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-[180px_20px_1fr] items-center gap-3">
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-200">Rak Penyimpanan</label>
                        <span class="text-gray-500 dark:text-gray-400">:</span>
                        <select
                            id="filterRak"
                            class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                        >
                            <option value="">Semua Rak</option>
                            @php
                                $rakList = $produks->pluck('rak_penyimpanan')->filter()->unique()->values();
                            @endphp
                            @foreach ($rakList as $rak)
                                <option value="{{ $rak }}">{{ $rak }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-between transition-colors duration-200">
                <button
                    type="button"
                    id="resetFilterBtn"
                    class="text-cyan-500 hover:text-cyan-600 font-semibold"
                >
                    Reset Filter
                </button>

                <button
                    type="button"
                    id="applyFilterBtn"
                    class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold"
                >
                    Terapkan
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // =========================
    // MODAL: PRODUK BARU
    // =========================
    const openProdukBtn = document.getElementById('openProdukBaruModal');
    const produkModal = document.getElementById('produkBaruModal');
    const produkOverlay = document.getElementById('produkBaruOverlay');
    const closeProdukBtn = document.getElementById('closeProdukBaruModal');
    const cancelProdukBtn = document.getElementById('cancelProdukBaruModal');

    function openProdukModal() {
        if (!produkModal) return;
        produkModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeProdukModal() {
        if (!produkModal) return;
        produkModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');

        resetProdukFormToCreate();
    }

    closeProdukBtn?.addEventListener('click', closeProdukModal);
    cancelProdukBtn?.addEventListener('click', closeProdukModal);
    produkOverlay?.addEventListener('click', closeProdukModal);

    // =========================
    // DRAWER: TAMBAH SEKALIGUS
    // =========================
    const openTambahDrawerBtn = document.getElementById('openTambahSekaligusDrawer');
    const tambahDrawer = document.getElementById('tambahSekaligusDrawer');
    const tambahDrawerPanel = document.getElementById('tambahSekaligusPanel');
    const tambahDrawerOverlay = document.getElementById('tambahSekaligusOverlay');
    const closeTambahDrawerBtn = document.getElementById('closeTambahSekaligusDrawer');

    const checkboxPahamImport = document.getElementById('checkboxPahamImport');
    const btnPilihFile = document.getElementById('btnPilihFile');
    const btnKirimFile = document.getElementById('btnKirimFile');

    function openTambahDrawer() {
        if (!tambahDrawer || !tambahDrawerPanel) return;

        tambahDrawer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            tambahDrawerPanel.classList.remove('translate-y-full');
        });
    }

    function closeTambahDrawer() {
        if (!tambahDrawer || !tambahDrawerPanel) return;

        tambahDrawerPanel.classList.add('translate-y-full');

        setTimeout(() => {
            tambahDrawer.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    openTambahDrawerBtn?.addEventListener('click', openTambahDrawer);
    closeTambahDrawerBtn?.addEventListener('click', closeTambahDrawer);
    tambahDrawerOverlay?.addEventListener('click', closeTambahDrawer);

    checkboxPahamImport?.addEventListener('change', function () {
        const enabled = this.checked;

        if (enabled) {
            btnPilihFile?.removeAttribute('disabled');
            btnPilihFile?.classList.remove('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnPilihFile?.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');

            btnKirimFile?.setAttribute('disabled', 'disabled');
            btnKirimFile?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFile?.classList.remove('bg-teal-500', 'text-white', 'hover:bg-teal-600');
        } else {
            btnPilihFile?.setAttribute('disabled', 'disabled');
            btnKirimFile?.setAttribute('disabled', 'disabled');

            btnPilihFile?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnPilihFile?.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');

            btnKirimFile?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFile?.classList.remove('bg-teal-500', 'text-white', 'hover:bg-teal-600');

            const inputFile = document.getElementById('inputFileProduk');
            if (inputFile) inputFile.value = '';
            if (btnPilihFile) btnPilihFile.textContent = 'Pilih File';
        }
    });

    // Pilih File → trigger input file
    btnPilihFile?.addEventListener('click', function () {
        document.getElementById('inputFileProduk')?.click();
    });

    // Tampilkan nama file yang dipilih di tombol
    document.getElementById('inputFileProduk')?.addEventListener('change', function () {
        if (this.files.length > 0) {
            btnPilihFile.textContent = this.files[0].name;

            btnKirimFile?.removeAttribute('disabled');
            btnKirimFile?.classList.remove('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFile?.classList.add('bg-teal-500', 'text-white', 'hover:bg-teal-600');
        } else {
            btnPilihFile.textContent = 'Pilih File';

            btnKirimFile?.setAttribute('disabled', 'disabled');
            btnKirimFile?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFile?.classList.remove('bg-teal-500', 'text-white', 'hover:bg-teal-600');
        }
    });

    // Kirim → submit form
    btnKirimFile?.addEventListener('click', function () {
        const fileInput = document.getElementById('inputFileProduk');
        if (!fileInput?.files.length) {
            alert('Pilih file Excel terlebih dahulu!');
            return;
        }
        document.getElementById('formImportProduk')?.submit();
    });

    // =========================
    // EDIT PRODUK
    // =========================
    const produkForm = document.getElementById('produkForm');
    const produkFormMethod = document.getElementById('produkFormMethod');
    const produkModalTitle = document.getElementById('produkModalTitle');

    const namaPabrikInput = document.getElementById('namaPabrikInput');
    const barcodeInput = document.getElementById('barcodeInput');
    const pajakInput = document.getElementById('pajakInput');
    const hargaBeliInput = document.getElementById('hargaBeliInput');
    const hargaJualInput = document.getElementById('hargaJualInput');
    const stokMinimalInput = document.getElementById('stokMinimalInput');
    const stokMaksimalInput = document.getElementById('stokMaksimalInput');
    const catatanInput = document.getElementById('catatanInput');
    const saveProdukSubmitBtn = document.getElementById('saveProdukSubmitBtn');

    function resetProdukFormToCreate() {
        if (produkForm) {
            produkForm.action = "{{ route('masterdata.masterproduk.store') }}";
        }

        if (produkFormMethod) {
            produkFormMethod.value = 'POST';
        }

        if (produkModalTitle) {
            produkModalTitle.textContent = 'Tambah Produk';
        }

        if (saveProdukSubmitBtn) {
            saveProdukSubmitBtn.textContent = 'Simpan';
        }

        if (namaProdukInput) namaProdukInput.value = '';
        if (namaPabrikInput) namaPabrikInput.value = '';
        if (skuInput) skuInput.value = '';
        if (barcodeInput) barcodeInput.value = '';
        if (pajakInput) pajakInput.value = 'PPN';
        if (satuanUtamaSearch) satuanUtamaSearch.value = '';
        if (satuanUtamaValue) satuanUtamaValue.value = '';
        if (hargaBeliInput) hargaBeliInput.value = '';
        if (hargaJualInput) hargaJualInput.value = '';
        if (stokMinimalInput) stokMinimalInput.value = 0;
        if (stokMaksimalInput) stokMaksimalInput.value = 0;
        if (rakPenyimpananSearch) rakPenyimpananSearch.value = '';
        if (rakPenyimpananValue) rakPenyimpananValue.value = '';
        if (catatanInput) catatanInput.value = '';

        setActiveTipeProduk('umum');
        setActiveStatusPenjualan('dijual');
    }

    openProdukBtn?.addEventListener('click', function () {
        resetProdukFormToCreate();
        openProdukModal();
    });

    document.querySelectorAll('.openEditProdukModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            if (produkForm) {
                produkForm.action = `/master-data/master-produk/${id}`;
            }

            if (produkFormMethod) {
                produkFormMethod.value = 'PUT';
            }

            if (produkModalTitle) {
                produkModalTitle.textContent = 'Edit Produk';
            }

            if (saveProdukSubmitBtn) {
                saveProdukSubmitBtn.textContent = 'Simpan';
            }

            if (namaProdukInput) namaProdukInput.value = this.dataset.nama_produk || '';
            if (namaPabrikInput) namaPabrikInput.value = this.dataset.nama_pabrik || '';
            if (skuInput) skuInput.value = this.dataset.sku || '';
            if (barcodeInput) barcodeInput.value = this.dataset.barcode || '';
            if (pajakInput) pajakInput.value = this.dataset.pajak || 'PPN';

            if (satuanUtamaSearch) satuanUtamaSearch.value = this.dataset.satuan_utama || '';
            if (satuanUtamaValue) satuanUtamaValue.value = this.dataset.satuan_utama || '';

            if (hargaBeliInput) hargaBeliInput.value = this.dataset.harga_beli || 0;
            if (hargaJualInput) hargaJualInput.value = this.dataset.harga_jual || 0;
            if (stokMinimalInput) stokMinimalInput.value = this.dataset.stok_minimal || 0;
            if (stokMaksimalInput) stokMaksimalInput.value = this.dataset.stok_maksimal || 0;

            if (rakPenyimpananSearch) rakPenyimpananSearch.value = this.dataset.rak_penyimpanan || '';
            if (rakPenyimpananValue) rakPenyimpananValue.value = this.dataset.rak_penyimpanan || '';

            if (catatanInput) catatanInput.value = this.dataset.catatan || '';

            setActiveTipeProduk(this.dataset.tipe_produk || 'umum');
            setActiveStatusPenjualan(this.dataset.status_penjualan || 'dijual');

            openProdukModal();
        });
    });

    // =========================
    // DELETE PRODUK
    // =========================
    const deleteProdukModal = document.getElementById('deleteProdukModal');
    const deleteProdukOverlay = document.getElementById('deleteProdukOverlay');
    const deleteProdukForm = document.getElementById('deleteProdukForm');
    const deleteProdukNama = document.getElementById('deleteProdukNama');
    const cancelDeleteProdukBtn = document.getElementById('cancelDeleteProdukBtn');

    function openDeleteProdukModal() {
        deleteProdukModal?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteProdukModal() {
        deleteProdukModal?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.querySelectorAll('.openDeleteProdukModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama || '-';

            if (deleteProdukForm) {
                deleteProdukForm.action = `/master-data/master-produk/${id}`;
            }

            if (deleteProdukNama) {
                deleteProdukNama.textContent = nama;
            }

            openDeleteProdukModal();
        });
    });

    cancelDeleteProdukBtn?.addEventListener('click', closeDeleteProdukModal);
    deleteProdukOverlay?.addEventListener('click', closeDeleteProdukModal);

    // =========================
    // DRAWER: UBAH SEKALIGUS
    // =========================
    const openUbahDrawerBtn = document.getElementById('openUbahSekaligusDrawer');
    const ubahDrawer = document.getElementById('ubahSekaligusDrawer');
    const ubahDrawerPanel = document.getElementById('ubahSekaligusPanel');
    const ubahDrawerOverlay = document.getElementById('ubahSekaligusOverlay');
    const closeUbahDrawerBtn = document.getElementById('closeUbahSekaligusDrawer');

    function openUbahDrawer() {
        if (!ubahDrawer || !ubahDrawerPanel) return;

        ubahDrawer.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            ubahDrawerPanel.classList.remove('translate-y-full');
        });
    }

    function closeUbahDrawer() {
        if (!ubahDrawer || !ubahDrawerPanel) return;

        ubahDrawerPanel.classList.add('translate-y-full');

        setTimeout(() => {
            ubahDrawer.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    openUbahDrawerBtn?.addEventListener('click', openUbahDrawer);
    closeUbahDrawerBtn?.addEventListener('click', closeUbahDrawer);
    ubahDrawerOverlay?.addEventListener('click', closeUbahDrawer);

    // =========================
    // MODAL: TAMBAH SATUAN KEMASAN
    // =========================
    const openSatuanKemasanModalBtn = document.getElementById('openSatuanKemasanModal');
    const satuanKemasanModal = document.getElementById('satuanKemasanModal');
    const satuanKemasanOverlay = document.getElementById('satuanKemasanOverlay');
    const closeSatuanKemasanModalBtn = document.getElementById('closeSatuanKemasanModal');
    const cancelSatuanKemasanModalBtn = document.getElementById('cancelSatuanKemasanModal');
    const saveSatuanKemasanModalBtn = document.getElementById('saveSatuanKemasanModal');
    const namaSatuanKemasanInput = document.getElementById('namaSatuanKemasanInput');

    function openSatuanKemasanModal() {
        if (!satuanKemasanModal) return;
        satuanKemasanModal.classList.remove('hidden');
    }

    function closeSatuanKemasanModal() {
        if (!satuanKemasanModal) return;
        satuanKemasanModal.classList.add('hidden');

        if (namaSatuanKemasanInput) {
            namaSatuanKemasanInput.value = '';
        }
    }

    openSatuanKemasanModalBtn?.addEventListener('click', function () {
        openSatuanKemasanModal();
    });

    closeSatuanKemasanModalBtn?.addEventListener('click', closeSatuanKemasanModal);
    cancelSatuanKemasanModalBtn?.addEventListener('click', closeSatuanKemasanModal);
    satuanKemasanOverlay?.addEventListener('click', closeSatuanKemasanModal);

    const ajaxTambahSatuanForm = document.getElementById('ajaxTambahSatuanForm');
    const satuanKemasanError = document.getElementById('satuanKemasanError');

    ajaxTambahSatuanForm?.addEventListener('submit', async function (e) {
        e.preventDefault();

        const value = namaSatuanKemasanInput?.value?.trim();

        if (!value) {
            namaSatuanKemasanInput?.focus();
            if (satuanKemasanError) {
                satuanKemasanError.textContent = 'Nama satuan wajib diisi.';
                satuanKemasanError.classList.remove('hidden');
            }
            return;
        }

        if (satuanKemasanError) {
            satuanKemasanError.textContent = '';
            satuanKemasanError.classList.add('hidden');
        }

        try {
            const response = await fetch("{{ route('masterdata.mastersatuan.ajaxStore') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    "Accept": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: new FormData(this)
            });

            const result = await response.json();

            if (!response.ok) {
                if (result.errors?.nama_satuan?.length) {
                    satuanKemasanError.textContent = result.errors.nama_satuan[0];
                    satuanKemasanError.classList.remove('hidden');
                }
                return;
            }

            const newValue = result.data.nama_satuan;

            const existingOptions = document.querySelectorAll('.satuan-option');
            const isDuplicate = Array.from(existingOptions).some(option =>
                option.dataset.value.toLowerCase() === newValue.toLowerCase()
            );

            if (!isDuplicate) {
                const newOption = document.createElement('button');
                newOption.type = 'button';
                newOption.className = 'satuan-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200';
                newOption.dataset.value = newValue;
                newOption.textContent = newValue;

                newOption.addEventListener('click', function () {
                    if (satuanUtamaSearch) satuanUtamaSearch.value = newValue;
                    if (satuanUtamaValue) satuanUtamaValue.value = newValue;
                    closeSatuanDropdown();
                });

                satuanUtamaList?.appendChild(newOption);
            }

            if (satuanUtamaSearch) satuanUtamaSearch.value = newValue;
            if (satuanUtamaValue) satuanUtamaValue.value = newValue;

            filterSatuanOptions('');
            closeSatuanKemasanModal();

        } catch (error) {
            if (satuanKemasanError) {
                satuanKemasanError.textContent = 'Terjadi kesalahan saat menyimpan satuan.';
                satuanKemasanError.classList.remove('hidden');
            }
        }
    });

    const checkboxPahamEdit = document.getElementById('checkboxPahamEdit');
    const btnPilihFileEdit = document.getElementById('btnPilihFileEdit');
    const btnKirimFileEdit = document.getElementById('btnKirimFileEdit');
    const inputFileEditProduk = document.getElementById('inputFileEditProduk');
    const formEditProdukMassal = document.getElementById('formEditProdukMassal');

    checkboxPahamEdit?.addEventListener('change', function () {
        const enabled = this.checked;

        if (enabled) {
            btnPilihFileEdit?.removeAttribute('disabled');
            btnPilihFileEdit?.classList.remove('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnPilihFileEdit?.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');

            btnKirimFileEdit?.setAttribute('disabled', 'disabled');
            btnKirimFileEdit?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFileEdit?.classList.remove('bg-teal-500', 'text-white', 'hover:bg-teal-600');
        } else {
            btnPilihFileEdit?.setAttribute('disabled', 'disabled');
            btnKirimFileEdit?.setAttribute('disabled', 'disabled');

            btnPilihFileEdit?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnPilihFileEdit?.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');

            btnKirimFileEdit?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFileEdit?.classList.remove('bg-teal-500', 'text-white', 'hover:bg-teal-600');

            if (inputFileEditProduk) {
                inputFileEditProduk.value = '';
            }

            if (btnPilihFileEdit) {
                btnPilihFileEdit.textContent = 'Pilih File';
            }
        }
    });

    btnPilihFileEdit?.addEventListener('click', function () {
        if (this.hasAttribute('disabled')) return;
        inputFileEditProduk?.click();
    });

    inputFileEditProduk?.addEventListener('change', function () {
        if (this.files.length > 0) {
            btnPilihFileEdit.textContent = this.files[0].name;

            btnKirimFileEdit?.removeAttribute('disabled');
            btnKirimFileEdit?.classList.remove('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFileEdit?.classList.add('bg-teal-500', 'text-white', 'hover:bg-teal-600');
        } else {
            btnPilihFileEdit.textContent = 'Pilih File';

            btnKirimFileEdit?.setAttribute('disabled', 'disabled');
            btnKirimFileEdit?.classList.add('bg-gray-200', 'text-gray-500', 'cursor-not-allowed');
            btnKirimFileEdit?.classList.remove('bg-teal-500', 'text-white', 'hover:bg-teal-600');
        }
    });

    btnKirimFileEdit?.addEventListener('click', function () {
        if (!inputFileEditProduk?.files.length) {
            alert('Pilih file Excel terlebih dahulu!');
            return;
        }

        formEditProdukMassal?.submit();
    });

    // =========================
    // MODAL: TAMBAH RAK
    // =========================
    const openRakModalBtn = document.getElementById('openRakModal');
    const rakModal = document.getElementById('rakModal');
    const rakOverlay = document.getElementById('rakOverlay');
    const closeRakModalBtn = document.getElementById('closeRakModal');
    const cancelRakModalBtn = document.getElementById('cancelRakModal');
    const saveRakModalBtn = document.getElementById('saveRakModal');
    const namaRakInput = document.getElementById('namaRakInput');

    function openRakModal() {
        if (!rakModal) return;
        rakModal.classList.remove('hidden');
    }

    function closeRakModal() {
        if (!rakModal) return;
        rakModal.classList.add('hidden');

        if (namaRakInput) {
            namaRakInput.value = '';
        }
    }

    openRakModalBtn?.addEventListener('click', function () {
        openRakModal();
    });

    closeRakModalBtn?.addEventListener('click', closeRakModal);
    cancelRakModalBtn?.addEventListener('click', closeRakModal);
    rakOverlay?.addEventListener('click', closeRakModal);

    saveRakModalBtn?.addEventListener('click', function () {
        const value = namaRakInput?.value?.trim();

        if (rakPenyimpananSearch) {
            rakPenyimpananSearch.value = '';
        }
        if (rakPenyimpananValue) {
            rakPenyimpananValue.value = '';
        }

        if (!value) {
            namaRakInput?.focus();
            return;
        }

        const existingOptions = document.querySelectorAll('.rak-option');
        const isDuplicate = Array.from(existingOptions).some(option =>
            option.dataset.value.toLowerCase() === value.toLowerCase()
        );

        if (isDuplicate) {
            namaRakInput?.focus();
            namaRakInput?.select();
            return;
        }

        const newOption = document.createElement('button');
        newOption.type = 'button';
        newOption.className = 'rak-option w-full text-left px-4 py-2 text-sm hover:bg-blue-50 dark:hover:bg-blue-900/20 text-gray-700 dark:text-gray-200';
        newOption.dataset.value = value;
        newOption.textContent = value;

        newOption.addEventListener('click', function () {
            if (rakPenyimpananSearch) rakPenyimpananSearch.value = value;
            if (rakPenyimpananValue) rakPenyimpananValue.value = value;
            closeRakDropdown();
        });

        rakPenyimpananList?.appendChild(newOption);

        if (rakPenyimpananSearch) rakPenyimpananSearch.value = value;
        if (rakPenyimpananValue) rakPenyimpananValue.value = value;

        filterRakOptions('');
        closeRakModal();
    });

    // =========================
    // STATUS PENJUALAN BUTTON
    // =========================
    const statusPenjualanButtons = document.querySelectorAll('.status-penjualan-btn');
    const statusPenjualanValue = document.getElementById('statusPenjualanValue');

    function setActiveStatusPenjualan(selectedValue) {
        statusPenjualanButtons.forEach((btn) => {
            const isActive = btn.dataset.statusPenjualan === selectedValue;

            if (isActive) {
                btn.classList.remove(
                    'bg-white',
                    'dark:bg-gray-900',
                    'text-blue-600',
                    'dark:text-blue-300',
                    'hover:bg-blue-50',
                    'dark:hover:bg-blue-900/20'
                );
                btn.classList.add(
                    'bg-blue-600',
                    'text-white'
                );
            } else {
                btn.classList.remove(
                    'bg-blue-600',
                    'text-white'
                );
                btn.classList.add(
                    'bg-white',
                    'dark:bg-gray-900',
                    'text-blue-600',
                    'dark:text-blue-300',
                    'hover:bg-blue-50',
                    'dark:hover:bg-blue-900/20'
                );
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

    // default aktif
    setActiveStatusPenjualan('dijual');

    // =========================
    // ESC KEY
    // =========================
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;

        if (produkModal && !produkModal.classList.contains('hidden')) {
            closeProdukModal();
        }

        if (tambahDrawer && !tambahDrawer.classList.contains('hidden')) {
            closeTambahDrawer();
        }

        if (ubahDrawer && !ubahDrawer.classList.contains('hidden')) {
            closeUbahDrawer();
        }

        if (satuanKemasanModal && !satuanKemasanModal.classList.contains('hidden')) {
            closeSatuanKemasanModal();
        }

        if (rakModal && !rakModal.classList.contains('hidden')) {
            closeRakModal();
        }
    });

    // TIPE PRODUK BUTTON
    // =========================
    const tipeProdukButtons = document.querySelectorAll('.tipe-produk-btn');
    const tipeProdukValue = document.getElementById('tipeProdukValue');

    function setActiveTipeProduk(selectedValue) {
        tipeProdukButtons.forEach((btn) => {
            const isActive = btn.dataset.tipe === selectedValue;

            if (isActive) {
                btn.classList.remove(
                    'bg-white',
                    'dark:bg-gray-900',
                    'text-blue-600',
                    'dark:text-blue-300',
                    'hover:bg-blue-50',
                    'dark:hover:bg-blue-900/20'
                );
                btn.classList.add(
                    'bg-blue-600',
                    'text-white'
                );
            } else {
                btn.classList.remove(
                    'bg-blue-600',
                    'text-white'
                );
                btn.classList.add(
                    'bg-white',
                    'dark:bg-gray-900',
                    'text-blue-600',
                    'dark:text-blue-300',
                    'hover:bg-blue-50',
                    'dark:hover:bg-blue-900/20'
                );
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

    // default aktif = umum
    setActiveTipeProduk('umum');

    // =========================
    // SEARCHABLE DROPDOWN: SATUAN UTAMA
    // =========================
    const satuanUtamaSearch = document.getElementById('satuanUtamaSearch');
    const satuanUtamaValue = document.getElementById('satuanUtamaValue');
    const satuanUtamaDropdown = document.getElementById('satuanUtamaDropdown');
    const satuanUtamaList = document.getElementById('satuanUtamaList');
    const toggleSatuanDropdown = document.getElementById('toggleSatuanDropdown');

    function openSatuanDropdown() {
        satuanUtamaDropdown?.classList.remove('hidden');
    }

    function closeSatuanDropdown() {
        satuanUtamaDropdown?.classList.add('hidden');
    }

    function filterSatuanOptions(keyword = '') {
        const options = document.querySelectorAll('.satuan-option');
        const search = keyword.toLowerCase().trim();

        options.forEach((option) => {
            const text = option.dataset.value.toLowerCase();
            const match = text.includes(search);
            option.classList.toggle('hidden', !match);
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

    document.querySelectorAll('.satuan-option').forEach((option) => {
        option.addEventListener('click', function () {
            const value = this.dataset.value;

            if (satuanUtamaSearch) satuanUtamaSearch.value = value;
            if (satuanUtamaValue) satuanUtamaValue.value = value;

            closeSatuanDropdown();
        });
    });

    document.addEventListener('click', function (e) {
        if (!satuanUtamaDropdown || !satuanUtamaSearch) return;

        const clickedInside =
            satuanUtamaDropdown.contains(e.target) ||
            satuanUtamaSearch.contains(e.target) ||
            (toggleSatuanDropdown && toggleSatuanDropdown.contains(e.target));

        if (!clickedInside) {
            closeSatuanDropdown();
        }
    });

    // =========================
    // SEARCHABLE DROPDOWN: RAK PENYIMPANAN
    // =========================
    const rakPenyimpananSearch = document.getElementById('rakPenyimpananSearch');
    const rakPenyimpananValue = document.getElementById('rakPenyimpananValue');
    const rakPenyimpananDropdown = document.getElementById('rakPenyimpananDropdown');
    const rakPenyimpananList = document.getElementById('rakPenyimpananList');
    const toggleRakDropdown = document.getElementById('toggleRakDropdown');

    function openRakDropdown() {
        rakPenyimpananDropdown?.classList.remove('hidden');
    }

    function closeRakDropdown() {
        rakPenyimpananDropdown?.classList.add('hidden');
    }

    function filterRakOptions(keyword = '') {
        const options = document.querySelectorAll('.rak-option');
        const search = keyword.toLowerCase().trim();
        let visibleCount = 0;

        options.forEach((option) => {
            const text = option.dataset.value.toLowerCase();
            const match = text.includes(search);

            option.classList.toggle('hidden', !match);

            if (match) {
                visibleCount++;
            }
        });

        let emptyState = document.getElementById('rakEmptyState');

        if (visibleCount === 0) {
            if (!emptyState) {
                emptyState = document.createElement('div');
                emptyState.id = 'rakEmptyState';
                emptyState.className = 'px-4 py-3 text-sm text-gray-500 dark:text-gray-400';
                emptyState.textContent = 'Rak tidak ditemukan';
                rakPenyimpananList?.appendChild(emptyState);
            }
        } else {
            emptyState?.remove();
        }
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

    document.querySelectorAll('.rak-option').forEach((option) => {
        option.addEventListener('click', function () {
            const value = this.dataset.value;

            if (rakPenyimpananSearch) rakPenyimpananSearch.value = value;
            if (rakPenyimpananValue) rakPenyimpananValue.value = value;

            closeRakDropdown();
        });
    });

    document.addEventListener('click', function (e) {
        const clickedInsideRak =
            rakPenyimpananDropdown?.contains(e.target) ||
            rakPenyimpananSearch?.contains(e.target) ||
            toggleRakDropdown?.contains(e.target);

        if (!clickedInsideRak) {
            closeRakDropdown();
        }
    });

    // =========================
    // GENERATE SKU
    // =========================
    const namaProdukInput = document.getElementById('namaProdukInput');
    const skuInput = document.getElementById('skuInput');
    const generateSkuBtn = document.getElementById('generateSkuBtn');
    const generateSkuIcon = document.getElementById('generateSkuIcon');

    function getPrefixFromKategori(tipe) {
        switch (tipe) {
            case 'obat':
                return 'OB';
            case 'alkes':
                return 'AL';
            case 'jasa':
                return 'JS';
            case 'umum':
            default:
                return 'UM';
        }
    }

    function singkatanNamaProduk(nama) {
        return nama
            .toUpperCase()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .replace(/[^A-Z0-9\s]/g, '')
            .trim()
            .split(/\s+/)
            .filter(Boolean)
            .map(word => {
                const match = word.match(/[A-Z]+|[0-9]+/g);
                if (!match) return '';
                return match.map(part => part[0]).join('');
            })
            .join('');
    }

    function generateSku() {
        if (!skuInput) return;

        const tipe = tipeProdukValue ? tipeProdukValue.value : 'umum';
        const nama = namaProdukInput ? namaProdukInput.value : '';

        const prefix = getPrefixFromKategori(tipe);
        const singkatan = singkatanNamaProduk(nama);

        if (!singkatan) {
            skuInput.value = `${prefix}-`;
            return;
        }

        skuInput.value = `${prefix}-${singkatan}`;
    }

    generateSkuBtn?.addEventListener('click', function () {
        generateSku();

        if (generateSkuIcon) {
            generateSkuIcon.classList.add('rotate-[360deg]');

            setTimeout(() => {
                generateSkuIcon.classList.remove('rotate-[360deg]');
            }, 300);
        }
    });

    namaProdukInput?.addEventListener('input', function () {
        generateSku();
    });

    // =========================
    // SEARCH PRODUK TABLE
    // =========================
    const searchProdukInput = document.getElementById('searchProdukInput');
    const produkRows = document.querySelectorAll('#produkTableBody .produk-row');
    const produkTableBody = document.getElementById('produkTableBody');

    function createSearchEmptyRow() {
        let row = document.createElement('tr');

        row.id = 'searchEmptyRow';
        row.className = 'border-t border-gray-100 dark:border-gray-800';

        row.innerHTML = `
            <td colspan="13" class="text-center py-20 text-gray-500 dark:text-gray-400">
                Data tidak ditemukan
            </td>
        `;

        return row;
    }

    searchProdukInput?.addEventListener('input', function () {
        applyProdukFilters();
    });

    // =========================
    // MODAL FILTER PRODUK
    // =========================
    const openFilterModalBtn = document.getElementById('openFilterModal');
    const filterProdukModal = document.getElementById('filterProdukModal');
    const filterProdukOverlay = document.getElementById('filterProdukOverlay');
    const closeFilterModalBtn = document.getElementById('closeFilterModal');

    const filterStatus = document.getElementById('filterStatus');
    const filterRak = document.getElementById('filterRak');
    const resetFilterBtn = document.getElementById('resetFilterBtn');
    const applyFilterBtn = document.getElementById('applyFilterBtn');
    const filterCountBadge = document.getElementById('filterCountBadge');

    function updateFilterCount() {

        let count = 0;

        if (filterStatus?.value) count++;
        if (filterRak?.value) count++;

        if (filterCountBadge) {
            filterCountBadge.textContent = count;
        }

    }

    function openFilterModal() {
        if (!filterProdukModal) return;
        filterProdukModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeFilterModal() {
        if (!filterProdukModal) return;
        filterProdukModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    openFilterModalBtn?.addEventListener('click', openFilterModal);
    closeFilterModalBtn?.addEventListener('click', closeFilterModal);
    filterProdukOverlay?.addEventListener('click', closeFilterModal);

    function showFilterEmptyRow() {
        let searchEmptyRow = document.getElementById('searchEmptyRow');

        if (!searchEmptyRow) {
            searchEmptyRow = document.createElement('tr');
            searchEmptyRow.id = 'searchEmptyRow';
            searchEmptyRow.className = 'border-t border-gray-100 dark:border-gray-800';
            searchEmptyRow.innerHTML = `
                <td colspan="13" class="text-center py-20 text-gray-500 dark:text-gray-400">
                    Data tidak ditemukan
                </td>
            `;
            produkTableBody?.appendChild(searchEmptyRow);
        }
    }

    function removeFilterEmptyRow() {
        document.getElementById('searchEmptyRow')?.remove();
    }

    function applyProdukFilters() {
        const keyword = searchProdukInput?.value?.toLowerCase().trim() || '';
        const selectedStatus = filterStatus?.value || '';
        const selectedRak = filterRak?.value || '';

        const produkRows = document.querySelectorAll('#produkTableBody .produk-row');
        let visibleCount = 0;

        removeFilterEmptyRow();

        produkRows.forEach((row) => {
            const rowText = row.textContent.toLowerCase();
            const rowStatus = row.dataset.status || '';
            const rowRak = row.dataset.rak || '';

            const matchKeyword = !keyword || rowText.includes(keyword);
            const matchStatus = !selectedStatus || rowStatus === selectedStatus;
            const matchRak = !selectedRak || rowRak === selectedRak;

            const isVisible = matchKeyword && matchStatus && matchRak;

            row.classList.toggle('hidden', !isVisible);

            if (isVisible) {
                visibleCount++;
            }
        });

        if (visibleCount === 0) {
            showFilterEmptyRow();
        }
    }

    applyFilterBtn?.addEventListener('click', function () {

        applyProdukFilters();
        updateFilterCount();
        closeFilterModal();

    });

    resetFilterBtn?.addEventListener('click', function () {

        if (filterStatus) filterStatus.value = '';
        if (filterRak) filterRak.value = '';

        applyProdukFilters();
        updateFilterCount();

    });

    updateFilterCount();
});
</script>
@endpush