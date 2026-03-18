@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Gudang Penyimpanan')
@section('page_title', 'Gudang Penyimpanan')
@section('page_subtitle', 'Kelola produk di masing-masing gudang.')

@section('content')
<div class="h-[calc(100vh-9rem)]">
    <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border dark:border-gray-800 border-gray-100 p-4 h-full flex flex-col">

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-3xl font-bold text-blue-700">Gudang Penyimpanan</h2>

            @if($selectedGudang)
                <button
                    type="button"
                    id="openTambahProdukGudangModal"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm"
                >
                    <i class="fas fa-plus"></i>
                    Tambah Produk ke Gudang
                </button>
            @endif
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

        <div class="grid grid-cols-12 gap-4 flex-1 min-h-0">

            <!-- Sidebar Gudang -->
            <div class="col-span-12 lg:col-span-3 border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden flex flex-col">
                <div class="px-4 py-3 dark:bg-gray-900 bg-gray-50 border-b border-gray-100 dark:border-gray-800 font-semibold text-gray-700 dark:text-gray-300">
                    Daftar Gudang
                </div>

                <div class="flex-1 overflow-y-auto divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($gudangs as $gudang)
                        <a
                            href="{{ route('persediaan.gudangpenyimpanan', ['gudang_id' => $gudang->id]) }}"
                            class="block px-4 py-3 hover:bg-blue-50 transition {{ (string)$selectedGudangId === (string)$gudang->id ? 'bg-blue-100 text-blue-700 font-semibold' : 'text-gray-700 dark:text-gray-300' }}"
                        >
                            {{ $gudang->nama_gudang }}
                        </a>
                    @empty
                        <div class="px-4 py-6 text-sm text-gray-500">
                            Belum ada gudang.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Isi Gudang -->
            <div class="col-span-12 lg:col-span-9 border border-gray-100 dark:border-gray-800 rounded-xl overflow-hidden flex flex-col">
                <div class="px-4 py-3 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
                    <div class="font-semibold text-gray-700 dark:text-gray-300">
                        {{ $selectedGudang ? 'Isi ' . $selectedGudang->nama_gudang : 'Pilih gudang terlebih dahulu' }}
                    </div>
                </div>

                <div class="flex-1 overflow-auto">
                    @if($selectedGudang)
                        <table class="w-full text-sm">
                            <thead class="bg-white dark:bg-gray-800 dark:text-gray-300 text-gray-700 sticky top-0">
                                <tr class="border-b dark:border-gray-800 border-gray-100">
                                    <th class="text-left px-4 py-3 font-semibold w-16">No.</th>
                                    <th class="text-left px-4 py-3 font-semibold">Nama Produk</th>
                                    <th class="text-left px-4 py-3 font-semibold">SKU</th>
                                    <th class="text-center px-4 py-3 font-semibold">Stok</th>
                                    <th class="text-center px-4 py-3 font-semibold">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($produkGudang as $index => $item)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-4 py-4">{{ $index + 1 }}</td>
                                        <td class="px-4 py-4 font-medium text-gray-800">
                                            {{ $item->produk->nama_produk ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-gray-600">
                                            {{ $item->produk->sku ?? '-' }}
                                        </td>
                                        <td class="px-4 py-4 text-center font-semibold">
                                            {{ $item->stok ?? 0 }}
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            <form
                                                method="POST"
                                                action="{{ route('persediaan.gudangpenyimpanan.destroy', $item->id) }}"
                                                onsubmit="return confirm('Hapus produk dari gudang ini?')"
                                                class="inline-block"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-16 text-gray-500">
                                            Belum ada produk di gudang ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @else
                        <div class="h-full flex items-center justify-center text-gray-500">
                            Silakan pilih gudang dari daftar sebelah kiri.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($selectedGudang)
    <!-- Modal Tambah Produk -->
    <div id="tambahProdukGudangModal" class="fixed inset-0 z-[9999] hidden">
        <div id="tambahProdukGudangOverlay" class="absolute inset-0 bg-black/50"></div>

        <div class="absolute inset-0 flex items-center justify-center p-4">
            <form
                method="POST"
                action="{{ route('persediaan.gudangpenyimpanan.store') }}"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-[520px] overflow-hidden"
            >
                @csrf

                <input type="hidden" name="gudang_id" value="{{ $selectedGudang->id }}">

                <div class="bg-blue-600 px-6 py-4 text-white flex items-center justify-between">
                    <h3 class="text-xl font-bold">Tambah Produk ke Gudang</h3>
                    <button type="button" id="closeTambahProdukGudangModal" class="text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Gudang</label>
                        <input
                            type="text"
                            value="{{ $selectedGudang->nama_gudang }}"
                            readonly
                            class="w-full rounded-xl border border-gray-300 bg-gray-100 px-4 py-3 text-sm"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                        <select
                            name="produk_id"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                            required
                        >
                            <option value="">Pilih Produk</option>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->id }}">
                                    {{ $produk->nama_produk }} - {{ $produk->sku }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal</label>
                        <input
                            type="number"
                            name="stok"
                            min="0"
                            value="0"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-end gap-3">
                    <button
                        type="button"
                        id="cancelTambahProdukGudangModal"
                        class="px-5 py-2.5 rounded-lg text-gray-400 font-semibold hover:text-gray-600"
                    >
                        Batal
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
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.getElementById('openTambahProdukGudangModal');
    const modal = document.getElementById('tambahProdukGudangModal');
    const overlay = document.getElementById('tambahProdukGudangOverlay');
    const closeBtn = document.getElementById('closeTambahProdukGudangModal');
    const cancelBtn = document.getElementById('cancelTambahProdukGudangModal');

    function openModal() {
        if (!modal) return;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    openBtn?.addEventListener('click', openModal);
    closeBtn?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);
    overlay?.addEventListener('click', closeModal);
});
</script>
@endpush
