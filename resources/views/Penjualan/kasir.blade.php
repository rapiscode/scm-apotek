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
                        class="w-full h-28 rounded-2xl bg-teal-500 hover:bg-teal-600 text-white font-bold text-xl shadow-md transition"
                    >
                        Bayar
                    </button>

                    <button
                        class="w-full h-28 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xl shadow-md transition"
                    >
                        Tunda
                    </button>

                </div>

            </div>

        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('produkSearchInput');
    const resultsBox = document.getElementById('produkSearchResults');
    const tbody = document.getElementById('kasirTableBody');
    const emptyState = document.getElementById('emptyStateKasir');
    const rowsWrapper = document.getElementById('kasirRowsWrapper');
    const grandTotalText = document.getElementById('grandTotalText');
    const clearCartBtn = document.getElementById('clearCartBtn');

    let debounceTimer = null;
    const cart = [];

    function formatRupiah(number) {
        const value = Number(number || 0);
        return value.toLocaleString('id-ID');
    }

    function updateGrandTotal() {
        const total = cart.reduce((sum, item) => sum + (item.qty * item.price), 0);

        if (grandTotalText) {
            grandTotalText.textContent = formatRupiah(total) + ',00';
        }
    }

    function renderCart() {
        tbody.innerHTML = '';

        if (cart.length === 0) {
            rowsWrapper.classList.add('hidden');
            emptyState.classList.remove('hidden');
            updateGrandTotal();
            return;
        }

        rowsWrapper.classList.remove('hidden');
        emptyState.classList.add('hidden');

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

    searchInput?.addEventListener('input', function () {
        const keyword = this.value.trim();

        clearTimeout(debounceTimer);

        if (keyword.length < 1) {
            resultsBox.classList.add('hidden');
            resultsBox.innerHTML = '';
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
        if (!resultsBox.contains(e.target) && e.target !== searchInput) {
            resultsBox.classList.add('hidden');
        }
    });

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
        renderCart();
        searchInput.value = '';
        resultsBox.classList.add('hidden');
        resultsBox.innerHTML = '';
    });
});
</script>
@endpush
