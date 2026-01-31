<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'FinBank')</title>

    <!-- Tailwind config -->
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <!-- INIT THEME (jalan sebelum Tailwind render) -->
    <script>
        (function () {
            const theme = localStorage.getItem('theme') || 'light';
            document.documentElement.classList.toggle('dark', theme === 'dark');
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .card-3d {
            transform: perspective(1000px) rotateY(-5deg);
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 overflow-hidden">
<div class="min-h-screen">

    <!-- Sidebar (FIXED) -->
    <aside class="fixed left-0 top-0 w-64 bg-white dark:bg-gray-950 shadow-sm flex flex-col h-screen z-40">
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
               class="flex items-center px-6 py-3 {{ request()->routeIs('dashboard') ? 'bg-blue-50 border-r-4 border-blue-600 text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 group' }}">
                <i class="fas fa-chart-line w-5 mr-3 shrink-0 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('users.index') }}"
               class="flex items-center px-6 py-3 {{ request()->routeIs('users.*') ? 'bg-blue-50 border-r-4 border-blue-600 text-blue-600' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 group' }}">
                <i class="fas fa-users-cog w-5 mr-3 shrink-0 {{ request()->routeIs('users.*') ? 'text-blue-600' : 'group-hover:text-blue-600' }}"></i>
                <span class="flex-1">Control User</span>
                <i class="fas fa-chevron-right text-xs {{ request()->routeIs('users.*') ? 'text-blue-600' : 'text-gray-400 dark:text-gray-500' }}"></i>
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 group">
                <i class="fas fa-cash-register w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span class="flex-1">Penjualan</span>
                <i class="fas fa-chevron-right text-xs text-gray-400 dark:text-gray-500"></i>
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 group">
                <i class="fas fa-store w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span>Marketplace</span>
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 group">
                <i class="fas fa-wallet w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span>Money</span>
            </a>

            <a href="#" class="flex items-center px-6 py-3 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-900 group">
                <i class="fas fa-share-nodes w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span>Social Media</span>
            </a>
        </nav>

        <div class="p-6 border-t border-gray-100 dark:border-gray-800">
            <a href="#" class="flex items-center py-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 group">
                <i class="fas fa-cog w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span>Settings</span>
            </a>

            <a href="#" class="flex items-center py-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 group">
                <i class="fas fa-question-circle w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                <span>Help Center</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                @csrf
                <button type="submit" class="flex items-center py-3 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-gray-100 group w-full">
                    <i class="fas fa-right-from-bracket w-5 mr-3 shrink-0 group-hover:text-blue-600"></i>
                    <span>Logout</span>
                </button>
            </form>

            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-800 text-xs text-gray-400">
                <p>© FinBank, 2025</p>
                <p>Created by Jeet Saru</p>
                <a href="#" class="text-blue-600 hover:text-blue-700">Support the designer</a>
            </div>
        </div>
    </aside>

    <!-- Header (FIXED) -->
    <header class="fixed top-0 left-64 right-0 z-30 bg-white dark:bg-gray-950 shadow-sm border-b border-gray-100 dark:border-gray-800">
        <div class="flex items-center justify-between px-8 py-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">@yield('page_title')</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">@yield('page_subtitle')</p>
            </div>

            <div class="flex items-center space-x-4">
                <button id="themeToggle" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                    <i id="themeIcon" class="fas fa-moon text-gray-600 dark:text-gray-200"></i>
                </button>

                <button class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg">
                    <i class="fas fa-bell text-gray-600 dark:text-gray-200"></i>
                </button>

                <!-- Profile Dropdown -->
                <div class="relative">
                    <button id="profileBtn" class="w-10 h-10 rounded-full overflow-hidden focus:outline-none">
                        <img
                            src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'User') }}&background=4F46E5&color=fff"
                            class="w-10 h-10 rounded-full"
                            alt="User"
                        >
                    </button>

                    <div id="profileDropdown"
                         class="hidden absolute right-0 mt-3 w-56 bg-white dark:bg-gray-950 rounded-xl shadow-lg border border-gray-100 dark:border-gray-800 z-50 overflow-hidden">

                        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ auth()->user()->name ?? 'User' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? '-' }}</p>
                        </div>

                        <a href="{{ route('profile.edit') }}"
                           class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-900">
                            <i class="fa-regular fa-user"></i>
                            Edit Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2 px-4 py-3 text-sm text-red-600 hover:bg-gray-50 dark:hover:bg-gray-900">
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
    <main class="ml-64 pt-20 h-screen overflow-y-auto text-gray-900 dark:text-gray-100">
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
    // ===== THEME =====
    const html = document.documentElement;
    const toggle = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');

    function setTheme(theme) {
        localStorage.setItem('theme', theme);
        html.classList.toggle('dark', theme === 'dark');

        if (icon) {
            icon.className = (theme === 'dark')
                ? 'fas fa-sun text-gray-200'
                : 'fas fa-moon text-gray-600';
        }

        console.log('[THEME]', theme, 'html=', html.className);
    }

    setTheme(localStorage.getItem('theme') || 'light');

    toggle?.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const current = localStorage.getItem('theme') || 'light';
        setTheme(current === 'dark' ? 'light' : 'dark');
    });

    // ===== PROFILE DROPDOWN =====
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');

    profileBtn?.addEventListener('click', function (e) {
        e.stopPropagation();
        profileDropdown?.classList.toggle('hidden');
    });

    document.addEventListener('click', function (e) {
        if (!profileDropdown) return;
        if (profileDropdown.contains(e.target)) return;
        if (profileBtn && profileBtn.contains(e.target)) return;
        profileDropdown.classList.add('hidden');
    });
});
</script>

</body>
</html>
