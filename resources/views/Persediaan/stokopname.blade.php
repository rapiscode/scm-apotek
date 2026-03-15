@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Stok Opname')
@section('page_title', 'Stok Opname')
@section('page_subtitle', 'Kelola proses stok opname persediaan.')

@section('content')
    <div class="h-[calc(100vh-9rem)]">
        <div class="relative z-0 bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 h-full flex flex-col">

            @if($mode === 'empty')
                {{-- EMPTY STATE --}}
                <div class="mb-4">
                    <h2 class="text-4xl font-bold text-blue-700 dark:text-blue-400">Stok Opname</h2>
                </div>

                <div class="flex-1 flex items-center justify-center">
                    <div class="flex flex-col items-center text-center">

                        <!-- Ilustrasi -->
                        <div class="mb-6">
                            <img
                                src="{{ asset('images/stock-opname-empty.png') }}"
                                alt="Stok Opname Empty"
                                class="w-[320px] max-w-full h-auto mx-auto"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            />

                            <div
                                class="w-[320px] h-[220px] rounded-2xl bg-gray-50 border border-gray-200 items-center justify-center text-gray-400 text-sm"
                                style="display: none;"
                            >
                                Ilustrasi Stok Opname
                            </div>
                        </div>

                        <!-- Teks -->
                        <div class="max-w-md mb-6">
                            <p class="text-gray-700 dark:text-gray-200 text-base leading-relaxed">
                                Belum ada opname yang dipilih. Silakan pilih
                                <span class="font-semibold text-gray-900 dark:text-white">Mulai Opname Baru</span>
                                atau cek opname lainnya di
                                <span class="font-semibold text-gray-900 dark:text-white">Riwayat Opname</span>
                            </p>
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col gap-4 w-full max-w-[220px]">
                            <a
                                href="{{ route('persediaan.stokopname', ['mode' => 'history']) }}"
                                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-teal-500 hover:bg-teal-600 text-white font-semibold shadow-sm transition-colors duration-200"
                            >
                                <i class="fas fa-clock-rotate-left text-sm"></i>
                                Riwayat Opname
                            </a>

                            <button
                                type="button"
                                id="mulaiOpnameBaruBtn"
                                class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-teal-500 hover:bg-teal-600 text-white font-semibold shadow-sm transition-colors duration-200"
                            >
                                <i class="fas fa-circle-plus text-sm"></i>
                                Mulai Opname Baru
                            </button>
                        </div>
                    </div>
                </div>
            @elseif($mode === 'history')
                <div class="flex items-start justify-between gap-4 flex-wrap mb-3">
                    <div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('persediaan.stokopname') }}" class="text-gray-500 hover:text-gray-700 text-2xl">
                                <i class="fas fa-arrow-left"></i>
                            </a>

                            <div class="ml-3">
                                <h2 class="text-4xl font-bold text-blue-700 dark:text-blue-400">Riwayat Opname</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    Daftar stok opname yang sudah ditutup
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-3 flex-wrap mb-2">
                    <form method="GET" action="{{ route('persediaan.stokopname') }}" class="w-full max-w-xs">
                        <input type="hidden" name="mode" value="history">

                        <div class="relative">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Cari kode opname"
                                class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors duration-200"
                            >
                            <button
                                type="submit"
                                class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2 text-gray-500"
                            >
                                <i class="fas fa-bars-staggered text-sm"></i>
                                <i class="fas fa-search text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden flex-1 flex flex-col">
                    <div class="overflow-x-auto overflow-y-auto flex-1">
                        <table class="min-w-[1100px] w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 sticky top-0 z-10">
                                <tr>
                                    <th class="text-left px-4 py-3 font-semibold whitespace-nowrap w-16">No.</th>
                                    <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[220px]">Kode Opname</th>
                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[180px]">Tanggal Mulai</th>
                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[180px]">Tanggal Selesai</th>
                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">Total Produk</th>
                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">Status</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-950">
                                @forelse($riwayatOpnames as $index => $item)
                                    <tr class="border-t border-gray-100 dark:border-gray-800">
                                        <td class="px-4 py-4 align-top">{{ $index + 1 }}</td>

                                        <td class="px-4 py-4 align-top">
                                            <div class="font-medium text-gray-800 dark:text-gray-100">
                                                {{ $item->kode_opname }}
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                            {{ $item->tanggal_mulai ? \Carbon\Carbon::parse($item->tanggal_mulai)->format('d/m/Y H:i') : '-' }}
                                        </td>

                                        <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                            {{ $item->tanggal_selesai ? \Carbon\Carbon::parse($item->tanggal_selesai)->format('d/m/Y H:i') : '-' }}
                                        </td>

                                        <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200 font-semibold">
                                            {{ $item->detail_opnames_count ?? 0 }}
                                        </td>

                                        <td class="px-4 py-4 text-center align-top">
                                            <span class="inline-flex items-center px-2 py-1 rounded bg-green-500 text-white text-[11px] font-semibold leading-none">
                                                CLOSED
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="border-t border-gray-100 dark:border-gray-800">
                                        <td colspan="6" class="text-center py-24 text-gray-500 dark:text-gray-400">
                                            Belum ada riwayat opname
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                {{-- ACTIVE STATE --}}
                <div class="flex items-start justify-between gap-4 flex-wrap mb-3">
                    <div>
                        <div class="flex items-center gap-3">
                            <a href="{{ route('persediaan.stokopname') }}" class="text-gray-500 hover:text-gray-700 text-2xl">
                                <i class="fas fa-arrow-left"></i>
                            </a>
                            <div class="ml-3">
                                <h2 class="text-4xl font-bold text-blue-700 dark:text-blue-400">Stok Opname</h2>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    SO{{ now()->format('ymdHis') }} | APOTEK SAYA | OPEN
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('persediaan.stokopname.tutup') }}">
                        @csrf
                        <button
                            type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                        >
                            <i class="fas fa-lock"></i>
                            Tutup Opname
                        </button>
                    </form>
                </div>

                <!-- Toolbar -->
                <div class="flex items-center justify-between gap-3 flex-wrap mb-2">
                    <div class="flex items-center gap-2 flex-wrap">
                        <div class="relative min-w-[170px] pt-3" id="pilihanDataDropdownWrap">
                            <span class="absolute top-0 left-3 -translate-y-1/2 bg-white px-1 text-[11px] leading-none text-gray-400 z-10">
                                Pilihan Data
                            </span>

                            <button
                                type="button"
                                id="pilihanDataButton"
                                class="w-full h-11 pl-4 pr-10 rounded-lg border border-gray-300 bg-white text-gray-900 text-sm text-left focus:outline-none focus:ring-2 focus:ring-blue-100 transition-colors duration-200 relative"
                            >
                                <span id="pilihanDataText">Semua Produk</span>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500">
                                    <i id="pilihanDataIcon" class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                                </span>
                            </button>

                            <input type="hidden" id="pilihanDataValue" value="{{ request('filter_opname', 'semua') }}">

                            <div
                                id="pilihanDataDropdown"
                                class="hidden absolute left-0 top-full mt-2 w-full rounded-2xl border border-gray-200 bg-white shadow-xl z-[100] p-2"
                            >
                                <button
                                    type="button"
                                    class="pilihan-data-option w-full text-left px-4 py-3 rounded-xl text-sm hover:bg-blue-50"
                                    data-value="semua"
                                >
                                    Semua Produk
                                </button>

                                <button
                                    type="button"
                                    class="pilihan-data-option w-full text-left px-4 py-3 rounded-xl text-sm hover:bg-blue-50"
                                    data-value="perlu"
                                >
                                    Perlu Penyesuaian
                                </button>

                                <button
                                    type="button"
                                    class="pilihan-data-option w-full text-left px-4 py-3 rounded-xl text-sm hover:bg-blue-50"
                                    data-value="sudah"
                                >
                                    Sudah Diopname
                                </button>
                            </div>
                        </div>

                        <form method="GET" action="{{ route('persediaan.stokopname') }}" class="max-w-xs mt-3" id="stokOpnameSearchForm">
                            <input type="hidden" name="mode" value="active">
                            <input type="hidden" name="filter_opname" id="filterOpnameInput" value="{{ request('filter_opname', 'semua') }}">
                            <div class="relative">
                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Cari data"
                                    class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900 transition-colors duration-200"
                                >
                                <button
                                    type="submit"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2 text-gray-500 dark:text-gray-400"
                                >
                                    <i class="fas fa-bars-staggered text-sm"></i>
                                    <i class="fas fa-search text-sm"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap">
                        <button
                            type="button"
                            id="openFilterOpnameModalBtn"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200"
                        >
                            <i class="fas fa-filter text-sm"></i>
                            <span>Filter</span>
                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-white text-xs font-semibold">
                                {{ collect([
                                    request('filter_status_produk'),
                                    request('filter_status_stok'),
                                    request('filter_status_opname'),
                                    request('filter_rak'),
                                ])->filter(fn($v) => filled($v) && $v !== 'semua')->count() }}
                            </span>
                        </button>
                    </div>
                </div>

                <!-- Table -->
                <div class="rounded-xl border border-gray-100 dark:border-gray-800 overflow-hidden flex-1 flex flex-col">
                    <div class="overflow-x-auto overflow-y-auto flex-1">
                        <table class="min-w-[1500px] w-full text-sm">
                            <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 sticky top-0 z-10">
                                <tr>
                                    <th class="text-left px-4 py-3 font-semibold whitespace-nowrap w-16">
                                        <span class="inline-flex items-center gap-2">
                                            No.
                                            <i class="fas fa-sort text-xs text-gray-400"></i>
                                        </span>
                                    </th>

                                    <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[360px]">
                                        <span class="inline-flex items-center gap-2">
                                            Nama Produk
                                            <i class="fas fa-sort text-xs text-gray-400"></i>
                                        </span>
                                    </th>

                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">
                                        <span class="inline-flex items-center gap-2">
                                            Lokasi Rak
                                            <i class="fas fa-sort text-xs text-gray-400"></i>
                                        </span>
                                    </th>

                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">
                                        <span class="inline-flex items-center gap-2">
                                            Stok Fisik Saat Opname
                                            <i class="fas fa-sort text-xs text-gray-400"></i>
                                        </span>
                                    </th>

                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">
                                        <span class="inline-flex items-center gap-2">
                                            Selisih Saat Opname
                                            <i class="fas fa-sort text-xs text-gray-400"></i>
                                        </span>
                                    </th>

                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">Status</th>
                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[130px]">Waktu Opname</th>
                                    <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[150px]">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white dark:bg-gray-950">
                            @forelse($produks as $index => $produk)

                                @php
                                    $opname = $produk->stokOpname ?? null;
                                @endphp

                            <tr class="border-t border-gray-100 dark:border-gray-800">

                            <td class="px-4 py-4 align-top">
                                {{ $index + 1 }}
                            </td>

                            <td class="px-4 py-4 align-top">
                                <div class="font-medium text-gray-800 dark:text-gray-100">
                                    {{ $produk->nama_produk }}
                                </div>

                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                    SKU: {{ $produk->sku ?? '-' }}
                                </div>
                            </td>

                            <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                {{ $produk->rak_penyimpanan ?? '-' }}
                            </td>


                            {{-- STOK FISIK --}}
                            <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                {{ $opname->stok_fisik ?? '-' }}
                            </td>


                            {{-- SELISIH --}}
                            <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">
                                {{ $opname->selisih ?? '-' }}
                            </td>


                            {{-- STATUS --}}
                            <td class="px-4 py-4 text-center align-top">

                            @if($opname)

                            <span class="inline-flex items-center px-2 py-1 rounded bg-green-500 text-white text-[11px] font-semibold leading-none">
                                SUDAH DIOPNAME
                            </span>

                            @else

                            <span class="inline-flex items-center px-2 py-1 rounded bg-red-500 text-white text-[11px] font-semibold leading-none">
                                BELUM DIOPNAME
                            </span>

                            @endif

                            </td>


                            {{-- WAKTU OPNAME --}}
                            <td class="px-4 py-4 text-center align-top text-gray-700 dark:text-gray-200">

                            @if($opname && $opname->waktu_opname)
                                {{ \Carbon\Carbon::parse($opname->waktu_opname)->format('d/m/Y H:i') }}
                            @else
                                -
                            @endif

                            </td>


                            <td class="px-4 py-4 text-center align-top">

                            <button
                                type="button"
                                onclick="openOpnameModal('{{ $produk->id }}','{{ $produk->nama_produk }}','{{ $produk->satuan_utama ?? 'Box' }}')"
                                class="px-3 py-2 rounded-lg border border-blue-400 text-blue-600 text-xs font-semibold hover:bg-blue-50 transition-colors duration-200"
                            >
                                Opname Sekarang
                            </button>

                            </td>

                            </tr>

                            @empty

                            <tr class="border-t border-gray-100 dark:border-gray-800">

                            <td colspan="8" class="text-center py-24 text-gray-500 dark:text-gray-400">
                                Data tidak ditemukan
                            </td>

                            </tr>

                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer Summary -->
                    <div class="border-t border-gray-200 bg-white dark:bg-gray-950 px-4 py-4">
                        <div class="flex items-center justify-between flex-wrap gap-4">
                            <div>
                                <h4 class="text-2xl font-bold text-blue-700 dark:text-blue-400">Ringkasan Opname</h4>
                            </div>

                            <div class="flex items-center gap-8 flex-wrap text-gray-700 dark:text-gray-200">
                                <div>
                                    <span class="font-medium">Produk Diopname</span>
                                    <span class="ml-2">: 0/{{ $produks->count() }} produk</span>
                                </div>

                                <div>
                                    <span class="font-medium">Produk Belum Diopname</span>
                                    <span class="ml-2">: {{ $produks->count() }}/{{ $produks->count() }} produk</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Proses Mulai Opname -->
    <div id="startOpnameModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

        <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-8">
            <div class="relative z-[10000] w-full max-w-[520px] bg-white rounded-3xl shadow-2xl overflow-hidden px-10 py-12 text-center">

                <!-- Loading State -->
                <div id="opnameLoadingState">
                    <div class="mx-auto mb-8 w-24 h-24 rounded-full border-4 border-blue-100 border-t-blue-500 animate-spin"></div>
                    <h3 class="text-4xl font-bold text-gray-700 mb-3">Memulai Opname...</h3>
                    <p class="text-gray-500 text-xl">Mohon tunggu sebentar</p>
                </div>

                <!-- Success State -->
                <div id="opnameSuccessState" class="hidden">
                    <div class="mx-auto mb-8 w-24 h-24 rounded-full border-4 border-green-200 flex items-center justify-center">
                        <i class="fas fa-check text-5xl text-green-400"></i>
                    </div>

                    <h3 class="text-5xl font-bold text-gray-700 mb-4">Opname Dimulai!</h3>
                    <p class="text-gray-500 text-2xl mb-8">Opname baru berhasil dibuka</p>

                    <button
                        type="button"
                        id="confirmStartOpnameBtn"
                        class="px-8 py-3 rounded-2xl bg-indigo-500 hover:bg-indigo-600 text-white font-bold text-2xl shadow-md transition-colors duration-200"
                    >
                        OK
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Opname -->
    <div id="opnameModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-black/50"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">
            <form
                method="POST"
                action="{{ route('persediaan.stokopname.store') }}"
                class="bg-white rounded-2xl shadow-2xl w-[560px] max-w-full overflow-hidden"
            >
                @csrf

                <input type="hidden" name="produk_id" id="opnameProdukId">

                <!-- Header -->
                <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                    <span class="font-semibold">Tambah Opname Produk</span>
                    <button type="button" onclick="closeOpnameModal()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6">
                    <h3 id="opnameNamaProduk" class="text-2xl font-bold text-blue-700 mb-6"></h3>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="text-sm text-gray-600">Stok Fisik</label>

                            <div class="flex items-center gap-2 mt-1">
                                <input
                                    type="number"
                                    name="stok_fisik"
                                    id="stokFisikInput"
                                    class="w-full border rounded-lg px-3 py-2"
                                    value="0"
                                    min="0"
                                    required
                                >
                                <span id="satuanProduk">Box</span>
                            </div>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Catatan</label>
                            <input
                                type="text"
                                name="catatan"
                                id="catatanInput"
                                class="w-full border rounded-lg px-3 py-2 mt-1"
                            >
                        </div>
                    </div>

                    <div class="border-t pt-4 flex justify-between items-center">
                        <div class="text-sm">
                            Total Stok Fisik
                            <div class="font-bold text-blue-600">
                                <span id="totalStok">0</span>
                                <span id="satuanProduk2">Box</span>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button
                                type="button"
                                onclick="closeOpnameModal()"
                                class="px-4 py-2 text-gray-500"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="px-4 py-2 bg-teal-500 text-white rounded-lg"
                            >
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Filter Opname -->
    <div id="filterOpnameModal" class="fixed inset-0 z-[9999] hidden">
        <div id="filterOpnameOverlay" class="absolute inset-0 bg-black/50"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">
            <form
                method="GET"
                action="{{ route('persediaan.stokopname') }}"
                class="bg-white rounded-2xl shadow-2xl w-[560px] max-w-full overflow-hidden"
            >
                <input type="hidden" name="mode" value="active">
                <input type="hidden" name="search" value="{{ request('search') }}">

                <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                    <span class="text-2xl font-bold">Filter Data</span>
                    <button type="button" id="closeFilterOpnameModalBtn">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-[180px_20px_1fr] items-center gap-3">
                        <label class="text-gray-700">Status Produk</label>
                        <span class="text-gray-400">:</span>
                        <select name="filter_status_produk" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
                            <option value="semua" {{ request('filter_status_produk', 'semua') === 'semua' ? 'selected' : '' }}>Semua Produk</option>
                            <option value="dijual" {{ request('filter_status_produk') === 'dijual' ? 'selected' : '' }}>Dijual</option>
                            <option value="tidak_dijual" {{ request('filter_status_produk') === 'tidak_dijual' ? 'selected' : '' }}>Tidak Dijual</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-[180px_20px_1fr] items-center gap-3">
                        <label class="text-gray-700">Status Stok</label>
                        <span class="text-gray-400">:</span>
                        <select name="filter_status_stok" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
                            <option value="semua" {{ request('filter_status_stok', 'semua') === 'semua' ? 'selected' : '' }}>Semua Stok</option>
                            <option value="habis" {{ request('filter_status_stok') === 'habis' ? 'selected' : '' }}>Stok Habis</option>
                            <option value="rendah" {{ request('filter_status_stok') === 'rendah' ? 'selected' : '' }}>Stok Rendah</option>
                            <option value="aman" {{ request('filter_status_stok') === 'aman' ? 'selected' : '' }}>Stok Aman</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-[180px_20px_1fr] items-center gap-3">
                        <label class="text-gray-700">Status Opname Produk</label>
                        <span class="text-gray-400">:</span>
                        <select name="filter_status_opname" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
                            <option value="semua" {{ request('filter_status_opname', 'semua') === 'semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="belum" {{ request('filter_status_opname') === 'belum' ? 'selected' : '' }}>Belum Diopname</option>
                            <option value="sudah" {{ request('filter_status_opname') === 'sudah' ? 'selected' : '' }}>Sudah Diopname</option>
                            <option value="selisih" {{ request('filter_status_opname') === 'selisih' ? 'selected' : '' }}>Perlu Penyesuaian</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-[180px_20px_1fr] items-center gap-3">
                        <label class="text-gray-700">Rak Penyimpanan</label>
                        <span class="text-gray-400">:</span>
                        <select name="filter_rak" class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm">
                            <option value="semua">Semua Rak</option>
                            @foreach(($raks ?? []) as $rak)
                                <option value="{{ $rak->nama_rak }}" {{ request('filter_rak') === $rak->nama_rak ? 'selected' : '' }}>
                                    {{ $rak->nama_rak }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="border-t px-6 py-4 flex items-center justify-between">
                    <button
                        type="button"
                        id="resetFilterBtn"
                        class="text-sky-500 font-semibold"
                    >
                        Reset Filter
                    </button>

                    <button
                        type="submit"
                        class="px-5 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold"
                    >
                        Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')

<script>
// SCRIPT MULAI OPNAME BARU
document.addEventListener('DOMContentLoaded', function () {

    const mulaiOpnameBaruBtn = document.getElementById('mulaiOpnameBaruBtn');
    const startOpnameModal = document.getElementById('startOpnameModal');
    const opnameLoadingState = document.getElementById('opnameLoadingState');
    const opnameSuccessState = document.getElementById('opnameSuccessState');
    const confirmStartOpnameBtn = document.getElementById('confirmStartOpnameBtn');
    const pilihanDataButton = document.getElementById('pilihanDataButton');
    const pilihanDataDropdown = document.getElementById('pilihanDataDropdown');
    const pilihanDataText = document.getElementById('pilihanDataText');
    const pilihanDataValue = document.getElementById('pilihanDataValue');
    const pilihanDataIcon = document.getElementById('pilihanDataIcon');
    const filterOpnameInput = document.getElementById('filterOpnameInput');
    const pilihanDataWrap = document.getElementById('pilihanDataDropdownWrap');
    const pilihanOptions = document.querySelectorAll('.pilihan-data-option');
    const openFilterOpnameModalBtn = document.getElementById('openFilterOpnameModalBtn');
    const filterOpnameModal = document.getElementById('filterOpnameModal');
    const filterOpnameOverlay = document.getElementById('filterOpnameOverlay');
    const closeFilterOpnameModalBtn = document.getElementById('closeFilterOpnameModalBtn');

    function openStartOpnameModal() {

        if (!startOpnameModal) return;

        startOpnameModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');

        opnameLoadingState?.classList.remove('hidden');
        opnameSuccessState?.classList.add('hidden');

        setTimeout(() => {

            opnameLoadingState?.classList.add('hidden');
            opnameSuccessState?.classList.remove('hidden');

        }, 1400);
    }

    mulaiOpnameBaruBtn?.addEventListener('click', openStartOpnameModal);

    confirmStartOpnameBtn?.addEventListener('click', function () {

        window.location.href = "{{ route('persediaan.stokopname') }}?mode=active";

    });

    const labelMap = {
        semua: 'Semua Produk',
        perlu: 'Perlu Penyesuaian',
        sudah: 'Sudah Diopname',
    };

    function openPilihanDropdown() {
        pilihanDataDropdown?.classList.remove('hidden');
        pilihanDataIcon?.classList.add('rotate-180');
    }

    function closePilihanDropdown() {
        pilihanDataDropdown?.classList.add('hidden');
        pilihanDataIcon?.classList.remove('rotate-180');
    }

    function setActivePilihan(value) {
        if (pilihanDataValue) pilihanDataValue.value = value;
        if (filterOpnameInput) filterOpnameInput.value = value;
        if (pilihanDataText) pilihanDataText.textContent = labelMap[value] ?? 'Semua Produk';

        pilihanOptions.forEach((option) => {
            const isActive = option.dataset.value === value;
            option.classList.toggle('bg-blue-100', isActive);
            option.classList.toggle('text-gray-900', true);
        });
    }

    pilihanDataButton?.addEventListener('click', function (e) {
        e.preventDefault();

        if (pilihanDataDropdown?.classList.contains('hidden')) {
            openPilihanDropdown();
        } else {
            closePilihanDropdown();
        }
    });

    pilihanOptions.forEach((option) => {
        option.addEventListener('click', function () {
            const value = this.dataset.value;
            setActivePilihan(value);
            closePilihanDropdown();

            document.getElementById('stokOpnameSearchForm')?.submit();
        });
    });

    document.addEventListener('click', function (e) {
        if (!pilihanDataWrap?.contains(e.target)) {
            closePilihanDropdown();
        }
    });

    setActivePilihan("{{ request('filter_opname', 'semua') }}");

    function openFilterOpnameModal() {
        if (!filterOpnameModal) return;
        filterOpnameModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeFilterOpnameModal() {
        if (!filterOpnameModal) return;
        filterOpnameModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    openFilterOpnameModalBtn?.addEventListener('click', openFilterOpnameModal);
    closeFilterOpnameModalBtn?.addEventListener('click', closeFilterOpnameModal);
    filterOpnameOverlay?.addEventListener('click', closeFilterOpnameModal);

});


// SCRIPT MODAL OPNAME PRODUK

function openOpnameModal(id, nama, satuan) {
    const modal = document.getElementById('opnameModal');
    modal.classList.remove('hidden');
    document.body.classList.add('overflow-hidden');

    document.getElementById('opnameProdukId').value = id;
    document.getElementById('opnameNamaProduk').innerText = nama;
    document.getElementById('satuanProduk').innerText = satuan;
    document.getElementById('satuanProduk2').innerText = satuan;

    document.getElementById('stokFisikInput').value = 0;
    document.getElementById('catatanInput').value = '';
    document.getElementById('totalStok').innerText = 0;
}

function closeOpnameModal() {
    document.getElementById('opnameModal').classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

const stokInput = document.getElementById('stokFisikInput');

if (stokInput) {
    stokInput.addEventListener('input', function () {
        document.getElementById('totalStok').innerText = this.value || 0;
    });
}

function saveOpnameAndClose() {
    const modal = document.getElementById('opnameModal');
    if (!modal) return;

    modal.classList.add('hidden');
    document.body.classList.remove('overflow-hidden');
}

const resetFilterBtn = document.getElementById('resetFilterBtn');

resetFilterBtn?.addEventListener('click', function () {

    const form = this.closest('form');

    form.querySelectorAll('select').forEach(function(select){
        select.value = 'semua';
    });

});
</script>

@endpush