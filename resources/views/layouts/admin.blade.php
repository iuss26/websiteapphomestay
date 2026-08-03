<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Teras Abah Homestay</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@600;700;800&family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <!-- Material Symbols Outlined -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0..1,0" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fb;
            color: #191c1e;
        }
        .font-display {
            font-family: 'Hanken Grotesk', sans-serif;
        }
        .font-mono-custom {
            font-family: 'JetBrains Mono', monospace;
        }
        .status-bar {
            height: 4px;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-[#f7f9fb] text-[#191c1e] antialiased flex min-h-screen" x-data="{ sidebarOpen: false }">
    
    <!-- Sidebar Overlay for Mobile -->
    <div x-show="sidebarOpen" x-transition.opacity class="fixed inset-0 z-40 bg-black/50 lg:hidden" @click="sidebarOpen = false" x-cloak></div>

    <!-- Desktop Navigation Drawer (Stitch Sidebar Design) -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="h-full w-72 fixed left-0 top-0 bg-white border-r border-[#c6c6cd] p-4 z-50 flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0">
        <div class="flex items-center justify-between mb-6 px-2 py-2">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#131b2e] flex items-center justify-center text-white font-bold text-sm shadow">
                    TA
                </div>
                <div>
                    <h1 class="font-display text-[18px] leading-[24px] text-[#000000] font-bold">
                        Teras Abah
                    </h1>
                    <p class="text-[12px] leading-[16px] text-[#45464d]">
                        Homestay Admin
                    </p>
                </div>
            </div>
            <button @click="sidebarOpen = false" class="lg:hidden text-gray-500 hover:text-black">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <nav class="flex flex-col gap-1.5 flex-1">
            <a href="{{ route('admin.rooms.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-left transition-all {{ request()->routeIs('admin.rooms.*') ? 'bg-[#2170e4] text-white font-bold border-l-4 border-[#0058be] shadow-sm' : 'text-[#45464d] hover:bg-[#f2f4f6]' }}">
                <span class="material-symbols-outlined">bed</span>
                <span class="text-[14px]">Manajemen Kamar</span>
            </a>

            <a href="{{ route('admin.reservations.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-left transition-all {{ request()->routeIs('admin.reservations.*') ? 'bg-[#2170e4] text-white font-bold border-l-4 border-[#0058be] shadow-sm' : 'text-[#45464d] hover:bg-[#f2f4f6]' }}">
                <span class="material-symbols-outlined">calendar_month</span>
                <span class="text-[14px]">Reservasi</span>
            </a>

            <a href="{{ route('admin.guests.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-left transition-all {{ request()->routeIs('admin.guests.*') ? 'bg-[#2170e4] text-white font-bold border-l-4 border-[#0058be] shadow-sm' : 'text-[#45464d] hover:bg-[#f2f4f6]' }}">
                <span class="material-symbols-outlined">group</span>
                <span class="text-[14px]">Data Tamu</span>
            </a>

            <a href="{{ route('admin.expenses.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-left transition-all {{ request()->routeIs('admin.expenses.*') ? 'bg-[#2170e4] text-white font-bold border-l-4 border-[#0058be] shadow-sm' : 'text-[#45464d] hover:bg-[#f2f4f6]' }}">
                <span class="material-symbols-outlined">payments</span>
                <span class="text-[14px]">Pengeluaran</span>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3.5 px-4 py-3 rounded-xl text-left transition-all {{ request()->routeIs('admin.reports.*') ? 'bg-[#2170e4] text-white font-bold border-l-4 border-[#0058be] shadow-sm' : 'text-[#45464d] hover:bg-[#f2f4f6]' }}">
                <span class="material-symbols-outlined">analytics</span>
                <span class="text-[14px]">Laporan Keuangan</span>
            </a>

            <div class="pt-4 mt-2 border-t border-[#e2e4e8]">
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 px-4 py-2.5 rounded-xl text-[#76777d] hover:bg-[#f2f4f6] hover:text-black transition-all text-sm">
                    <span class="material-symbols-outlined text-[20px]">storefront</span>
                    <span>Ke Website Utama</span>
                </a>
            </div>
        </nav>

        <div class="mt-auto pt-4 border-t border-[#c6c6cd] flex items-center justify-between px-2">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-[#131b2e] text-white flex items-center justify-center font-bold text-xs">
                    AD
                </div>
                <div>
                    <p class="text-[14px] font-semibold text-[#191c1e]">Admin Teras Abah</p>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-[12px] text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Workspace Area -->
    <div class="lg:pl-72 flex-1 flex flex-col min-w-0 pb-16 lg:pb-0">
        <!-- Top App Bar -->
        <header class="w-full sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-[#c6c6cd] shadow-sm">
            <div class="flex items-center justify-between px-4 sm:px-6 py-3.5 max-w-[1440px] mx-auto">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-700">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="font-display text-[18px] sm:text-[20px] leading-[28px] text-[#000000] font-semibold truncate">
                        @yield('title', 'Admin Dashboard')
                    </h2>
                </div>

                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-2 px-3 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold border border-green-200">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Hostinger Online
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Body -->
        <main class="p-4 sm:p-6 lg:p-8 max-w-[1440px] w-full mx-auto">
            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3.5 rounded-xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                    <span class="text-sm font-semibold">{{ session('success') }}</span>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3.5 rounded-xl flex items-center gap-3 shadow-sm">
                    <span class="material-symbols-outlined text-red-600">error</span>
                    <span class="text-sm font-semibold">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Mobile Bottom Navigation Bar (Stitch Design) -->
    <nav class="fixed bottom-0 left-0 w-full z-40 lg:hidden flex justify-around items-center px-2 py-2 bg-white border-t border-[#c6c6cd] shadow-lg">
        <a href="{{ route('admin.rooms.index') }}" class="flex flex-col items-center justify-center px-3 py-1 text-xs font-medium {{ request()->routeIs('admin.rooms.*') ? 'text-[#2170e4] font-bold' : 'text-[#45464d]' }}">
            <span class="material-symbols-outlined">bed</span>
            <span class="font-mono-custom text-[10px]">Kamar</span>
        </a>

        <a href="{{ route('admin.reservations.index') }}" class="flex flex-col items-center justify-center px-3 py-1 text-xs font-medium {{ request()->routeIs('admin.reservations.*') ? 'text-[#2170e4] font-bold' : 'text-[#45464d]' }}">
            <span class="material-symbols-outlined">calendar_month</span>
            <span class="font-mono-custom text-[10px]">Reservasi</span>
        </a>

        <a href="{{ route('admin.guests.index') }}" class="flex flex-col items-center justify-center px-3 py-1 text-xs font-medium {{ request()->routeIs('admin.guests.*') ? 'text-[#2170e4] font-bold' : 'text-[#45464d]' }}">
            <span class="material-symbols-outlined">group</span>
            <span class="font-mono-custom text-[10px]">Tamu</span>
        </a>

        <a href="{{ route('admin.expenses.index') }}" class="flex flex-col items-center justify-center px-3 py-1 text-xs font-medium {{ request()->routeIs('admin.expenses.*') ? 'text-[#2170e4] font-bold' : 'text-[#45464d]' }}">
            <span class="material-symbols-outlined">payments</span>
            <span class="font-mono-custom text-[10px]">Biaya</span>
        </a>

        <a href="{{ route('admin.reports.index') }}" class="flex flex-col items-center justify-center px-3 py-1 text-xs font-medium {{ request()->routeIs('admin.reports.*') ? 'text-[#2170e4] font-bold' : 'text-[#45464d]' }}">
            <span class="material-symbols-outlined">analytics</span>
            <span class="font-mono-custom text-[10px]">Laporan</span>
        </a>
    </nav>

</body>
</html>
