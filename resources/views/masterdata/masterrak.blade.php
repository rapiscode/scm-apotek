@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Master Rak')
@section('page_title', 'Daftar Rak Penyimpanan')
@section('page_subtitle', 'Kelola data rak penyimpanan.')

@section('content')
    <div class="space-y-4 min-h-[calc(100vh-120px)] flex flex-col">
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 transition-colors duration-200 flex flex-col flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-4">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Daftar Rak Penyimpanan</h2>

                <button
                    type="button"
                    id="openTambahRakModal"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                >
                    <i class="fas fa-plus"></i>
                    Tambah Rak
                </button>
            </div>

            <!-- Filter Box -->
            <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 flex flex-col flex-1">
                <div class="bg-blue-600 px-4 py-4">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-end">
                        <div class="lg:col-span-12">
                            <label class="block text-sm font-semibold text-white mb-2">Cari Nama Rak</label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="searchRakInput"
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
                        <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                            <tr>
                                <th class="text-left px-4 py-3 font-semibold w-16">No.</th>
                                <th class="text-left px-4 py-3 font-semibold">
                                    <span class="inline-flex items-center gap-2">
                                        <i class="fas fa-arrow-up text-green-600 text-xs"></i>
                                        Nama Rak
                                    </span>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold w-32">Status</th>
                                <th class="text-center px-4 py-3 font-semibold w-40">Action</th>
                            </tr>
                        </thead>

                        <tbody id="rakTableBody" class="bg-white dark:bg-gray-950">
                            @forelse ($raks as $index => $rak)
                                <tr class="rak-row border-t border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $rak->nama_rak }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if($rak->status === 'aktif')
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
                                                class="openEditRakModal px-4 py-1.5 rounded-lg border border-blue-300 text-blue-600 text-sm font-medium hover:bg-blue-50"
                                                data-id="{{ $rak->id }}"
                                                data-nama="{{ $rak->nama_rak }}"
                                            >
                                                Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="openDeleteRakModal w-8 h-8 rounded-lg text-red-600 hover:bg-red-50"
                                                data-id="{{ $rak->id }}"
                                                data-nama="{{ $rak->nama_rak }}"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-gray-100 dark:border-gray-800">
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

<!-- Modal Tambah Rak -->
<div id="tambahRakModal" class="fixed inset-0 z-[9999] hidden">
    <div id="tambahRakOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-6">
        <form
            action="{{ route('masterdata.masterrak.store') }}"
            method="POST"
            class="relative z-[10000] w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf

            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Tambah Rak</h3>
                <button
                    type="button"
                    id="closeTambahRakModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-5 space-y-5 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Rak *
                    </label>
                    <input
                        type="text"
                        id="namaRakInput"
                        name="nama_rak"
                        value="{{ old('nama_rak') }}"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                </div>

                <div class="rounded-[22px] bg-yellow-400 dark:bg-yellow-500 px-6 py-5 transition-colors duration-200">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-exclamation text-yellow-400 text-lg"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-900 font-medium">
                            Sebelum membuat rak baru, pastikan sebelumnya benar-benar belum terdaftar agar tidak menyebabkan kebingungan ketika memilih.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelTambahRakModal"
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

<!-- Modal Edit Rak -->
<div id="editRakModal" class="fixed inset-0 z-[10010] hidden">
    <div id="editRakOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-6">
        <form
            id="editRakForm"
            method="POST"
            class="relative z-[10011] w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf
            @method('PUT')

            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Edit Rak</h3>
                <button
                    type="button"
                    id="closeEditRakModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="px-6 py-5 space-y-5 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Rak *
                    </label>
                    <input
                        type="text"
                        id="editNamaRakInput"
                        name="nama_rak"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                </div>

                <div class="rounded-[22px] bg-yellow-400 dark:bg-yellow-500 px-6 py-5 transition-colors duration-200">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-exclamation text-yellow-400 text-lg"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-900 font-medium">
                            Sebelum mengubah rak, pastikan nama yang dimasukkan memang benar agar tidak menyebabkan kebingungan ketika memilih.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelEditRakModal"
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

