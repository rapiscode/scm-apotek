@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Kasir')
@section('page_title', 'Kasir')
@section('page_subtitle', 'Transaksi penjualan produk.')

@section('content')
    <div class="grid grid-cols-12 gap-4 min-h-[calc(100vh-140px)]">

        <!-- Kiri -->
        <div class="col-span-12 xl:col-span-9">
            <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden transition-colors duration-200 flex flex-col h-full">

                <!-- Search Bar -->
                <div class="bg-blue-600 px-4 py-3 flex items-center gap-3 relative">
                    <div class="relative flex-1">
                        <input
                            type="text"
                            id="produkSearchInput"
                            placeholder="Tulis produk, SKU, code barcode"
                            autocomplete="off"
                            class="w-full rounded-full bg-white text-gray-700 placeholder:text-gray-400 px-5 py-2.5 pr-12 text-sm focus:outline-none"
                        >

                        <button
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center"
                        >
                            <i class="fas fa-arrow-left"></i>
                        </button>

                        <!-- Dropdown hasil pencarian -->
                        <div
                            id="produkSearchResults"
                            class="hidden absolute left-0 right-0 mt-2 bg-white border border-gray-200 rounded-xl shadow-xl z-50 max-h-80 overflow-y-auto"
                        ></div>
                    </div>

                    <button type="button" id="clearCartBtn" class="text-white text-lg">
                        <i class="fas fa-trash-alt"></i>
                    </button>

                    <div class="text-white text-right min-w-[110px]">
                        <p class="text-sm font-semibold">Rp.</p>
                        <p id="grandTotalText" class="text-3xl font-bold leading-none">0,00</p>
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

                <!-- Table Body -->
                <div class="px-4 pb-4 flex-1">
                    <div class="h-full rounded-b-xl bg-gray-50 dark:bg-gray-900 overflow-y-auto">
                        <div id="emptyStateKasir" class="flex items-start justify-center pt-6 text-gray-700 dark:text-gray-200 h-full">
                            Silahkan Pilih Produk
                        </div>

                        <div id="kasirRowsWrapper" class="hidden">
                            <table class="w-full text-sm">
                                <tbody id="kasirTableBody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kanan -->
        <div class="col-span-12 xl:col-span-3 space-y-3">

            <!-- Ringkasan -->
            <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">

                <div class="flex flex-col gap-4 w-full">

                    <button
                        type="button"
                        id="openPembayaranModalBtn"
                        class="w-full h-28 rounded-2xl bg-teal-500 hover:bg-teal-600 text-white font-bold text-xl shadow-md transition"
                    >
                        Bayar
                    </button>

                    <button
                        type="button"
                        id="btnTundaTransaksi"
                        class="w-full h-28 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xl shadow-md transition"
                    >
                        Tunda
                    </button>

                </div>

            </div>

        </div>
    </div>

    <!-- Modal Pembayaran -->
    <div id="pembayaranModal" class="fixed inset-0 z-[9999] hidden">
        <div id="pembayaranOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl w-full max-w-[460px] overflow-hidden">
                
                <!-- Header -->
                <div class="bg-blue-600 px-6 py-4 flex items-center justify-between text-white">
                    <h3 class="text-2xl font-bold">Pembayaran</h3>
                    <button type="button" id="closePembayaranModalBtn" class="text-white text-xl">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <div class="text-center mb-6">
                        <div class="text-blue-700 font-bold text-2xl mb-1">TOTAL</div>
                        <div id="modalGrandTotalText" class="text-blue-700 font-extrabold text-5xl">
                            Rp. 0,00
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-5">
                        <button type="button" class="quick-cash-btn rounded-full border border-blue-400 text-blue-700 font-semibold py-2" data-amount="pas">
                            Uang Pas
                        </button>
                        <button type="button" class="quick-cash-btn rounded-full border border-blue-400 text-blue-700 font-semibold py-2" data-amount="20000">
                            20.000
                        </button>
                        <button type="button" class="quick-cash-btn rounded-full border border-blue-400 text-blue-700 font-semibold py-2" data-amount="50000">
                            50.000
                        </button>
                        <button type="button" class="quick-cash-btn rounded-full border border-blue-400 text-blue-700 font-semibold py-2" data-amount="100000">
                            100.000
                        </button>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between gap-4">
                            <label class="text-2xl text-gray-700">Uang Tunai</label>
                            <input
                                type="number"
                                id="uangTunaiInput"
                                min="0"
                                value="0"
                                class="w-52 rounded-xl border border-gray-300 px-4 py-3 text-right text-lg"
                            >
                        </div>

                        <div class="text-center pt-4">
                            <div class="text-red-500 font-bold text-2xl">Pembayaran Kurang</div>
                            <div id="kembalianText" class="text-gray-800 text-4xl font-medium">
                                Rp. -0,00
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="border-t px-6 py-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <button type="button" class="w-12 h-12 rounded-xl border border-gray-300 text-gray-600">
                            <i class="fas fa-print"></i>
                        </button>
                        <button type="button" class="w-12 h-12 rounded-xl border border-gray-300 text-gray-600">
                            <i class="fab fa-whatsapp"></i>
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <button
                            type="button"
                            id="cancelPembayaranModalBtn"
                            class="px-5 py-3 rounded-xl text-gray-400 font-semibold"
                        >
                            Batal
                        </button>

                        <button
                            type="button"
                            id="buatTransaksiBtn"
                            class="px-6 py-3 rounded-xl bg-teal-400 text-white font-bold"
                        >
                            Buat Transaksi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@php
    $draftPenjualanData = null;

    if (isset($penjualan) && $penjualan) {
        $draftPenjualanData = [
            'id' => $penjualan->id,
            'status' => $penjualan->status,
            'items' => $penjualan->details->map(function ($detail) {
                return [
                    'id' => $detail->produk->id ?? null,
                    'nama_produk' => $detail->produk->nama_produk ?? '-',
                    'sku' => $detail->produk->sku ?? '-',
                    'barcode' => $detail->produk->barcode ?? '',
                    'satuan_utama' => $detail->satuan ?? ($detail->produk->satuan_utama ?? 'Pcs'),
                    'stok' => $detail->produk->stok ?? 0,
                    'price' => (float) $detail->harga_jual,
                    'qty' => (int) $detail->qty,
                ];
            })->values()->toArray(),
        ];
    }
