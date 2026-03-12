@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Stok Produk')
@section('page_title', 'Stok Produk')
@section('page_subtitle', 'Kelola data stok produk persediaan.')

@section('content')
    <div class="h-[calc(100vh-9rem)]">
        <div class="relative z-0 bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 h-full flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-3">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Stok Produk</h2>

                <button
                    type="button"
                    id="openSesuaikanStokModal"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                >
                    <i class="fas fa-circle-plus"></i>
                    Sesuaikan Stok
                </button>
            </div>

            <!-- Toolbar -->
            <div class="flex items-center justify-between gap-3 flex-wrap mb-2">
                <div class="flex items-center gap-2 flex-wrap">

                    <!-- Search -->
                    <form method="GET" action="{{ route('persediaan.stokproduk') }}" class="w-full max-w-xs">
                        @if(request('tanggal_awal'))
                            <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                        @endif

                        @if(request('tanggal_akhir'))
                            <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                        @endif

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

                    <div class="flex flex-col">
                        <span class="text-[11px] text-gray-400 ml-2 mb-1">Filter Tgl</span>

                        <div class="flex items-center gap-2">

                            <input
                                type="date"
                                id="tanggal_awal"
                                value="{{ request('tanggal_awal') }}"
                                class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 text-sm"
                            >

                            <span class="text-gray-400 text-sm">s/d</span>

                            <input
                                type="date"
                                id="tanggal_akhir"
                                value="{{ request('tanggal_akhir') }}"
                                class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 text-sm"
                            >
                        </div>
                    </div>

                    <!-- Filter indicator -->
                    <button
                        type="button"
                        id="openFilterModalBtn"
                        class="mt-5 inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-filter text-sm"></i>
                        <span>Filter</span>
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-white text-xs font-semibold">
                            {{ (request('status') || request('rak')) ? 1 : 0 }}
                        </span>
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
                    <table class="min-w-[1100px] w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 sticky top-0 z-10">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap w-16">
                                    <span class="inline-flex items-center gap-2">
                                        No.
                                        <i class="fas fa-sort text-xs text-gray-400"></i>
                                    </span>
                                </th>

                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[140px]">
                                    <span class="inline-flex items-center gap-2">
                                        Tanggal
                                        <i class="fas fa-sort text-xs text-gray-400"></i>
                                    </span>
                                </th>

                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[320px]">
                                    <span class="inline-flex items-center gap-2">
                                        Nama Produk
                                        <i class="fas fa-sort text-xs text-gray-400"></i>
                                    </span>
                                </th>

                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">
                                    <span class="inline-flex items-center gap-2">
                                        Stok
                                        <i class="fas fa-sort text-xs text-gray-400"></i>
                                    </span>
                                </th>

                                <th class="text-center px-4 py-3 font-semibold whitespace-nowrap min-w-[120px]">
                                    Actions
                                </th>

                                <th class="text-left px-4 py-3 font-semibold whitespace-nowrap min-w-[220px]">
                                    Catatan
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white dark:bg-gray-950">
                            @forelse (($stokProduks ?? []) as $index => $item)
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-4 align-top">{{ $index + 1 }}</td>

                                    <td class="px-4 py-4 align-top text-gray-700 dark:text-gray-200">
                                        {{ $item->tanggal ?? '-' }}
                                    </td>

                                    <td class="px-4 py-4 align-top">
                                        <div class="font-medium text-gray-800 dark:text-gray-100">
                                            {{ $item->produk->nama_produk ?? '-' }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            SKU: {{ $item->produk->sku ?? '-' }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-center align-top font-semibold text-gray-800 dark:text-gray-100">
                                        {{ $item->stok_fisik ?? 0 }}
                                    </td>

                                    <td class="px-4 py-4 text-center align-top">
                                        <form method="POST" action="{{ route('persediaan.stokproduk.destroy', $item->id) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                onclick="return confirm('Yakin ingin menghapus data ini?')"
                                                class="w-8 h-8 rounded-lg text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>

                                    <td class="px-4 py-4 align-top text-gray-700 dark:text-gray-200">
                                        {{ $item->catatan ?? '-' }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <td colspan="6" class="text-center py-24 text-gray-500 dark:text-gray-400">
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

    <!-- Modal Sesuaikan Stok -->
    <div id="sesuaikanStokModal" class="fixed inset-0 z-[9999] hidden">
        <div id="sesuaikanStokOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

        <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-8">
            <form
                method="POST"
                action="{{ route('persediaan.stokproduk.store') }}"
                class="relative z-[10000] w-full max-w-[720px] bg-white dark:bg-gray-950 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-800"
            >
                @csrf

                <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white leading-none">Sesuaikan Stok</h3>
                    <button
                        type="button"
                        id="closeSesuaikanStokModal"
                        class="text-white/90 hover:text-white text-xl"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Produk</label>
                        <select
                            name="produk_id"
                            class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                            <option value="">Pilih Produk</option>
                            @foreach(($produks ?? []) as $produk)
                                <option value="{{ $produk->id }}">
                                    {{ $produk->nama_produk }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Tanggal</label>
                            <input
                                type="date"
                                name="tanggal"
                                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Stok Fisik</label>
                            <input
                                type="number"
                                name="stok_fisik"
                                min="0"
                                class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Catatan</label>
                        <textarea
                            name="catatan"
                            rows="4"
                            class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            placeholder="Tulis catatan penyesuaian stok"
                        ></textarea>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-end gap-3 bg-white dark:bg-gray-950">
                    <button
                        type="button"
                        id="cancelSesuaikanStokModal"
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

    <!-- Modal Filter -->
    <div id="filterModal" class="fixed inset-0 z-[9999] hidden">
        <div id="filterModalOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

        <div class="absolute inset-0 flex items-center justify-center p-6 sm:p-8">
            <form
                method="GET"
                action="{{ route('persediaan.stokproduk') }}"
                class="relative z-[10000] w-full max-w-[520px] bg-white dark:bg-gray-950 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 dark:border-gray-800"
            >
                @if(request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                @if(request('tanggal_awal'))
                    <input type="hidden" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                @endif

                @if(request('tanggal_akhir'))
                    <input type="hidden" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                @endif

                <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                    <h3 class="text-2xl font-bold text-white leading-none">Filter Data</h3>
                    <button
                        type="button"
                        id="closeFilterModalBtn"
                        class="text-white/90 hover:text-white text-xl"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="grid grid-cols-[140px_20px_1fr] items-center gap-4">
                        <label class="text-sm text-gray-700 dark:text-gray-200">Status</label>
                        <span class="text-gray-400">:</span>
                        <select
                            name="status"
                            class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                            <option value="">Semua Produk</option>
                            <option value="dijual" {{ request('status') == 'dijual' ? 'selected' : '' }}>Dijual</option>
                            <option value="tidak_dijual" {{ request('status') == 'tidak_dijual' ? 'selected' : '' }}>Tidak Dijual</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-[140px_20px_1fr] items-center gap-4">
                        <label class="text-sm text-gray-700 dark:text-gray-200">Rak Penyimpanan</label>
                        <span class="text-gray-400">:</span>
                        <select
                            name="rak"
                            class="w-full rounded-xl border border-gray-300 bg-white text-gray-900 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                            <option value="">Semua Rak</option>
                            @foreach(($raks ?? []) as $rak)
                                <option value="{{ $rak->nama_rak }}" {{ request('rak') == $rak->nama_rak ? 'selected' : '' }}>
                                    {{ $rak->nama_rak }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between bg-white dark:bg-gray-950">
                    <a
                        href="{{ route('persediaan.stokproduk', array_filter([
                            'search' => request('search'),
                            'tanggal_awal' => request('tanggal_awal'),
                            'tanggal_akhir' => request('tanggal_akhir'),
                        ])) }}"
                        class="text-sky-500 hover:text-sky-600 text-sm font-semibold"
                    >
                        Reset Filter
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold"
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
        const openSesuaikanStokModalBtn = document.getElementById('openSesuaikanStokModal');
        const sesuaikanStokModal = document.getElementById('sesuaikanStokModal');
        const sesuaikanStokOverlay = document.getElementById('sesuaikanStokOverlay');
        const closeSesuaikanStokModalBtn = document.getElementById('closeSesuaikanStokModal');
        const cancelSesuaikanStokModalBtn = document.getElementById('cancelSesuaikanStokModal');

        function openSesuaikanStokModal() {
            if (!sesuaikanStokModal) return;
            sesuaikanStokModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeSesuaikanStokModal() {
            if (!sesuaikanStokModal) return;
            sesuaikanStokModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        openSesuaikanStokModalBtn?.addEventListener('click', openSesuaikanStokModal);
        closeSesuaikanStokModalBtn?.addEventListener('click', closeSesuaikanStokModal);
        cancelSesuaikanStokModalBtn?.addEventListener('click', closeSesuaikanStokModal);
        sesuaikanStokOverlay?.addEventListener('click', closeSesuaikanStokModal);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sesuaikanStokModal && !sesuaikanStokModal.classList.contains('hidden')) {
                closeSesuaikanStokModal();
            }
        });

        const start = document.getElementById("tanggal_awal");
        const end = document.getElementById("tanggal_akhir");

        function applyFilter() {

            const url = new URL(window.location.href);

            if (start.value) {
                url.searchParams.set("tanggal_awal", start.value);
            } else {
                url.searchParams.delete("tanggal_awal");
            }

            if (end.value) {
                url.searchParams.set("tanggal_akhir", end.value);
            } else {
                url.searchParams.delete("tanggal_akhir");
            }

            window.location.href = url.toString();
        }

        start?.addEventListener("change", applyFilter);
        end?.addEventListener("change", applyFilter);

        const openFilterModalBtn = document.getElementById('openFilterModalBtn');
        const filterModal = document.getElementById('filterModal');
        const filterModalOverlay = document.getElementById('filterModalOverlay');
        const closeFilterModalBtn = document.getElementById('closeFilterModalBtn');

        function openFilterModal() {
            if (!filterModal) return;
            filterModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeFilterModal() {
            if (!filterModal) return;
            filterModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        openFilterModalBtn?.addEventListener('click', openFilterModal);
        closeFilterModalBtn?.addEventListener('click', closeFilterModal);
        filterModalOverlay?.addEventListener('click', closeFilterModal);

        const tanggalAwalInput = document.getElementById('tanggal_awal');
        const tanggalAkhirInput = document.getElementById('tanggal_akhir');

        function applyTanggalFilter() {
            const url = new URL(window.location.href);

            if (tanggalAwalInput?.value) {
                url.searchParams.set('tanggal_awal', tanggalAwalInput.value);
            } else {
                url.searchParams.delete('tanggal_awal');
            }

            if (tanggalAkhirInput?.value) {
                url.searchParams.set('tanggal_akhir', tanggalAkhirInput.value);
            } else {
                url.searchParams.delete('tanggal_akhir');
            }

            window.location.href = url.toString();
        }

        tanggalAwalInput?.addEventListener('change', applyTanggalFilter);
        tanggalAkhirInput?.addEventListener('change', applyTanggalFilter);
    });
</script>
@endpush