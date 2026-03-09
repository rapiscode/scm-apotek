@extends('Dashboard.sidebar')

@section('title', 'APOTEK SAYA - Peran & Hak Akses')
@section('page_title', 'Peran & Hak Akses')
@section('page_subtitle', 'Kelola role dan hak akses pengguna.')

@section('content')
    @php
        $defaultRoles = collect([
            (object) ['name' => 'admin', 'is_active' => true],
            (object) ['name' => 'user', 'is_active' => true],
            (object) ['name' => 'kasir', 'is_active' => true],
        ]);

        $roleData = isset($roles) && count($roles) ? collect($roles) : $defaultRoles;
    @endphp

    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-950 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-5 transition-colors duration-200">
            <div class="flex items-center justify-between gap-4 flex-wrap mb-4">
                <div>
                    <h2 class="text-3xl font-bold text-blue-700 dark:text-blue-400">Peran & Hak Akses</h2>
                </div>

                <a href="#"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-teal-500 hover:bg-teal-600 text-white font-medium transition-colors duration-200">
                    <i class="fas fa-plus-circle"></i>
                    <span>Peran Baru</span>
                </a>
            </div>

            <div class="flex items-center justify-between gap-3 flex-wrap mb-4">
                <div class="relative w-full max-w-xs">
                    <input
                        type="text"
                        placeholder="Cari data"
                        class="w-full pl-4 pr-10 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100 placeholder:text-gray-400 dark:placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-100 dark:focus:ring-blue-900 transition-colors duration-200"
                    >
                    <div class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center gap-2 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-bars-staggered text-sm"></i>
                        <i class="fas fa-search text-sm"></i>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-filter text-sm"></i>
                        <span>Filter</span>
                        <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-500 text-white text-xs font-semibold">0</span>
                    </button>

                    <button
                        type="button"
                        class="w-10 h-10 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-users-gear"></i>
                    </button>

                    <button
                        type="button"
                        class="w-10 h-10 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors duration-200"
                    >
                        <i class="fas fa-download"></i>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-900 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="text-left px-4 py-3 font-semibold w-16">No.</th>
                            <th class="text-left px-4 py-3 font-semibold">Nama Role</th>
                            <th class="text-center px-4 py-3 font-semibold w-32">Status</th>
                            <th class="text-center px-4 py-3 font-semibold w-44">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white dark:bg-gray-950">
                        @forelse($roleData as $index => $role)
                            @php
                                $roleName = is_object($role) ? ($role->name ?? $role->role ?? '-') : (is_array($role) ? ($role['name'] ?? $role['role'] ?? '-') : $role);
                                $isActive = is_object($role) ? ($role->is_active ?? true) : (is_array($role) ? ($role['is_active'] ?? true) : true);
                                $isLocked = strtolower($roleName) === 'admin';
                            @endphp

                            <tr class="border-t border-gray-100 dark:border-gray-800 text-gray-700 dark:text-gray-200">
                                <td class="px-4 py-4">{{ $index + 1 }}</td>

                                <td class="px-4 py-4 font-medium">
                                    {{ $roleName }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    @if($isActive)
                                        <span class="inline-flex px-2 py-1 rounded-md text-xs font-semibold bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <div class="flex items-center justify-center gap-3">
                                        @if($isLocked)
                                            <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                                                Tidak Dapat Diubah
                                            </span>
                                        @else
                                            <a href="#"
                                               class="px-4 py-1.5 rounded-lg border border-blue-300 text-blue-600 hover:bg-blue-50 dark:border-blue-700 dark:text-blue-400 dark:hover:bg-blue-950/30 transition-colors duration-200">
                                                Edit
                                            </a>

                                            <button
                                                type="button"
                                                class="text-red-500 hover:text-red-600 transition-colors duration-200"
                                                title="Hapus"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="border-t border-gray-100 dark:border-gray-800">
                                <td colspan="4" class="px-4 py-10 text-center text-gray-400 dark:text-gray-500">
                                    Belum ada data role.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection