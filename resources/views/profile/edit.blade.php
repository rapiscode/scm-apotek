@extends('Dashboard.sidebar')

@section('title', 'FinBank - Edit Profile')
@section('page_title', 'Edit Profile')
@section('page_subtitle', 'Update informasi akun kamu')

@section('content')
<div class="max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-start justify-between gap-4 mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Informasi Profile</h2>
                <p class="text-sm text-gray-500">Ubah nama, email, dan password (opsional).</p>
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
                <label class="block text-sm font-medium text-gray-700">Nama</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    class="mt-1 w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    required
                >
                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="mt-1 w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    required
                >
                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <hr class="my-4">

            <div>
                <label class="block text-sm font-medium text-gray-700">Password Baru (opsional)</label>
                <input
                    type="password"
                    name="password"
                    class="mt-1 w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    placeholder="Isi kalau mau ganti password"
                >
                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password Baru</label>
                <input
                    type="password"
                    name="password_confirmation"
                    class="mt-1 w-full rounded-lg border border-gray-200 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-200"
                    placeholder="Ulangi password baru"
                >
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('dashboard') }}"
                   class="px-4 py-2 rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
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

    <div class="mt-4 text-xs text-gray-500">
        Tips: kalau cuma mau ganti nama/email, biarin password kosong aja.
    </div>
</div>
@endsection
