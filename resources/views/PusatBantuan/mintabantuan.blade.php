@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Minta Bantuan')
@section('page_title', 'Minta Bantuan')
@section('page_subtitle', 'Laporkan kendala atau hubungi tim bantuan.')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <i class="fas fa-headset text-red-600"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Form Bantuan</h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Sampaikan kendala yang sedang kamu alami.</p>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('wa_link'))
                    <div class="mb-4 rounded-xl border border-green-200 bg-green-50 p-4">
                        <div class="flex items-start justify-between gap-4 flex-wrap">
                            <div>
                                <p class="font-semibold text-green-700">Email berhasil dikirim.</p>
                                <p class="text-sm text-green-600">Lanjutkan kirim ringkasan laporan ke WhatsApp admin.</p>
                            </div>

                            <a
                                href="{{ session('wa_link') }}"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-green-500 hover:bg-green-600 text-white font-semibold transition"
                            >
                                <i class="fab fa-whatsapp"></i>
                                Kirim ke WhatsApp
                            </a>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('pusatbantuan.mintabantuan.store') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Subjek</label>
                        <input
                            type="text"
                            name="subjek"
                            value="{{ old('subjek') }}"
                            placeholder="Contoh: Tidak bisa simpan transaksi"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-200"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori Masalah</label>
                        <select
                            name="kategori"
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-200"
                        >
                            <option value="Bug Sistem">Bug Sistem</option>
                            <option value="Transaksi">Transaksi</option>
                            <option value="Persediaan">Persediaan</option>
                            <option value="Akun Pengguna">Akun Pengguna</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Detail Masalah</label>
                        <textarea
                            name="detail"
                            rows="6"
                            placeholder="Jelaskan masalah yang terjadi..."
                            class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-red-200"
                        >{{ old('detail') }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl bg-red-500 hover:bg-red-600 text-white font-semibold transition"
                        >
                            Kirim Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Kontak Bantuan</h3>
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <p><strong>Email:</strong> refree06@gmail.com</p>
                    <p><strong>WhatsApp:</strong> 0813-9835-7731</p>
                    <p><strong>Jam Operasional:</strong> 00.00 - 23.59</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Tips</h3>
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                    <p>Jelaskan langkah sebelum error muncul.</p>
                    <p>contoh: "Saat saya klik simpan transaksi, muncul pesan error 'Gagal menyimpan data'. Saya sudah coba refresh halaman dan ulangi, tapi tetap muncul error yang sama."</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection