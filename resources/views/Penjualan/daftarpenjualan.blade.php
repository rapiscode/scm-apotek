@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Daftar Penjualan')
@section('page_title', 'Daftar Penjualan')
@section('page_subtitle', 'Kelola data transaksi penjualan.')

@section('content')
<div class="h-[calc(100vh-9rem)]">
    <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 h-full flex flex-col">

        <!-- Header -->
        <div class="flex items-center justify-between gap-4 flex-wrap mb-3">
            <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Daftar Penjualan</h2>
        </div>

        <!-- Toolbar -->
        <div class="flex items-center justify-between gap-3 flex-wrap mb-2">
            <div class="flex items-center gap-2 flex-wrap">
                <div class="relative min-w-[180px] pt-3">
                    <span class="absolute top-0 left-3 -translate-y-1/2 bg-white px-1 text-[11px] text-gray-400 z-10">
                        Pilihan Data
                    </span>

                    <select class="appearance-none w-full h-11 pl-4 pr-10 rounded-lg border border-gray-300 bg-white text-gray-900 text-sm">
                        <option>Struk Penjualan</option>
                    </select>

                    <div class="pointer-events-none absolute right-3 top-[calc(50%+6px)] -translate-y-1/2 text-gray-500">
                        <i class="fas fa-chevron-down text-xs"></i>
                    </div>
                </div>

                <form method="GET" action="{{ route('penjualan.daftarpenjualan') }}" class="max-w-xs mt-3">
                    <div class="relative">
                        <input
                            type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari data"
                            class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-200 bg-white text-gray-900 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-100"
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

            <div class="flex items-center gap-2 flex-wrap">
                <!-- Filter Tgl -->
                <form method="GET" action="{{ route('penjualan.daftarpenjualan') }}" id="filterTanggalForm" class="flex items-end gap-2 flex-wrap">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="status_transaksi" value="{{ request('status_transaksi', 'semua') }}">

                    <div class="flex flex-col">
                        <span class="text-[11px] text-gray-400 ml-2 mb-1">Filter Tgl</span>

                        <div class="flex items-center gap-2">
                            <input
                                type="date"
                                name="tanggal_awal"
                                value="{{ request('tanggal_awal') }}"
                                onchange="document.getElementById('filterTanggalForm').submit()"
                                class="h-11 rounded-lg border border-gray-200 bg-white text-gray-700 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100"
                            >

                            <span class="text-gray-400 text-sm">s/d</span>

                            <input
                                type="date"
                                name="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}"
                                onchange="document.getElementById('filterTanggalForm').submit()"
                                class="h-11 rounded-lg border border-gray-200 bg-white text-gray-700 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-100"
                            >
                        </div>
                    </div>
                </form>

                <!-- Filter -->
                <button
                    type="button"
                    id="openFilterPenjualanModalBtn"
                    class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 bg-white text-gray-700"
                >
                    <i class="fas fa-filter text-sm"></i>
                    <span>Filter</span>
                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-white text-xs font-semibold">
                        {{ collect([
                            request('status_transaksi'),
                        ])->filter(fn($v) => filled($v) && $v !== 'semua')->count() }}
                    </span>
                </button>

                <button
                    type="button"
                    class="mt-5 w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600"
                >
                    <i class="fas fa-shuffle text-sm"></i>
                </button>

                <a
                    href="{{ route('penjualan.export.excel') }}"
                    class="mt-5 w-10 h-10 rounded-lg border border-gray-200 bg-white text-gray-600 flex items-center justify-center"
                >
                    <i class="fas fa-download text-sm"></i>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="rounded-xl border border-gray-100 overflow-hidden flex-1 flex flex-col">
            <div class="overflow-x-auto overflow-y-auto flex-1">
                <table class="min-w-[1400px] w-full text-sm">
                    <thead class="bg-gray-50 text-gray-700 sticky top-0 z-10">
                        <tr>
                            <th class="text-left px-4 py-3 font-semibold w-16">No.</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[140px]">Tanggal</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[180px]">No. Struk</th>
                            <th class="text-left px-4 py-3 font-semibold min-w-[500px]">Produk</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[160px]">Total Penjualan</th>
                            <th class="text-center px-4 py-3 font-semibold min-w-[140px]">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @forelse($penjualans as $index => $item)
                            <tr class="border-t border-gray-100">
                                <td class="px-4 py-4 align-top">{{ $index + 1 }}</td>

                                <td class="px-4 py-4 align-top text-center text-gray-700">
                                    {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}<br>
                                    {{ \Carbon\Carbon::parse($item->tanggal)->format('H:i') }}
                                </td>

                                <td class="px-4 py-4 align-top text-center text-gray-800">
                                    {{ $item->no_struk }}
                                </td>

                                {{-- PRODUK --}}
                                <td class="px-4 py-4 align-top text-gray-700">
                                    @forelse($item->details as $detail)
                                        <div>
                                            {{ $detail->qty }} {{ $detail->satuan }} x {{ $detail->produk->nama_produk ?? '-' }}
                                        </div>
                                    @empty
                                        -
                                    @endforelse
                                </td>

                                {{-- TOTAL PENJUALAN --}}
                                <td class="px-4 py-4 align-top text-center text-gray-800 font-medium">
                                    Rp {{ number_format($item->total_penjualan, 2, ',', '.') }}
                                </td>

                                <td class="px-4 py-4 align-top text-center">
                                    <button
                                        type="button"
                                        class="detail-btn inline-flex items-center px-4 py-2 rounded-lg border border-blue-400 text-blue-600 text-xs font-semibold hover:bg-blue-50"
                                        data-id="{{ $item->id }}"
                                    >
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-gray-100">
                                <td colspan="6" class="text-center py-24 text-gray-500">
                                    Data penjualan belum ada
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Penjualan -->
<div id="detailModal" class="fixed inset-0 z-[9999] hidden">
    <div id="detailOverlay" class="absolute inset-0 bg-black/50"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-[1200px] rounded-xl shadow-xl overflow-hidden">

            <!-- Header -->
            <div class="bg-blue-600 px-5 py-4 flex items-center justify-between text-white">
                <h2 class="text-xl font-bold">Detail Penjualan</h2>

                <button id="closeDetailModal" class="text-white text-xl">
                    ✕
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 grid grid-cols-12 gap-6">

                <!-- Kiri -->
                <div class="col-span-12 xl:col-span-8">

                    <div class="grid grid-cols-4 gap-4 mb-6">
                        <div>
                            <div class="text-sm text-gray-500">Waktu Penjualan</div>
                            <div id="detailTanggal" class="font-semibold"></div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-500">Petugas</div>
                            <div>Admin</div>
                        </div>

                        <div>
                            <div class="text-sm text-gray-500">Total Penjualan</div>
                            <div id="detailTotal" class="font-semibold"></div>
                        </div>
                    </div>

                    <!-- Barang Terjual -->
                    <h3 class="text-lg font-bold text-blue-700 mb-2">Barang Terjual</h3>

                    <table class="w-full text-sm border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-3 py-2">No</th>
                                <th class="px-3 py-2 text-left">Nama Produk</th>
                                <th class="px-3 py-2">Harga</th>
                                <th class="px-3 py-2">Qty</th>
                                <th class="px-3 py-2">Subtotal</th>
                            </tr>
                        </thead>

                        <tbody id="detailItems"></tbody>
                    </table>

                </div>

                <!-- Kanan (Preview Struk) -->
                <div class="col-span-12 xl:col-span-4 border-l pl-6">

                    <div class="text-center mb-6">
                        <h2 class="text-xl font-bold">Apotek Saya</h2>
                    </div>

                    <div id="detailStrukItems" class="space-y-2 text-sm"></div>

                    <div class="border-t mt-4 pt-3 font-bold flex justify-between">
                        <span>Total</span>
                        <span id="detailStrukTotal"></span>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>

