@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Master Gudang')
@section('page_title', 'Daftar Gudang')
@section('page_subtitle', 'Kelola data gudang.')

@section('content')
    <div class="space-y-4 min-h-[calc(100vh-120px)] flex flex-col">
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 transition-colors duration-200 flex flex-col flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-4">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Daftar Gudang</h2>

                <button
                    type="button"
                    id="openTambahGudangModal"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                >
                    <i class="fas fa-plus"></i>
                    Tambah Gudang
                </button>
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

            @if($errors->has('nama_gudang'))
                <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                    {{ $errors->first('nama_gudang') }}
                </div>
            @endif

            <!-- Filter Box -->
            <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 flex flex-col flex-1">
                <div class="bg-blue-600 px-4 py-4">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-end">
                        <div class="lg:col-span-12">
                            <label class="block text-sm font-semibold text-white mb-2">Cari Nama Gudang</label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="searchGudangInput"
                                    placeholder="Ketik di sini"
                                    class="w-full rounded-lg border border-blue-500 bg-white text-gray-700 placeholder:text-gray-400 px-4 py-3 pr-10 focus:outline-none"
                                >
                                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto overflow-y-auto flex-1">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300 sticky top-0 z-10">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold w-16">No.</th>
                                <th class="text-left px-4 py-3 font-semibold">Nama Gudang</th>
                                <th class="text-center px-4 py-3 font-semibold w-32">Status</th>
                                <th class="text-center px-4 py-3 font-semibold w-40">Action</th>
                            </tr>
                        </thead>

                        <tbody id="gudangTableBody" class="bg-white dark:bg-gray-950">
                            @forelse ($gudangs as $index => $gudang)
                                <tr class="gudang-row border-t border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3 gudang-no">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $gudang->nama_gudang }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if($gudang->status === 'aktif')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                                Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                                Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button
                                                type="button"
                                                class="openEditGudangModal px-4 py-1.5 rounded-lg border border-blue-300 text-blue-600 text-sm font-medium hover:bg-blue-50"
                                                data-id="{{ $gudang->id }}"
                                                data-nama="{{ $gudang->nama_gudang }}"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="openDeleteGudangModal w-8 h-8 rounded-lg text-red-600 hover:bg-red-50"
                                                data-id="{{ $gudang->id }}"
                                                data-nama="{{ $gudang->nama_gudang }}"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr id="emptyGudangRow" class="border-t border-gray-100 dark:border-gray-800">
                                    <td colspan="4" class="text-center py-20 h-[350px] align-middle text-gray-500 dark:text-gray-400">
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

<!-- Modal Tambah Gudang -->
<div id="tambahGudangModal" class="fixed inset-0 z-[9999] hidden">
    <div id="tambahGudangOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-6">
        <form
            action="{{ route('masterdata.mastergudang.store') }}"
            method="POST"
            class="relative z-[10000] w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf

            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Tambah Gudang</h3>
                <button
                    type="button"
                    id="closeTambahGudangModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-5 space-y-5 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Gudang *
                    </label>
                    <input
                        type="text"
                        id="namaGudangInput"
                        name="nama_gudang"
                        value="{{ old('nama_gudang') }}"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                </div>

                <div class="rounded-[22px] bg-yellow-400 dark:bg-yellow-500 px-6 py-5 transition-colors duration-200">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-exclamation text-yellow-400 text-lg"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-900 font-medium">
                            Sebelum membuat gudang baru, pastikan sebelumnya benar-benar belum terdaftar agar tidak menyebabkan kebingungan ketika memilih.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelTambahGudangModal"
                    class="px-5 py-2.5 rounded-lg text-gray-400 dark:text-gray-500 font-semibold hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold transition-colors duration-200"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Gudang -->
