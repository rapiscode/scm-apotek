@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Control User')
@section('page_title', 'Control User')
@section('page_subtitle', 'Kelola akun pengguna (admin/kasir/user).')

@section('content')
    <div class="space-y-6">

        {{-- Toolbar / Filter --}}
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm p-6 border border-gray-100 dark:border-gray-800 transition-colors duration-200">
            <div class="flex items-center justify-between gap-4 flex-wrap">
                <form class="flex items-center gap-3 flex-wrap" method="GET" action="{{ route('users.index') }}">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 text-sm"></i>
                        <input
                            type="text"
                            name="q"
                            class="pl-9 pr-3 py-2 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg w-72 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900 placeholder:text-gray-400 dark:placeholder:text-gray-500 transition-colors duration-200"
                            placeholder="Cari nama/email..."
                            value="{{ $q ?? request('q') }}"
                        >
                    </div>

                    <select
                        name="role"
                        class="py-2 px-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg transition-colors duration-200"
                    >
                        <option value="">Semua Role</option>
                        @foreach($roles as $r)
                            <option value="{{ $r }}" @selected(($role ?? request('role')) === $r)>{{ strtoupper($r) }}</option>
                        @endforeach
                    </select>

                    <select
                        name="active"
                        class="py-2 px-3 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 rounded-lg transition-colors duration-200"
                    >
                        <option value="">Semua Status</option>
                        <option value="1" @selected(($active ?? request('active')) === '1')>Aktif</option>
                        <option value="0" @selected(($active ?? request('active')) === '0')>Nonaktif</option>
                    </select>

                    <button class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200" type="submit">
                        Filter
                    </button>

                    <a
                        class="py-2 px-4 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                        href="{{ route('users.index') }}"
                    >
                        Reset
                    </a>
                </form>

                <a href="{{ route('users.create') }}"
                   class="py-2 px-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                    <i class="fas fa-plus mr-2"></i>Tambah User
                </a>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-800 transition-colors duration-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900 text-xs text-gray-500 dark:text-gray-400 transition-colors duration-200">
                        <tr>
                            <th class="text-left px-6 py-4 font-medium">#</th>
                            <th class="text-left px-6 py-4 font-medium">Nama</th>
                            <th class="text-left px-6 py-4 font-medium">Email</th>
                            <th class="text-left px-6 py-4 font-medium">Role</th>
                            <th class="text-left px-6 py-4 font-medium">Status</th>
                            <th class="text-right px-6 py-4 font-medium">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-sm">
                        @forelse($users as $i => $u)
                            <tr class="border-t border-gray-100 dark:border-gray-800 transition-colors duration-200">
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    {{ $users->firstItem() + $i }}
                                </td>

                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-gray-100">
                                    {{ $u->name }}
                                </td>

                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ $u->email }}
                                </td>

                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-lg text-xs bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 transition-colors duration-200">
                                        {{ strtoupper($u->role) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4">
                                    @if($u->is_active)
                                        <span class="px-2 py-1 rounded-lg text-xs bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 transition-colors duration-200">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="px-2 py-1 rounded-lg text-xs bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400 transition-colors duration-200">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('users.edit', $u) }}"
                                           class="px-3 py-2 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 transition-colors duration-200">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('users.toggle', $u) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button
                                                class="px-3 py-2 border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-200 transition-colors duration-200"
                                                type="submit"
                                            >
                                                {{ $u->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>

                                        <form method="POST"
                                              action="{{ route('users.destroy', $u) }}"
                                              onsubmit="return confirm('Hapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                                                    type="submit">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-gray-100 dark:border-gray-800 transition-colors duration-200">
                                <td colspan="6" class="px-6 py-10 text-center text-gray-400 dark:text-gray-500">
                                    Belum ada user.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800 transition-colors duration-200">
                {{ $users->links() }}
            </div>
        </div>

    </div>
@endsection