@extends('Dashboard.sidebar')

@section('title', 'FinBank - Tambah User')
@section('page_title', 'Tambah User')
@section('page_subtitle', 'Buat akun pengguna baru untuk sistem.')

@section('content')
    <div class="max-w-2xl">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <form method="POST" action="{{ route('users.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100"
                        placeholder="Nama user"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                        name="email"
                        value="{{ old('email') }}"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100"
                        placeholder="email@domain.com"
                    >
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input
                        name="password"
                        type="password"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100"
                        placeholder="••••••••"
                    >
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select
                            name="role"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"
                        >
                            @foreach($roles as $r)
                                <option value="{{ $r }}" @selected(old('role') === $r)>
                                    {{ strtoupper($r) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-end">
                        <label class="inline-flex items-center gap-2 select-none">
                            <input
                                class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-200"
                                type="checkbox"
                                name="is_active"
                                value="1"
                                {{ old('is_active', '1') ? 'checked' : '' }}
                            >
                            <span class="text-sm text-gray-700">Aktif</span>
                        </label>
                    </div>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <a
                        href="{{ route('users.index') }}"
                        class="px-4 py-2 border border-gray-200 rounded-lg hover:bg-gray-50 text-gray-700"
                    >
                        Batal
                    </a>

                    <button
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700"
                        type="submit"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