@endphp

<script>
const draftPenjualan = @json($draftPenjualanData);

document.addEventListener('DOMContentLoaded', function () {
    const openPembayaranModalBtn = document.getElementById('openPembayaranModalBtn');
    const pembayaranModal = document.getElementById('pembayaranModal');
    const pembayaranOverlay = document.getElementById('pembayaranOverlay');
    const closePembayaranModalBtn = document.getElementById('closePembayaranModalBtn');
    const cancelPembayaranModalBtn = document.getElementById('cancelPembayaranModalBtn');
    const modalGrandTotalText = document.getElementById('modalGrandTotalText');
    const uangTunaiInput = document.getElementById('uangTunaiInput');
    const kembalianText = document.getElementById('kembalianText');
    const quickCashButtons = document.querySelectorAll('.quick-cash-btn');
    const buatTransaksiBtn = document.getElementById('buatTransaksiBtn');
    const btnTundaTransaksi = document.getElementById('btnTundaTransaksi');

    const searchInput = document.getElementById('produkSearchInput');
    const resultsBox = document.getElementById('produkSearchResults');
    const tbody = document.getElementById('kasirTableBody');
    const emptyState = document.getElementById('emptyStateKasir');
    const rowsWrapper = document.getElementById('kasirRowsWrapper');
    const grandTotalText = document.getElementById('grandTotalText');
    const clearCartBtn = document.getElementById('clearCartBtn');

    let debounceTimer = null;
    const cart = [];
    let currentDraftId = draftPenjualan?.id ?? null;

    function formatRupiah(number) {
        return Number(number || 0).toLocaleString('id-ID');
    }

    function getGrandTotal() {
        return cart.reduce((sum, item) => sum + (item.qty * item.price), 0);
    }

    function updateGrandTotal() {
        const total = getGrandTotal();

        if (grandTotalText) {
            grandTotalText.textContent = formatRupiah(total) + ',00';
        }
    }

    function renderCart() {
        if (!tbody) return;

        tbody.innerHTML = '';

        if (cart.length === 0) {
            rowsWrapper?.classList.add('hidden');
            emptyState?.classList.remove('hidden');
            updateGrandTotal();
            return;
        }

        rowsWrapper?.classList.remove('hidden');
        emptyState?.classList.add('hidden');

        cart.forEach((item, index) => {
            const subtotal = item.qty * item.price;

            const tr = document.createElement('tr');
            tr.className = 'border-b border-gray-100';

            tr.innerHTML = `
                <td class="px-2 py-4 align-top w-[50px]">${index + 1}</td>

                <td class="px-2 py-4 align-top min-w-[260px]">
                    <div class="font-medium text-gray-800">${item.nama_produk}</div>
                    <div class="text-xs text-gray-500 mt-1">SKU: ${item.sku ?? '-'}</div>
                    <div class="text-xs text-gray-500">Stok: ${item.stok ?? 0} ${item.satuan_utama ?? ''}</div>
                </td>

                <td class="px-2 py-4 align-top w-[120px]">
                    <input
                        type="number"
                        min="1"
                        value="${item.qty}"
                        data-index="${index}"
                        class="qty-input w-full rounded-lg border border-gray-200 px-3 py-2 text-center"
                    >
                </td>

                <td class="px-2 py-4 align-top w-[120px]">
                    <select class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-white">
                        <option selected>${item.satuan_utama ?? 'Pcs'}</option>
                    </select>
                </td>

                <td class="px-2 py-4 align-top w-[150px]">
                    <select class="w-full rounded-lg border border-gray-200 px-3 py-2 bg-white">
                        <option selected>#1 Harga Umum</option>
                    </select>
                </td>

                <td class="px-2 py-4 align-top w-[140px]">
                    <input
                        type="text"
                        value="${formatRupiah(item.price)}"
                        class="w-full rounded-lg border border-gray-200 px-3 py-2 text-right bg-white"
                        readonly
                    >
                </td>

                <td class="px-2 py-4 align-top w-[140px] text-right font-medium">
                    Rp. ${formatRupiah(subtotal)}
                </td>

                <td class="px-2 py-4 align-top w-[60px]">
                    <button
                        type="button"
                        data-index="${index}"
                        class="remove-item text-red-500 hover:text-red-700"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        });

        updateGrandTotal();
    }

    function addToCart(product) {
        const existingIndex = cart.findIndex(item => item.id === product.id);

        if (existingIndex !== -1) {
            cart[existingIndex].qty += 1;
        } else {
            cart.push({
                id: product.id,
                nama_produk: product.nama_produk,
                sku: product.sku,
                barcode: product.barcode,
                satuan_utama: product.satuan_utama || 'Pcs',
                stok: Number(product.stok || 0),
                price: Number(product.harga_jual || 0),
                qty: 1,
            });
        }

        renderCart();
    }

    function renderSearchResults(items) {
        if (!resultsBox) return;

        if (!items || items.length === 0) {
            resultsBox.innerHTML = `
                <div class="px-4 py-3 text-sm text-gray-500">
                    Produk tidak ditemukan
                </div>
            `;
            resultsBox.classList.remove('hidden');
            return;
        }

        resultsBox.innerHTML = items.map(item => `
            <button
                type="button"
                class="search-result-item w-full text-left px-4 py-3 hover:bg-blue-50 border-b border-gray-100 last:border-b-0"
                data-id="${item.id}"
                data-nama="${item.nama_produk}"
                data-sku="${item.sku ?? ''}"
                data-barcode="${item.barcode ?? ''}"
                data-harga="${item.harga_jual ?? 0}"
                data-satuan="${item.satuan_utama ?? 'Pcs'}"
                data-stok="${item.stok ?? 0}"
            >
                <div class="font-medium text-gray-800">${item.nama_produk}</div>
                <div class="text-xs text-gray-500 mt-1">
                    [${item.barcode ?? '-'}] • ${item.satuan_utama ?? '-'} • Rp.${formatRupiah(item.harga_jual ?? 0)}
                </div>
            </button>
        `).join('');

        resultsBox.classList.remove('hidden');
    }

    async function searchProduk(keyword) {
        try {
            const response = await fetch(`{{ route('penjualan.kasir.search') }}?q=${encodeURIComponent(keyword)}`);
            const data = await response.json();
            renderSearchResults(data);
        } catch (error) {
            console.error(error);
        }
    }

    function updateKembalian() {
        const total = getGrandTotal();
        const uangTunai = Number(uangTunaiInput?.value || 0);
        const selisih = uangTunai - total;

        if (kembalianText) {
            const prefix = selisih < 0 ? '-Rp. ' : 'Rp. ';
            kembalianText.textContent = prefix + formatRupiah(Math.abs(selisih)) + ',00';
        }

        const labelKurang = document.querySelector('#kembalianText')?.previousElementSibling;
        if (labelKurang) {
            labelKurang.textContent = selisih < 0 ? 'Pembayaran Kurang' : 'Kembalian';
            labelKurang.className = selisih < 0
                ? 'text-red-500 font-bold text-2xl'
                : 'text-green-500 font-bold text-2xl';
        }
    }

    function openPembayaranModal() {
        const total = getGrandTotal();

        if (cart.length === 0) {
            alert('Pilih produk terlebih dahulu.');
            return;
        }

        if (modalGrandTotalText) {
            modalGrandTotalText.textContent = 'Rp. ' + formatRupiah(total) + ',00';
        }

        if (uangTunaiInput) {
            uangTunaiInput.value = 0;
        }

        updateKembalian();

        pembayaranModal?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closePembayaranModal() {
        pembayaranModal?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    async function simpanTransaksi(statusValue) {
        if (cart.length === 0) {
            alert('Belum ada produk di transaksi.');
            return false;
        }

        const payload = {
            items: cart.map(item => ({
                produk_id: item.id,
                qty: item.qty,
                satuan: item.satuan_utama,
                harga_jual: item.price,
                subtotal: item.qty * item.price,
            })),
            total_penjualan: getGrandTotal(),
            status: statusValue,
            draft_id: currentDraftId,
        };

        const response = await fetch(`{{ route('penjualan.kasir.store') }}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        });

        const result = await response.json();

        if (!response.ok || !result.success) {
            throw new Error(result.message || 'Gagal menyimpan transaksi');
        }

        return result;
    }

    // Event modal pembayaran
    openPembayaranModalBtn?.addEventListener('click', openPembayaranModal);
    closePembayaranModalBtn?.addEventListener('click', closePembayaranModal);
    cancelPembayaranModalBtn?.addEventListener('click', closePembayaranModal);
    pembayaranOverlay?.addEventListener('click', closePembayaranModal);

    uangTunaiInput?.addEventListener('input', updateKembalian);

    quickCashButtons.forEach((btn) => {
        btn.addEventListener('click', function () {
            const total = getGrandTotal();
            const amount = this.dataset.amount;

            if (amount === 'pas') {
                uangTunaiInput.value = total;
            } else {
                uangTunaiInput.value = Number(amount);
            }

            updateKembalian();
        });
    });

    // Search produk
    searchInput?.addEventListener('input', function () {
        const keyword = this.value.trim();

        clearTimeout(debounceTimer);

        if (keyword.length < 1) {
            resultsBox?.classList.add('hidden');
            if (resultsBox) resultsBox.innerHTML = '';
            return;
        }

        debounceTimer = setTimeout(() => {
            searchProduk(keyword);
        }, 250);
    });

    resultsBox?.addEventListener('click', function (e) {
        const btn = e.target.closest('.search-result-item');
        if (!btn) return;

        const product = {
            id: Number(btn.dataset.id),
            nama_produk: btn.dataset.nama,
            sku: btn.dataset.sku,
            barcode: btn.dataset.barcode,
            harga_jual: Number(btn.dataset.harga),
            satuan_utama: btn.dataset.satuan,
            stok: Number(btn.dataset.stok),
        };

        addToCart(product);

        searchInput.value = '';
        resultsBox.classList.add('hidden');
        resultsBox.innerHTML = '';
        searchInput.focus();
    });

    document.addEventListener('click', function (e) {
        if (resultsBox && !resultsBox.contains(e.target) && e.target !== searchInput) {
            resultsBox.classList.add('hidden');
        }
    });

    // Qty + remove
    tbody?.addEventListener('input', function (e) {
        if (e.target.classList.contains('qty-input')) {
            const index = Number(e.target.dataset.index);
            let value = Number(e.target.value);

            if (value < 1 || isNaN(value)) value = 1;

            cart[index].qty = value;
            renderCart();
        }
    });

    tbody?.addEventListener('click', function (e) {
        const btn = e.target.closest('.remove-item');
        if (!btn) return;

        const index = Number(btn.dataset.index);
        cart.splice(index, 1);
        renderCart();
    });

    clearCartBtn?.addEventListener('click', function () {
        cart.length = 0;
        currentDraftId = null;
        renderCart();
        if (searchInput) searchInput.value = '';
        resultsBox?.classList.add('hidden');
        if (resultsBox) resultsBox.innerHTML = '';
    });

    // Tombol bayar
    buatTransaksiBtn?.addEventListener('click', async function () {
        try {
            await simpanTransaksi('selesai');

            closePembayaranModal();
            alert('Transaksi berhasil dibuat');

            cart.length = 0;
            currentDraftId = null;
            renderCart();

            if (searchInput) searchInput.value = '';
            resultsBox?.classList.add('hidden');
            if (resultsBox) resultsBox.innerHTML = '';
            searchInput?.focus();
        } catch (error) {
            alert(error.message || 'Terjadi kesalahan');
        }
    });

    // Tombol tunda
    btnTundaTransaksi?.addEventListener('click', async function () {
        try {
            await simpanTransaksi('draft');

            alert('Transaksi berhasil ditunda');

            cart.length = 0;
            currentDraftId = null;
            renderCart();

            if (searchInput) searchInput.value = '';
            resultsBox?.classList.add('hidden');
            if (resultsBox) resultsBox.innerHTML = '';
            searchInput?.focus();
        } catch (error) {
            alert(error.message || 'Terjadi kesalahan');
        }
    });

    // Load draft kalau ada
    if (draftPenjualan && Array.isArray(draftPenjualan.items) && draftPenjualan.items.length > 0) {
        draftPenjualan.items.forEach(item => {
            cart.push({
                id: Number(item.id),
                nama_produk: item.nama_produk,
                sku: item.sku,
                barcode: item.barcode,
                satuan_utama: item.satuan_utama || 'Pcs',
                stok: Number(item.stok || 0),
                price: Number(item.price || 0),
                qty: Number(item.qty || 1),
            });
        });

        renderCart();
    }
});
</script>
@endpush