<div id="editGudangModal" class="fixed inset-0 z-[10010] hidden">
    <div id="editGudangOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-6">
        <form
            id="editGudangForm"
            method="POST"
            class="relative z-[10011] w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf
            @method('PUT')

            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Edit Gudang</h3>
                <button
                    type="button"
                    id="closeEditGudangModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-5 space-y-5 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Gudang *
                    </label>
                    <input
                        type="text"
                        id="editNamaGudangInput"
                        name="nama_gudang"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                </div>

                <div class="rounded-[22px] bg-yellow-400 dark:bg-yellow-500 px-6 py-5 transition-colors duration-200">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-exclamation text-yellow-400 text-lg"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-900 font-medium">
                            Sebelum mengubah gudang, pastikan nama yang dimasukkan memang benar agar tidak menyebabkan kebingungan ketika memilih.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelEditGudangModal"
                    class="px-5 py-2.5 rounded-lg text-gray-400 dark:text-gray-500 font-semibold hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="px-6 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold transition-colors duration-200"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Gudang -->
<div id="deleteGudangModal" class="fixed inset-0 z-[10020] hidden">
    <div id="deleteGudangOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4">
        <div class="w-full max-w-[520px] rounded-3xl bg-white dark:bg-gray-950 shadow-2xl border border-gray-200 dark:border-gray-800 overflow-hidden">
            <div class="px-8 py-10 text-center">
                <div class="mx-auto mb-6 w-20 h-20 rounded-full border-4 border-orange-300 flex items-center justify-center">
                    <i class="fas fa-exclamation text-4xl text-orange-300"></i>
                </div>

                <h3 class="text-4xl font-extrabold text-gray-700 dark:text-gray-100 mb-4">
                    Ehh, seriusan?
                </h3>

                <p class="text-2xl leading-9 text-gray-600 dark:text-gray-300 mb-8">
                    Yakin nih ingin hapus <span id="deleteGudangNama" class="font-semibold"></span>?
                </p>

                <form id="deleteGudangForm" method="POST" class="flex items-center justify-center gap-3">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl bg-blue-500 hover:bg-blue-600 text-white font-bold text-xl"
                    >
                        Yoi, hapus sekarang!
                    </button>

                    <button
                        type="button"
                        id="cancelDeleteGudangBtn"
                        class="px-6 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-bold text-xl"
                    >
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // =========================
    // MODAL: TAMBAH GUDANG
    // =========================
    const openTambahGudangModalBtn = document.getElementById('openTambahGudangModal');
    const tambahGudangModal = document.getElementById('tambahGudangModal');
    const tambahGudangOverlay = document.getElementById('tambahGudangOverlay');
    const closeTambahGudangModalBtn = document.getElementById('closeTambahGudangModal');
    const cancelTambahGudangModalBtn = document.getElementById('cancelTambahGudangModal');

    function openTambahGudangModal() {
        if (!tambahGudangModal) return;
        tambahGudangModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTambahGudangModal() {
        if (!tambahGudangModal) return;
        tambahGudangModal.classList.add('hidden');

        if (
            (!editGudangModal || editGudangModal.classList.contains('hidden')) &&
            (!deleteGudangModal || deleteGudangModal.classList.contains('hidden'))
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    openTambahGudangModalBtn?.addEventListener('click', openTambahGudangModal);
    closeTambahGudangModalBtn?.addEventListener('click', closeTambahGudangModal);
    cancelTambahGudangModalBtn?.addEventListener('click', closeTambahGudangModal);
    tambahGudangOverlay?.addEventListener('click', closeTambahGudangModal);

    // =========================
    // MODAL: EDIT GUDANG
    // =========================
    const editGudangModal = document.getElementById('editGudangModal');
    const editGudangOverlay = document.getElementById('editGudangOverlay');
    const closeEditGudangModalBtn = document.getElementById('closeEditGudangModal');
    const cancelEditGudangModalBtn = document.getElementById('cancelEditGudangModal');
    const editGudangForm = document.getElementById('editGudangForm');
    const editNamaGudangInput = document.getElementById('editNamaGudangInput');

    function openEditGudangModal() {
        if (!editGudangModal) return;
        editGudangModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditGudangModal() {
        if (!editGudangModal) return;
        editGudangModal.classList.add('hidden');

        if (
            (!tambahGudangModal || tambahGudangModal.classList.contains('hidden')) &&
            (!deleteGudangModal || deleteGudangModal.classList.contains('hidden'))
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.querySelectorAll('.openEditGudangModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama || '';

            if (editGudangForm) {
                editGudangForm.action = `/master-data/master-gudang/${id}`;
            }

            if (editNamaGudangInput) {
                editNamaGudangInput.value = nama;
            }

            openEditGudangModal();
        });
    });

    closeEditGudangModalBtn?.addEventListener('click', closeEditGudangModal);
    cancelEditGudangModalBtn?.addEventListener('click', closeEditGudangModal);
    editGudangOverlay?.addEventListener('click', closeEditGudangModal);

    // =========================
    // MODAL: HAPUS GUDANG
    // =========================
    const deleteGudangModal = document.getElementById('deleteGudangModal');
    const deleteGudangOverlay = document.getElementById('deleteGudangOverlay');
    const deleteGudangForm = document.getElementById('deleteGudangForm');
    const deleteGudangNama = document.getElementById('deleteGudangNama');
    const cancelDeleteGudangBtn = document.getElementById('cancelDeleteGudangBtn');

    function openDeleteGudangModal() {
        if (!deleteGudangModal) return;
        deleteGudangModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteGudangModal() {
        if (!deleteGudangModal) return;
        deleteGudangModal.classList.add('hidden');

        if (
            (!tambahGudangModal || tambahGudangModal.classList.contains('hidden')) &&
            (!editGudangModal || editGudangModal.classList.contains('hidden'))
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.querySelectorAll('.openDeleteGudangModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama || '-';

            if (deleteGudangForm) {
                deleteGudangForm.action = `/master-data/master-gudang/${id}`;
            }

            if (deleteGudangNama) {
                deleteGudangNama.textContent = nama;
            }

            openDeleteGudangModal();
        });
    });

    cancelDeleteGudangBtn?.addEventListener('click', closeDeleteGudangModal);
    deleteGudangOverlay?.addEventListener('click', closeDeleteGudangModal);

    // =========================
    // SEARCH GUDANG
    // =========================
    const searchGudangInput = document.getElementById('searchGudangInput');
    const gudangTableBody = document.getElementById('gudangTableBody');

    function createSearchEmptyGudangRow() {
        const row = document.createElement('tr');
        row.id = 'searchEmptyGudangRow';
        row.className = 'border-t border-gray-100 dark:border-gray-800';
        row.innerHTML = `
            <td colspan="4" class="text-center py-20 h-[350px] align-middle text-gray-500 dark:text-gray-400">
                Data tidak ditemukan
            </td>
        `;
        return row;
    }

    function updateGudangRowNumbers() {
        const visibleRows = Array.from(document.querySelectorAll('#gudangTableBody .gudang-row'))
            .filter(row => !row.classList.contains('hidden'));

        visibleRows.forEach((row, index) => {
            const noCell = row.querySelector('.gudang-no');
            if (noCell) {
                noCell.textContent = index + 1;
            }
        });
    }

    function applyGudangSearch() {
        const keyword = searchGudangInput?.value?.toLowerCase().trim() || '';
        const rows = document.querySelectorAll('#gudangTableBody .gudang-row');
        let visibleCount = 0;

        document.getElementById('searchEmptyGudangRow')?.remove();

        rows.forEach((row) => {
            const namaGudang = row.children[1]?.textContent.toLowerCase() || '';
            const isMatch = !keyword || namaGudang.includes(keyword);

            row.classList.toggle('hidden', !isMatch);

            if (isMatch) {
                visibleCount++;
            }
        });

        updateGudangRowNumbers();

        if (visibleCount === 0 && rows.length > 0) {
            gudangTableBody?.appendChild(createSearchEmptyGudangRow());
        }
    }

    searchGudangInput?.addEventListener('input', applyGudangSearch);

    // =========================
    // ESC KEY
    // =========================
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;

        if (tambahGudangModal && !tambahGudangModal.classList.contains('hidden')) {
            closeTambahGudangModal();
        }

        if (editGudangModal && !editGudangModal.classList.contains('hidden')) {
            closeEditGudangModal();
        }

        if (deleteGudangModal && !deleteGudangModal.classList.contains('hidden')) {
            closeDeleteGudangModal();
        }
    });

    // =========================
    // AUTO OPEN JIKA VALIDASI GAGAL
    // =========================
    @if($errors->has('nama_gudang'))
        openTambahGudangModal();
    @endif
});
</script>
@endpush