<!-- Modal Filter Penjualan -->
<div id="filterPenjualanModal" class="fixed inset-0 z-[9999] hidden">
    <div id="filterPenjualanOverlay" class="absolute inset-0 bg-black/50"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <form
            method="GET"
            action="{{ route('penjualan.daftarpenjualan') }}"
            class="bg-white rounded-2xl shadow-2xl w-[440px] max-w-full overflow-hidden"
        >
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">

            <div class="bg-blue-600 text-white px-6 py-4 flex justify-between items-center">
                <span class="text-2xl font-bold">Filter Data</span>
                <button type="button" id="closeFilterPenjualanModalBtn">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="p-6 space-y-4">
                <div class="grid grid-cols-[170px_20px_1fr] items-center gap-3">
                    <label class="text-gray-700">Status Transaksi</label>
                    <span class="text-gray-400">:</span>
                    <select
                        name="status_transaksi"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 text-sm"
                    >
                        <option value="semua" {{ request('status_transaksi', 'semua') === 'semua' ? 'selected' : '' }}>
                            Semua
                        </option>
                        <option value="selesai" {{ request('status_transaksi') === 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="draft" {{ request('status_transaksi') === 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                        <option value="batal" {{ request('status_transaksi') === 'batal' ? 'selected' : '' }}>
                            Batal
                        </option>
                    </select>
                </div>
            </div>

            <div class="border-t px-6 py-4 flex items-center justify-between">
                <a
                    href="{{ route('penjualan.daftarpenjualan') }}"
                    class="text-sky-500 font-semibold"
                >
                    Reset Filter
                </a>

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
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('detailModal');
    const overlay = document.getElementById('detailOverlay');
    const closeBtn = document.getElementById('closeDetailModal');

    const detailTanggal = document.getElementById('detailTanggal');
    const detailTotal = document.getElementById('detailTotal');
    const detailItems = document.getElementById('detailItems');
    const detailStrukItems = document.getElementById('detailStrukItems');
    const detailStrukTotal = document.getElementById('detailStrukTotal');

    const openFilterPenjualanModalBtn = document.getElementById('openFilterPenjualanModalBtn');
    const filterPenjualanModal = document.getElementById('filterPenjualanModal');
    const filterPenjualanOverlay = document.getElementById('filterPenjualanOverlay');
    const closeFilterPenjualanModalBtn = document.getElementById('closeFilterPenjualanModalBtn');

    function formatRupiah(value) {
        return Number(value || 0).toLocaleString('id-ID');
    }

    function openDetailModal() {
        if (!modal) return;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDetailModal() {
        if (!modal) return;
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function openFilterPenjualanModal() {
        if (!filterPenjualanModal) return;
        filterPenjualanModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeFilterPenjualanModal() {
        if (!filterPenjualanModal) return;
        filterPenjualanModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    document.querySelectorAll('.detail-btn').forEach(btn => {
        btn.addEventListener('click', async function () {
            try {
                const id = this.dataset.id;

                const res = await fetch(`/penjualan/detail/${id}`);
                if (!res.ok) throw new Error('Gagal mengambil detail penjualan');

                const data = await res.json();

                if (detailTanggal) detailTanggal.innerText = data.tanggal ?? '-';
                if (detailTotal) detailTotal.innerText = 'Rp ' + formatRupiah(data.total_penjualan);

                if (detailItems) detailItems.innerHTML = '';
                if (detailStrukItems) detailStrukItems.innerHTML = '';

                if (Array.isArray(data.details) && data.details.length > 0) {
                    data.details.forEach((item, index) => {
                        const subtotal = Number(item.qty || 0) * Number(item.harga_jual || 0);
                        const namaProduk = item.produk?.nama_produk ?? '-';

                        if (detailItems) {
                            detailItems.innerHTML += `
                                <tr class="border-t">
                                    <td class="px-3 py-2">${index + 1}</td>
                                    <td class="px-3 py-2">${namaProduk}</td>
                                    <td class="px-3 py-2 text-center">Rp ${formatRupiah(item.harga_jual)}</td>
                                    <td class="px-3 py-2 text-center">${item.qty}</td>
                                    <td class="px-3 py-2 text-center">Rp ${formatRupiah(subtotal)}</td>
                                </tr>
                            `;
                        }

                        if (detailStrukItems) {
                            detailStrukItems.innerHTML += `
                                <div class="mb-2">
                                    <div class="font-semibold">${namaProduk}</div>
                                    <div class="flex justify-between text-sm">
                                        <span>${item.qty} x ${formatRupiah(item.harga_jual)}</span>
                                        <span>${formatRupiah(subtotal)}</span>
                                    </div>
                                </div>
                            `;
                        }
                    });
                } else {
                    if (detailItems) {
                        detailItems.innerHTML = `
                            <tr class="border-t">
                                <td colspan="5" class="px-3 py-6 text-center text-gray-500">
                                    Tidak ada detail penjualan
                                </td>
                            </tr>
                        `;
                    }

                    if (detailStrukItems) {
                        detailStrukItems.innerHTML = `
                            <div class="text-sm text-gray-500 text-center">
                                Tidak ada detail penjualan
                            </div>
                        `;
                    }
                }

                if (detailStrukTotal) {
                    detailStrukTotal.innerText = 'Rp ' + formatRupiah(data.total_penjualan);
                }

                openDetailModal();
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat mengambil detail');
            }
        });
    });

    overlay?.addEventListener('click', closeDetailModal);
    closeBtn?.addEventListener('click', closeDetailModal);

    openFilterPenjualanModalBtn?.addEventListener('click', openFilterPenjualanModal);
    closeFilterPenjualanModalBtn?.addEventListener('click', closeFilterPenjualanModal);
    filterPenjualanOverlay?.addEventListener('click', closeFilterPenjualanModal);
});
</script>
@endpush