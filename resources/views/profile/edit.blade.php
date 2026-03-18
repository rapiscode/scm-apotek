@extends('Dashboard.sidebar')

@section('title', 'FinBank - Edit Profile')
@section('page_title', 'Edit Profile')
@section('page_subtitle', 'Update informasi akun kamu')

@section('content')
<div class="w-full min-h-screen p-6">
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm dark:shadow-none border border-gray-100 dark:border-gray-800 p-6 w-full min-h-[calc(100vh-120px)]">
        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Informasi Profile</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Ubah nama, email, dan password (opsional).</p>
            </div>

            <img
                src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? 'User') }}&background=4F46E5&color=fff"
                class="w-14 h-14 rounded-full"
                alt="User"
            >
        </div>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500/30"
                    required
                >
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500/30"
                    required
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-4 border-gray-200 dark:border-gray-700">

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password Baru (opsional)</label>
                <input
                    type="password"
                    name="password"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500/30"
                    placeholder="Isi kalau mau ganti password"
                >
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Konfirmasi Password Baru</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="mt-1 w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-500/30"
                    placeholder="Ulangi password baru"
                >
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800">
                    Batal
                </a>
                <button
                    type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700"
                >
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection