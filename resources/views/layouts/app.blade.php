<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teras Abah Homestay - Reservasi Online Dekat Pantai Anyer</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Google Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0..1,0" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-smoothing: antialiased;
            overflow: hidden;
            vertical-align: middle;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased flex flex-col min-h-screen">
    
    <!-- Navbar (Clean Blue & White) -->
    <header class="bg-white/95 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50 transition-all duration-300" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Brand Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Teras Abah Logo" class="h-11 w-auto rounded-lg shadow-sm">
                        <div>
                            <span class="text-xl font-extrabold text-blue-900 tracking-tight block">Teras Abah</span>
                            <span class="text-[11px] font-bold text-blue-600 uppercase tracking-widest block -mt-1">Homestay Anyer</span>
                        </div>
                    </a>
                </div>
                
                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-blue-900 hover:text-blue-600 font-bold text-sm transition-colors">Beranda</a>
                    <a href="{{ route('rooms.index') }}" class="text-slate-600 hover:text-blue-600 font-semibold text-sm transition-colors">Daftar Kamar</a>
                    <a href="{{ route('home') }}#about" class="text-slate-600 hover:text-blue-600 font-semibold text-sm transition-colors">Tentang Kami</a>
                    <a href="{{ route('rooms.index') }}" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md transition-transform active:scale-95 flex items-center gap-2">
                        <span class="material-symbols-outlined text-lg">calendar_month</span>
                        <span>Cari Kamar</span>
                    </a>
                </nav>

                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-700 hover:text-blue-600 focus:outline-none p-2">
                        <span class="material-symbols-outlined text-2xl" x-show="!mobileMenuOpen">menu</span>
                        <span class="material-symbols-outlined text-2xl" x-show="mobileMenuOpen" x-cloak>close</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav Menu -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-white border-t border-slate-200 shadow-xl">
            <div class="px-4 pt-3 pb-6 space-y-3">
                <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-xl text-base font-bold text-blue-900 hover:bg-blue-50">Beranda</a>
                <a href="{{ route('rooms.index') }}" class="block px-3 py-2.5 rounded-xl text-base font-semibold text-slate-700 hover:bg-blue-50">Daftar Kamar</a>
                <a href="{{ route('rooms.index') }}" class="block text-center px-4 py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md">Cari Kamar Sekarang</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer (Clean Modern Blue) -->
    <footer class="bg-blue-950 text-slate-300 pt-16 pb-12 border-t border-blue-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10 pb-12 border-b border-blue-900/60">
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-auto bg-white p-1 rounded-lg">
                        <span class="text-2xl font-extrabold text-white">Teras Abah Homestay</span>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                        Penginapan bersih, nyaman, dan tenang dekat Pantai Anyer. Hanya 5 menit menuju pantai utama, tempat sempurna untuk liburan keluarga & rombongan.
                    </p>
                </div>

                <div>
                    <h5 class="text-base font-bold text-white mb-4">Navigasi</h5>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="{{ route('rooms.index') }}" class="hover:text-white transition">Daftar Kamar</a></li>
                        <li><a href="{{ route('admin.rooms.index') }}" class="hover:text-white transition">Admin Panel</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="text-base font-bold text-white mb-4">Kontak & Lokasi</h5>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Kawasan Pantai Anyer, Serang, Banten.<br>
                        WhatsApp: <a href="https://wa.me/6282123369949" target="_blank" class="text-green-400 font-bold hover:underline">0821-2336-9949</a>
                    </p>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row justify-between items-center text-xs text-slate-400 gap-4">
                <p>&copy; {{ date('Y') }} Teras Abah Homestay. Hak Cipta Dilindungi.</p>
                <a href="{{ route('admin.rooms.index') }}" class="hover:text-white transition text-slate-500">Login Admin</a>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6282123369949?text=Halo%20Teras%20Abah%20Homestay,%20saya%20ingin%20tanya%20mengenai%20reservasi%20kamar." target="_blank" class="fixed bottom-6 right-6 z-50 bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-full shadow-2xl flex items-center gap-2 font-bold text-sm transition-transform hover:scale-105 active:scale-95 border-2 border-white">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-1.099 4.017 4.042-1.058zm12.012-7.003c-.315-.158-1.86-.918-2.149-1.023-.289-.105-.499-.158-.709.158-.21.315-.814 1.023-.997 1.233-.183.21-.367.236-.682.079-.315-.158-1.33-.49-2.534-1.564-.937-.836-1.569-1.869-1.753-2.184-.183-.315-.02-.485.138-.642.142-.141.315-.367.472-.551.157-.183.21-.315.315-.525.105-.21.053-.394-.026-.551-.079-.158-.709-1.706-.971-2.336-.256-.615-.516-.531-.709-.54-.183-.009-.394-.009-.604-.009-.21 0-.551.079-.84.394-.289.315-1.102 1.076-1.102 2.624 0 1.548 1.128 3.047 1.285 3.257.158.21 2.221 3.391 5.381 4.756.752.325 1.339.519 1.797.665.755.241 1.442.207 1.984.126.604-.09 1.86-.761 2.122-1.496.262-.735.262-1.365.183-1.496-.078-.131-.289-.21-.604-.368z"/></svg>
        <span>Chat WA Admin</span>
    </a>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @stack('scripts')
</body>
</html>