<!-- Modal Hapus Rak -->
<div id="deleteRakModal" class="fixed inset-0 z-[10020] hidden">
    <div id="deleteRakOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

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
                    Yakin nih ingin hapus <span id="deleteRakNama" class="font-semibold"></span>?
                </p>

                <form id="deleteRakForm" method="POST" class="flex items-center justify-center gap-3">
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
                        id="cancelDeleteRakBtn"
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
    // MODAL: TAMBAH RAK
    // =========================
    const openTambahRakModalBtn = document.getElementById('openTambahRakModal');
    const tambahRakModal = document.getElementById('tambahRakModal');
    const tambahRakOverlay = document.getElementById('tambahRakOverlay');
    const closeTambahRakModalBtn = document.getElementById('closeTambahRakModal');
    const cancelTambahRakModalBtn = document.getElementById('cancelTambahRakModal');

    function openTambahRakModal() {
        if (!tambahRakModal) return;
        tambahRakModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTambahRakModal() {
        if (!tambahRakModal) return;
        tambahRakModal.classList.add('hidden');

        if (
            (!editRakModal || editRakModal.classList.contains('hidden')) &&
            (!deleteRakModal || deleteRakModal.classList.contains('hidden'))
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    openTambahRakModalBtn?.addEventListener('click', openTambahRakModal);
    closeTambahRakModalBtn?.addEventListener('click', closeTambahRakModal);
    cancelTambahRakModalBtn?.addEventListener('click', closeTambahRakModal);
    tambahRakOverlay?.addEventListener('click', closeTambahRakModal);

    // =========================
    // MODAL: EDIT RAK
    // =========================
    const editRakModal = document.getElementById('editRakModal');
    const editRakOverlay = document.getElementById('editRakOverlay');
    const closeEditRakModalBtn = document.getElementById('closeEditRakModal');
    const cancelEditRakModalBtn = document.getElementById('cancelEditRakModal');
    const editRakForm = document.getElementById('editRakForm');
    const editNamaRakInput = document.getElementById('editNamaRakInput');

    function openEditRakModal() {
        if (!editRakModal) return;
        editRakModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditRakModal() {
        if (!editRakModal) return;
        editRakModal.classList.add('hidden');

        if (
            (!tambahRakModal || tambahRakModal.classList.contains('hidden')) &&
            (!deleteRakModal || deleteRakModal.classList.contains('hidden'))
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.querySelectorAll('.openEditRakModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama || '';

            if (editRakForm) {
                editRakForm.action = `/master-data/master-rak/${id}`;
            }

            if (editNamaRakInput) {
                editNamaRakInput.value = nama;
            }

            openEditRakModal();
        });
    });

    closeEditRakModalBtn?.addEventListener('click', closeEditRakModal);
    cancelEditRakModalBtn?.addEventListener('click', closeEditRakModal);
    editRakOverlay?.addEventListener('click', closeEditRakModal);

    // =========================
    // MODAL: HAPUS RAK
    // =========================
    const deleteRakModal = document.getElementById('deleteRakModal');
    const deleteRakOverlay = document.getElementById('deleteRakOverlay');
    const deleteRakForm = document.getElementById('deleteRakForm');
    const deleteRakNama = document.getElementById('deleteRakNama');
    const cancelDeleteRakBtn = document.getElementById('cancelDeleteRakBtn');

    function openDeleteRakModal() {
        if (!deleteRakModal) return;
        deleteRakModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteRakModal() {
        if (!deleteRakModal) return;
        deleteRakModal.classList.add('hidden');

        if (
            (!tambahRakModal || tambahRakModal.classList.contains('hidden')) &&
            (!editRakModal || editRakModal.classList.contains('hidden'))
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.querySelectorAll('.openDeleteRakModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama || '-';

            if (deleteRakForm) {
                deleteRakForm.action = `/master-data/master-rak/${id}`;
            }

            if (deleteRakNama) {
                deleteRakNama.textContent = nama;
            }

            openDeleteRakModal();
        });
    });

    cancelDeleteRakBtn?.addEventListener('click', closeDeleteRakModal);
    deleteRakOverlay?.addEventListener('click', closeDeleteRakModal);

    // =========================
    // SEARCH RAK
    // =========================
    const searchRakInput = document.getElementById('searchRakInput');
    const rakTableBody = document.getElementById('rakTableBody');

    function createSearchEmptyRakRow() {
        let row = document.createElement('tr');
        row.id = 'searchEmptyRakRow';
        row.className = 'border-t border-gray-100 dark:border-gray-800';
        row.innerHTML = `
            <td colspan="4" class="text-center py-20 h-[350px] align-middle text-gray-500 dark:text-gray-400">
                Data tidak ditemukan
            </td>
        `;
        return row;
    }

    function applyRakSearch() {
        const keyword = searchRakInput?.value?.toLowerCase().trim() || '';
        const rows = document.querySelectorAll('#rakTableBody .rak-row');
        let visibleCount = 0;

        document.getElementById('searchEmptyRakRow')?.remove();

        rows.forEach((row) => {
            const rowText = row.children[1]?.textContent.toLowerCase() || '';
            const isMatch = !keyword || rowText.includes(keyword);

            row.classList.toggle('hidden', !isMatch);

            if (isMatch) {
                visibleCount++;
            }
        });

        if (visibleCount === 0 && rows.length > 0) {
            rakTableBody?.appendChild(createSearchEmptyRakRow());
        }
    }

    searchRakInput?.addEventListener('input', applyRakSearch);

    // =========================
    // ESC KEY
    // =========================
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;

        if (tambahRakModal && !tambahRakModal.classList.contains('hidden')) {
            closeTambahRakModal();
        }

        if (editRakModal && !editRakModal.classList.contains('hidden')) {
            closeEditRakModal();
        }

        if (deleteRakModal && !deleteRakModal.classList.contains('hidden')) {
            closeDeleteRakModal();
        }
    });

    // =========================
    // AUTO OPEN JIKA VALIDASI GAGAL
    // =========================
    @if($errors->has('nama_rak'))
        openTambahRakModal();
    @endif
});
</script>
@endpush