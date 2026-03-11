@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Master Satuan')
@section('page_title', 'Daftar Satuan')
@section('page_subtitle', 'Kelola data satuan kemasan.')

@section('content')
    <div class="space-y-4 min-h-[calc(100vh-120px)] flex flex-col">
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 transition-colors duration-200 flex flex-col flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-4">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Daftar Satuan</h2>

                <button
                    type="button"
                    id="openTambahSatuanModal"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                >
                    <i class="fas fa-plus"></i>
                    Tambah Satuan Kemasan
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

            @if($errors->has('nama_satuan'))
                <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
                    {{ $errors->first('nama_satuan') }}
                </div>
            @endif

            <!-- Filter Box -->
            <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800 flex flex-col flex-1">
                <div class="bg-blue-600 px-4 py-4">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-end">
                        <div class="lg:col-span-12">
                            <label class="block text-sm font-semibold text-white mb-2">Cari Satuan Kemasan</label>
                            <div class="relative">
                                <input
                                    type="text"
                                    id="searchSatuanInput"
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
                                        <i class="fas fa-sort text-xs text-gray-500"></i>
                                        Nama Satuan
                                    </span>
                                </th>
                                <th class="text-center px-4 py-3 font-semibold w-32">Status</th>
                                <th class="text-center px-4 py-3 font-semibold w-40">Actions</th>
                            </tr>
                        </thead>

                        <tbody id="satuanTableBody" class="bg-white dark:bg-gray-950">
                            @forelse ($satuans as $index => $satuan)
                                <tr class="satuan-row border-t border-gray-100 dark:border-gray-800">
                                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3">{{ $satuan->nama_satuan }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if($satuan->status === 'aktif')
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
                                                class="openEditSatuanModal px-4 py-1.5 rounded-lg border border-blue-300 text-blue-600 text-sm font-medium hover:bg-blue-50"
                                                data-id="{{ $satuan->id }}"
                                                data-nama="{{ $satuan->nama_satuan }}"
                                            >
                                                Edit
                                            </button>
                                            <button
                                                type="button"
                                                class="openDeleteSatuanModal w-8 h-8 rounded-lg text-red-600 hover:bg-red-50"
                                                data-id="{{ $satuan->id }}"
                                                data-nama="{{ $satuan->nama_satuan }}"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t border-gray-100 dark:border-gray-800">
                                    <td colspan="4" class="text-center py-20 text-gray-500 dark:text-gray-400">
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

<!-- Modal Tambah Satuan Kemasan -->
<div id="tambahSatuanModal" class="fixed inset-0 z-[9999] hidden">
    <div id="tambahSatuanOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-6">
        <form
            action="{{ route('masterdata.mastersatuan.store') }}"
            method="POST"
            class="relative z-[10000] w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf

            <!-- Header -->
            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Tambah Satuan Kemasan</h3>
                <button
                    type="button"
                    id="closeTambahSatuanModal"
                    class="text-white/90 hover:text-white text-xl"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="px-6 py-5 space-y-5 bg-white dark:bg-gray-950 transition-colors duration-200">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Nama Satuan Kemasan *
                    </label>
                    <input
                        type="text"
                        id="namaSatuanInput"
                        name="nama_satuan"
                        value="{{ old('nama_satuan') }}"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
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

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelTambahSatuanModal"
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

<!-- Modal Edit Satuan Kemasan -->
<div id="editSatuanModal" class="fixed inset-0 z-[9999] hidden">
    <div id="editSatuanOverlay" class="absolute inset-0 bg-black/60 backdrop-blur-[2px]"></div>

    <div class="absolute inset-0 flex items-center justify-center p-4 sm:p-6">
        <form
            id="editSatuanForm"
            method="POST"
            class="relative z-[10000] w-full max-w-[445px] rounded-2xl overflow-hidden shadow-2xl bg-white dark:bg-gray-950 border border-gray-200 dark:border-gray-800 transition-colors duration-200"
        >
            @csrf
            @method('PUT')

            <div class="bg-blue-600 px-6 py-5 flex items-center justify-between">
                <h3 class="text-2xl font-bold text-white">Edit Satuan Kemasan</h3>
                <button
                    type="button"
                    id="closeEditSatuanModal"
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
                        id="editNamaSatuanInput"
                        name="nama_satuan"
                        class="w-full rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                </div>

                <div class="rounded-[22px] bg-yellow-400 dark:bg-yellow-500 px-6 py-5 transition-colors duration-200">
                    <div class="flex gap-4 items-start">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center shrink-0 mt-1">
                            <i class="fas fa-exclamation text-yellow-400 text-lg"></i>
                        </div>

                        <p class="text-sm leading-6 text-slate-900 font-medium">
                            Sebelum mengubah satuan kemasan, pastikan nama yang dimasukkan memang benar agar tidak menyebabkan kebingungan ketika memilih.
                        </p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-dashed border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 flex items-center justify-end gap-3 transition-colors duration-200">
                <button
                    type="button"
                    id="cancelEditSatuanModal"
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

<!-- Modal Hapus Satuan -->
<div id="deleteSatuanModal" class="fixed inset-0 z-[10070] hidden">
    <div id="deleteSatuanOverlay" class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"></div>

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
                    Yakin nih ingin hapus <span id="deleteSatuanNama" class="font-semibold"></span>?
                </p>

                <form id="deleteSatuanForm" method="POST" class="flex items-center justify-center gap-3">
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
                        id="cancelDeleteSatuanBtn"
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
    // MODAL: TAMBAH SATUAN
    // =========================
    const openTambahSatuanModalBtn = document.getElementById('openTambahSatuanModal');
    const tambahSatuanModal = document.getElementById('tambahSatuanModal');
    const tambahSatuanOverlay = document.getElementById('tambahSatuanOverlay');
    const closeTambahSatuanModalBtn = document.getElementById('closeTambahSatuanModal');
    const cancelTambahSatuanModalBtn = document.getElementById('cancelTambahSatuanModal');

    function openTambahSatuanModal() {
        if (!tambahSatuanModal) return;
        tambahSatuanModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeTambahSatuanModal() {
        if (!tambahSatuanModal) return;
        tambahSatuanModal.classList.add('hidden');

        if (!editSatuanModal || editSatuanModal.classList.contains('hidden')) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    openTambahSatuanModalBtn?.addEventListener('click', openTambahSatuanModal);
    closeTambahSatuanModalBtn?.addEventListener('click', closeTambahSatuanModal);
    cancelTambahSatuanModalBtn?.addEventListener('click', closeTambahSatuanModal);
    tambahSatuanOverlay?.addEventListener('click', closeTambahSatuanModal);

    // =========================
    // MODAL: EDIT SATUAN
    // =========================
    const editSatuanModal = document.getElementById('editSatuanModal');
    const editSatuanOverlay = document.getElementById('editSatuanOverlay');
    const closeEditSatuanModalBtn = document.getElementById('closeEditSatuanModal');
    const cancelEditSatuanModalBtn = document.getElementById('cancelEditSatuanModal');
    const editSatuanForm = document.getElementById('editSatuanForm');
    const editNamaSatuanInput = document.getElementById('editNamaSatuanInput');

    function openEditSatuanModal() {
        if (!editSatuanModal) return;
        editSatuanModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeEditSatuanModal() {
        if (!editSatuanModal) return;
        editSatuanModal.classList.add('hidden');

        if (!tambahSatuanModal || tambahSatuanModal.classList.contains('hidden')) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.querySelectorAll('.openEditSatuanModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama || '';

            if (editSatuanForm) {
                editSatuanForm.action = `/master-data/master-satuan/${id}`;
            }

            if (editNamaSatuanInput) {
                editNamaSatuanInput.value = nama;
            }

            openEditSatuanModal();
        });
    });

    closeEditSatuanModalBtn?.addEventListener('click', closeEditSatuanModal);
    cancelEditSatuanModalBtn?.addEventListener('click', closeEditSatuanModal);
    editSatuanOverlay?.addEventListener('click', closeEditSatuanModal);

    // =========================
    // ESC KEY
    // =========================
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;

        if (tambahSatuanModal && !tambahSatuanModal.classList.contains('hidden')) {
            closeTambahSatuanModal();
        }

        if (editSatuanModal && !editSatuanModal.classList.contains('hidden')) {
            closeEditSatuanModal();
        }

        if (deleteSatuanModal && !deleteSatuanModal.classList.contains('hidden')) {
            closeDeleteSatuanModal();
        }
    });

    // =========================
    // AUTO OPEN MODAL JIKA VALIDASI GAGAL
    // =========================
    @if($errors->has('nama_satuan'))
        openTambahSatuanModal();
    @endif

    // =========================
    // MODAL: HAPUS SATUAN
    // =========================
    const deleteSatuanModal = document.getElementById('deleteSatuanModal');
    const deleteSatuanOverlay = document.getElementById('deleteSatuanOverlay');
    const deleteSatuanForm = document.getElementById('deleteSatuanForm');
    const deleteSatuanNama = document.getElementById('deleteSatuanNama');
    const cancelDeleteSatuanBtn = document.getElementById('cancelDeleteSatuanBtn');

    function openDeleteSatuanModal() {
        if (!deleteSatuanModal) return;
        deleteSatuanModal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteSatuanModal() {
        if (!deleteSatuanModal) return;
        deleteSatuanModal.classList.add('hidden');

        if (
            (!tambahSatuanModal || tambahSatuanModal.classList.contains('hidden')) &&
            (!editSatuanModal || editSatuanModal.classList.contains('hidden'))
        ) {
            document.body.classList.remove('overflow-hidden');
        }
    }

    document.querySelectorAll('.openDeleteSatuanModal').forEach((btn) => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama || '-';

            if (deleteSatuanForm) {
                deleteSatuanForm.action = `/master-data/master-satuan/${id}`;
            }

            if (deleteSatuanNama) {
                deleteSatuanNama.textContent = nama;
            }

            openDeleteSatuanModal();
        });
    });

    cancelDeleteSatuanBtn?.addEventListener('click', closeDeleteSatuanModal);
    deleteSatuanOverlay?.addEventListener('click', closeDeleteSatuanModal);

    // =========================
    // SEARCH SATUAN
    // =========================
    const searchSatuanInput = document.getElementById('searchSatuanInput');
    const satuanTableBody = document.getElementById('satuanTableBody');

    function createSearchEmptySatuanRow() {
        let row = document.createElement('tr');
        row.id = 'searchEmptySatuanRow';
        row.className = 'border-t border-gray-100 dark:border-gray-800';
        row.innerHTML = `
            <td colspan="4" class="text-center py-20 text-gray-500 dark:text-gray-400">
                Data tidak ditemukan
            </td>
        `;
        return row;
    }

    function applySatuanSearch() {
        const keyword = searchSatuanInput?.value?.toLowerCase().trim() || '';
        const rows = document.querySelectorAll('#satuanTableBody .satuan-row');
        let visibleCount = 0;

        document.getElementById('searchEmptySatuanRow')?.remove();

        rows.forEach((row) => {
            const rowText = row.textContent.toLowerCase();
            const isMatch = !keyword || rowText.includes(keyword);

            row.classList.toggle('hidden', !isMatch);

            if (isMatch) {
                visibleCount++;
            }
        });

        if (visibleCount === 0 && rows.length > 0) {
            satuanTableBody?.appendChild(createSearchEmptySatuanRow());
        }
    }

    searchSatuanInput?.addEventListener('input', applySatuanSearch);
});
</script>
@endpush