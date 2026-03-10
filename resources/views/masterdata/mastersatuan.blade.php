@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Master Satuan')
@section('page_title', 'Daftar Satuan')
@section('page_subtitle', 'Kelola data satuan kemasan.')

@section('content')
    <div class="space-y-4">
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 transition-colors duration-200">
            <!-- Header -->
            <div class="flex items-center justify-between gap-4 flex-wrap mb-4">
                <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Daftar Satuan</h2>

                <button
                    type="button"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-semibold text-sm transition-colors duration-200"
                >
                    <i class="fas fa-plus"></i>
                    Tambah Satuan Kemasan
                </button>
            </div>

            <!-- Filter Box -->
            <div class="rounded-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="bg-blue-600 px-4 py-4">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-3 items-end">
                        <div class="lg:col-span-10">
                            <label class="block text-sm font-semibold text-white mb-2">Cari Satuan Kemasan</label>
                            <div class="relative">
                                <input
                                    type="text"
                                    placeholder="Ketik di sini"
                                    class="w-full rounded-lg border border-blue-500 bg-white text-gray-700 placeholder:text-gray-400 px-4 py-3 pr-10 focus:outline-none"
                                >
                                <i class="fas fa-search absolute right-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <div class="lg:col-span-2">
                            <label class="block text-sm font-semibold text-white mb-2">Filter</label>
                            <div class="relative">
                                <select
                                    class="w-full appearance-none rounded-lg border border-blue-500 bg-white text-gray-700 px-4 py-3 pr-10 focus:outline-none"
                                >
                                    <option>Semua Satuan</option>
                                </select>
                                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto max-h-[650px] overflow-y-auto">
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

                        <tbody class="bg-white dark:bg-gray-950">
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td colspan="4" class="text-center py-20 text-gray-500 dark:text-gray-400">
                                    Data tidak ditemukan
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection