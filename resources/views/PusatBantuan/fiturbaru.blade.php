@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Usulkan Fitur Baru')
@section('page_title', 'Usulkan Fitur Baru')
@section('page_subtitle', 'Sampaikan ide fitur baru untuk pengembangan sistem.')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <i class="fas fa-lightbulb text-blue-600"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Form Usulan Fitur</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Isi ide fitur yang ingin kamu tambahkan ke aplikasi.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('pusatbantuan.fiturbaru.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Fitur</label>
                        <input
                            type="text"
                            name="nama_fitur"
                            placeholder="Contoh: Export laporan PDF"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                        <select name="kategori" class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-200">
                            <option>Penjualan</option>
                            <option>Persediaan</option>
                            <option>Master Data</option>
                            <option>Laporan</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Deskripsi Fitur</label>
                        <textarea
                            name="deskripsi"
                            rows="6"
                            placeholder="Jelaskan fitur yang diusulkan..."
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Manfaat</label>
                        <textarea
                            name="manfaat"
                            rows="4"
                            placeholder="Apa manfaat fitur ini untuk pengguna?"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-200"
                        ></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition"
                        >
                            Kirim Usulan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div>
            <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Panduan</h3>
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <p>Jelaskan fitur dengan singkat dan jelas.</p>
                    <p>Sebutkan manfaat utama bagi kasir atau admin.</p>
                    <p>Tambahkan contoh penggunaan bila perlu.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection