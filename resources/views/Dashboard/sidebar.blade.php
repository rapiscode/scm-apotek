<!DOCTYPE html>
<html lang="en" class="transition-colors duration-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinBank')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        };
    </script>

    <script>
        (function () {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .card-3d {
            transform: perspective(1000px) rotateY(-5deg);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 overflow-hidden transition-colors duration-200">
<div class="min-h-screen">

    <!-- Sidebar -->
    <aside class="fixed left-0 top-0 w-72 bg-white dark:bg-gray-950 shadow-sm flex flex-col h-screen overflow-y-auto z-40 border-r border-gray-100 dark:border-gray-800 transition-colors duration-200">
        <div class="p-6">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shrink-0">
                    <i class="fas fa-hospital text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-gray-900 dark:text-gray-100">APOTEK SAYA</span>
            </div>
        </div>

        <nav class="mt-6 flex-1">
            <a href="{{ route('dashboard') }}"
               class="flex items-center px-6 py-3 transition-colors duration-200 {{ request()->routeIs('dashboard') ? 'bg-blue-50 dark:bg-blue-950/40 border-r-4 border-blue-600 text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 group' }}">
                <i class="fas fa-chart-line w-5 mr-3 shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
                <span class="whitespace-nowrap">Dashboard</span>
            </a>

            <!-- Penjualan Dropdown -->
            <div class="px-3">
                <button
                    type="button"
                    id="penjualanToggle"
                    class="w-full flex items-center px-3 py-3 rounded-2xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200"
                >
                    <i class="fas fa-cash-register w-5 mr-3 shrink-0 text-teal-600"></i>
                    <span class="flex-1 text-left font-medium whitespace-nowrap">Penjualan</span>
                    <i id="penjualanArrow" class="fas fa-chevron-down text-xs text-gray-500 transition-transform duration-200"></i>
                </button>

                <div
                    id="penjualanDropdown"
                    class="hidden mt-2 ml-2 bg-gray-50 dark:bg-gray-900 rounded-2xl px-2 py-2 space-y-1 transition-colors duration-200"
                >
                    <a href="{{ route('penjualan.kasir') }}"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 hover:text-teal-700 dark:hover:text-teal-300 transition-colors duration-200">
                        Kasir
                    </a>

                    <a href="#"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        <span>Pesanan Penjualan</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-semibold">BETA</span>
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Daftar Penjualan
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Retur Penjualan
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Penjualan Tertolak
                    </a>

                    <a href="#"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        <span>QRIS</span>
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-green-100 text-green-700 font-semibold">BETA</span>
                    </a>
                </div>
            </div>

            <!-- Persediaan Dropdown -->
            <div class="px-3">
                <button
                    type="button"
                    id="persediaanToggle"
                    class="w-full flex items-center px-3 py-3 rounded-2xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200"
                >
                    <i class="fas fa-boxes-stacked w-5 mr-3 shrink-0 text-teal-600"></i>
                    <span class="flex-1 text-left font-medium whitespace-nowrap">Persediaan</span>
                    <i id="persediaanArrow" class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400 transition-transform duration-200"></i>
                </button>

                <div
                    id="persediaanDropdown"
                    class="hidden mt-2 bg-gray-50 dark:bg-gray-900 rounded-2xl p-3 space-y-1 transition-colors duration-200"
                >
                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Daftar Produk
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Defecta
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Stok Kadaluarsa
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Stok Opname
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Penyesuaian Stok
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Perpindahan Stok
                    </a>
                </div>
            </div>

            <!-- Laporan Dropdown -->
            <div class="px-3">
                <button
                    type="button"
                    id="laporanToggle"
                    class="w-full flex items-center px-3 py-3 rounded-2xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200"
                >
                    <i class="fas fa-book-open w-5 mr-3 shrink-0 text-teal-600"></i>
                    <span class="flex-1 text-left font-medium whitespace-nowrap">Laporan</span>
                    <i id="laporanArrow" class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400 transition-transform duration-200"></i>
                </button>

                <div
                    id="laporanDropdown"
                    class="hidden mt-2 bg-gray-50 dark:bg-gray-900 rounded-2xl p-3 space-y-1 transition-colors duration-200"
                >
                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Laporan Penjualan
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Laporan Pembelian
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Laporan Persediaan
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Laporan Keuangan
                    </a>
                </div>
            </div>

            <!-- Master Data Dropdown -->
            <div class="px-3">
                <button
                    type="button"
                    id="masterDataToggle"
                    class="w-full flex items-center px-3 py-3 rounded-2xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200"
                >
                    <i class="fas fa-database w-5 mr-3 shrink-0 text-teal-600"></i>
                    <span class="flex-1 text-left font-medium whitespace-nowrap">Master Data</span>
                    <i id="masterDataArrow" class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400 transition-transform duration-200"></i>
                </button>

                <div
                    id="masterDataDropdown"
                    class="hidden mt-2 bg-gray-50 dark:bg-gray-900 rounded-2xl p-3 space-y-1 transition-colors duration-200"
                >
                    <a href="{{ route('masterdata.masterproduk') }}"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Master Produk
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Master Kategori
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Master Satuan
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Master Rak
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Master Gudang
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Master Kategori Pelanggan
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Master Item Pemeriksaan
                    </a>
                </div>
            </div>

            <!-- Pusat Bantuan Dropdown -->
            <div class="px-3">
                <button
                    type="button"
                    id="pusatBantuanToggle"
                    class="w-full flex items-center px-3 py-3 rounded-2xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200"
                >
                    <i class="fas fa-wrench w-5 mr-3 shrink-0 text-teal-600"></i>
                    <span class="flex-1 text-left font-medium whitespace-nowrap">Pusat Bantuan</span>
                    <i id="pusatBantuanArrow" class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400 transition-transform duration-200"></i>
                </button>

                <div
                    id="pusatBantuanDropdown"
                    class="hidden mt-2 bg-gray-50 dark:bg-gray-900 rounded-2xl p-3 space-y-1 transition-colors duration-200"
                >
                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Usulkan Fitur Baru
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Riwayat Update
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Minta Bantuan
                    </a>

                    <a href="#"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-800 transition-colors duration-200">
                        Migrasi Data
                    </a>
                </div>
            </div>

            <!-- Manajemen Pengguna Dropdown -->
            <div class="px-3">
                <button
                    type="button"
                    id="userMgmtToggle"
                    class="w-full flex items-center px-3 py-3 rounded-2xl text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200"
                >
                    <i class="fas fa-user-cog w-5 mr-3 shrink-0 text-teal-600"></i>
                    <span class="flex-1 text-left font-medium whitespace-nowrap">Manajemen Pengguna</span>
                    <i id="userMgmtArrow" class="fas fa-chevron-down text-xs text-gray-500 dark:text-gray-400 transition-transform duration-200"></i>
                </button>

                <div
                    id="userMgmtDropdown"
                    class="hidden mt-2 bg-gray-50 dark:bg-gray-900 rounded-2xl p-3 space-y-1 transition-colors duration-200"
                >
                    <a href="{{ route('users.index') }}"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200
                    hover:bg-gray-200 dark:hover:bg-gray-800
                    active:bg-gray-200 dark:active:bg-gray-800
                    transition-colors duration-200">
                        Daftar Pengguna
                    </a>

                    <a href="{{ route('users.custompriv') }}"
                    class="block px-4 py-2 rounded-xl text-sm text-gray-700 dark:text-gray-200
                    hover:bg-gray-200 dark:hover:bg-gray-800
                    active:bg-gray-200 dark:active:bg-gray-800
                    transition-colors duration-200">
                        Peran & Hak Akses
                    </a>
                </div>
            </div>

        </nav>

        <div class="p-6 border-t border-gray-100 dark:border-gray-800 transition-colors duration-200">
            <a href="#" class="flex items-center py-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 group transition-colors duration-200">
                <i class="fas fa-cog w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span>Settings</span>
            </a>

            <a href="#" class="flex items-center py-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 group transition-colors duration-200">
                <i class="fas fa-question-circle w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span>Help Center</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="flex items-center py-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 group w-full transition-colors duration-200">
                    <i class="fas fa-right-from-bracket w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                    <span>Logout</span>
                </button>
            </form>

            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-400 dark:text-gray-500 transition-colors duration-200">
                <p>© FinBank, 2025</p>
                <p>Created by Jeet Saru</p>
                <a href="#" class="text-blue-600 hover:text-blue-700">Support the designer</a>
            </div>
        </div>
    </aside>

    <!-- Header -->
    <header class="fixed top-0 left-72 right-0 z-30 bg-white dark:bg-gray-950 shadow-sm border-b border-gray-100 dark:border-gray-800 transition-colors duration-200">
        <div class="flex items-center justify-between px-8 py-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">@yield('page_title')</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">@yield('page_subtitle')</p>
            </div>

            <div class="flex items-center space-x-4">
                <button type="button" id="themeToggle" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                    <i id="themeIcon" class="fas fa-moon text-gray-600 dark:text-gray-200"></i>
                </button>

                <button type="button" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors duration-200">
                    <i class="fas fa-bell text-gray-600 dark:text-gray-200"></i>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button type="button" id="profileBtn" class="w-10 h-10 rounded-full overflow-hidden focus:outline-none">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=4F46E5&color=fff"
                            class="w-10 h-10 rounded-full"
                            alt="User"
                        >
                    </button>

                    <div id="profileDropdown"
                         class="hidden absolute right-0 mt-3 w-56 bg-white dark:bg-gray-950 rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 z-50 overflow-hidden transition-colors duration-200">

                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? '-' }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200">
                            <i class="fa-regular fa-user"></i>
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-gray-900 transition-colors duration-200">
                                <i class="fa-solid fa-right-from-bracket"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main class="ml-72 pt-20 h-screen overflow-y-auto text-gray-900 dark:text-gray-100 transition-colors duration-200">
        <div class="p-8">
            @if(session('success'))
                <div class="mb-4 rounded-lg bg-green-50 text-green-700 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 rounded-lg bg-red-50 text-red-700 px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const html = document.documentElement;
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    const penjualanToggle = document.getElementById('penjualanToggle');
    const penjualanDropdown = document.getElementById('penjualanDropdown');
    const penjualanArrow = document.getElementById('penjualanArrow');

    const userMgmtToggle = document.getElementById('userMgmtToggle');
    const userMgmtDropdown = document.getElementById('userMgmtDropdown');
    const userMgmtArrow = document.getElementById('userMgmtArrow');

    const persediaanToggle = document.getElementById('persediaanToggle');
    const persediaanDropdown = document.getElementById('persediaanDropdown');
    const persediaanArrow = document.getElementById('persediaanArrow');

    const laporanToggle = document.getElementById('laporanToggle');
    const laporanDropdown = document.getElementById('laporanDropdown');
    const laporanArrow = document.getElementById('laporanArrow');

    const masterDataToggle = document.getElementById('masterDataToggle');
    const masterDataDropdown = document.getElementById('masterDataDropdown');
    const masterDataArrow = document.getElementById('masterDataArrow');

    const pusatBantuanToggle = document.getElementById('pusatBantuanToggle');
    const pusatBantuanDropdown = document.getElementById('pusatBantuanDropdown');
    const pusatBantuanArrow = document.getElementById('pusatBantuanArrow');

    function applyTheme(theme) {
        const isDark = theme === 'dark';

        if (isDark) {
            html.classList.add('dark');
        } else {
            html.classList.remove('dark');
        }

        localStorage.setItem('theme', theme);

        if (themeIcon) {
            themeIcon.className = isDark
                ? 'fas fa-sun text-gray-200'
                : 'fas fa-moon text-gray-600';
        }
    }

    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);

    themeToggle?.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const nextTheme = html.classList.contains('dark') ? 'light' : 'dark';
        applyTheme(nextTheme);
    });

    profileBtn?.addEventListener('click', function (e) {
        e.stopPropagation();
        profileDropdown?.classList.toggle('hidden');
    });

    document.addEventListener('click', function (e) {
        if (!profileDropdown || !profileBtn) return;

        if (!profileDropdown.contains(e.target) && !profileBtn.contains(e.target)) {
            profileDropdown.classList.add('hidden');
        }
    });

    penjualanToggle?.addEventListener('click', function () {
        penjualanDropdown?.classList.toggle('hidden');
        penjualanArrow?.classList.toggle('rotate-180');
    });

    userMgmtToggle?.addEventListener('click', function () {
        userMgmtDropdown?.classList.toggle('hidden');
        userMgmtArrow?.classList.toggle('rotate-180');
    });

    persediaanToggle?.addEventListener('click', function () {
        persediaanDropdown?.classList.toggle('hidden');
        persediaanArrow?.classList.toggle('rotate-180');
    });

    laporanToggle?.addEventListener('click', function () {
        laporanDropdown?.classList.toggle('hidden');
        laporanArrow?.classList.toggle('rotate-180');
    });

    masterDataToggle?.addEventListener('click', function () {
        masterDataDropdown?.classList.toggle('hidden');
        masterDataArrow?.classList.toggle('rotate-180');
    });

    pusatBantuanToggle?.addEventListener('click', function () {
        pusatBantuanDropdown?.classList.toggle('hidden');
        pusatBantuanArrow?.classList.toggle('rotate-180');
    });

    if (window.location.pathname.includes('/control-user')) {
        userMgmtDropdown?.classList.remove('hidden');
        userMgmtArrow?.classList.add('rotate-180');
    }
});
</script>

</body>
</html>