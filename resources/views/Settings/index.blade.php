@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Settings')
@section('page_title', 'Settings')
@section('page_subtitle', 'Kelola profil dan pengaturan notifikasi.')

@section('content')
<div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
    
    <div class="xl:col-span-2 space-y-6">
        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <i class="fas fa-user text-blue-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Edit Profile</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Ubah informasi akun kamu.</p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama</label>
                    <input
                        type="text"
                        value="{{ auth()->user()->name }}"
                        readonly
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-3"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                    <input
                        type="email"
                        value="{{ auth()->user()->email }}"
                        readonly
                        class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 px-4 py-3"
                    >
                </div>

                <div class="pt-2">
                    <a
                        href="{{ route('profile.edit') }}"
                        class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition"
                    >
                        <i class="fas fa-pen"></i>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-yellow-100 dark:bg-yellow-900/30 flex items-center justify-center">
                    <i class="fas fa-bell text-yellow-600"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Pengaturan Notifikasi</h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Atur notifikasi sistem sesuai kebutuhan.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('settings.notifications.update') }}">
                @csrf

                <label class="flex items-center justify-between gap-4 rounded-2xl border border-gray-200 dark:border-gray-700 px-5 py-4 cursor-pointer">
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-gray-100">Aktifkan Notifikasi</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Terima notifikasi aktivitas penting dari sistem.</p>
                    </div>

                    <input
                        type="checkbox"
                        name="notifications_enabled"
                        value="1"
                        class="w-5 h-5"
                    >
                </label>

                <div class="pt-5">
                    <button
                        type="submit"
                        class="px-5 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold transition"
                    >
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div>
        <div class="bg-white dark:bg-gray-950 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">Info Akun</h3>

            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-300">
                <p><span class="font-semibold">Nama:</span> {{ auth()->user()->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p>
                <p><span class="font-semibold">Status:</span> Aktif</p>
            </div>
        </div>
    </div>
</div>
@endsection