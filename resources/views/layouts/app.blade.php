<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', isset($currentSchool) ? $currentSchool->name : 'SMK Negeri 1')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Tailwind CSS (via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }

        :root {
            --color-brand-primary: {{ $currentSchool->primary_color ?? '#1e3a8a' }};
            --color-brand-secondary: {{ $currentSchool->secondary_color ?? '#3b82f6' }};
        }

        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--color-brand-secondary) 0%, var(--color-brand-primary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bg-gradient-brand {
            background: linear-gradient(135deg, var(--color-brand-primary) 0%, var(--color-brand-secondary) 100%) !important;
        }

        /* Dynamic classes mapping */
        .text-blue-600 {
            color: var(--color-brand-primary) !important;
        }

        .text-blue-700 {
            color: var(--color-brand-primary) !important;
        }

        .text-blue-900 {
            color: var(--color-brand-primary) !important;
        }

        .bg-blue-50 {
            background-color: color-mix(in srgb, var(--color-brand-primary) 8%, transparent) !important;
        }

        .bg-blue-600 {
            background-color: var(--color-brand-primary) !important;
        }

        .bg-blue-700 {
            background-color: var(--color-brand-primary) !important;
        }

        .bg-blue-950 {
            background-color: var(--color-brand-primary) !important;
            filter: brightness(0.7);
        }

        .hover\:bg-blue-50:hover {
            background-color: color-mix(in srgb, var(--color-brand-primary) 8%, transparent) !important;
        }

        .hover\:bg-blue-600:hover {
            background-color: var(--color-brand-primary) !important;
            filter: brightness(1.1);
        }

        .hover\:text-blue-600:hover {
            color: var(--color-brand-primary) !important;
        }

        .hover\:text-blue-750:hover {
            color: var(--color-brand-primary) !important;
            filter: brightness(1.2);
        }

        .hover\:bg-blue-750:hover {
            background-color: var(--color-brand-primary) !important;
            filter: brightness(1.2);
        }

        .border-blue-900 {
            border-color: color-mix(in srgb, var(--color-brand-primary) 20%, transparent) !important;
        }
    </style>
</head>

<body class="flex flex-col h-full text-slate-800 antialiased">

    @php
        $isAlumni =
            request()->routeIs('alumni.home') ||
            request()->routeIs('alumni') ||
            request()->routeIs('alumni.detail') ||
            request()->routeIs('berita*') ||
            request()->routeIs('agenda*') ||
            request()->routeIs('donasi*') ||
            request()->routeIs('karir-bisnis*') ||
            request()->routeIs('galeri*') ||
            request()->routeIs('forum*') ||
            request()->routeIs('dashboard*');

        $resolvedSchoolSlug = isset($currentSchool)
            ? $currentSchool->slug
            : (auth()->check() && auth()->user()->school
                ? auth()->user()->school->slug
                : 'default');
    @endphp

    <!-- Header Navigation -->
    <header class="sticky top-0 z-40 w-full border-b border-slate-100 bg-white/90 backdrop-blur-md">
        <div class="mx-auto flex max-w-7xl h-16 items-center justify-between px-4 sm:px-6 lg:px-8">
            <!-- Brand Logo -->
            <a href="{{ isset($currentSchool) ? route('home', ['school_slug' => $currentSchool->slug]) : route('portal.home') }}"
                class="flex items-center gap-2.5">
                <span
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white font-bold text-lg shadow-md shadow-blue-500/20">
                    <i class="fa-solid fa-graduation-cap"></i>
                </span>
                <div>
                    <span class="block text-base font-bold leading-tight tracking-tight text-blue-900">PORTAL ALUMNI</span>
                    <span
                        class="block text-[10px] text-slate-500 uppercase tracking-widest font-semibold leading-none">{{ $currentSchool->name ?? 'DIREKTORI UTAMA' }}</span>
                </div>
            </a>

            <!-- Desktop Nav -->
            @if (isset($currentSchool))
                <!-- Desktop Alumni Nav -->
                <nav class="hidden lg:flex items-center gap-0.5">
                    <a href="{{ route('home') }}"
                        class="px-2 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">Beranda</a>

                    <a href="{{ route('alumni') }}"
                        class="px-2 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('alumni*') && !request()->routeIs('home') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">Direktori
                        Alumni</a>

                    <!-- Kabar & Informasi Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex items-center gap-1 px-2 py-1.5 text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-slate-50 rounded-lg">
                            Informasi <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </button>
                        <div
                            class="absolute left-0 top-full pt-1 w-48 origin-top-left transition-all opacity-0 scale-95 pointer-events-none group-hover:opacity-100 group-hover:scale-100 group-hover:pointer-events-auto z-50">
                            <div class="rounded-xl bg-white p-1 shadow-lg ring-1 ring-black/5">
                                <a href="{{ route('berita') }}"
                                    class="block px-2.5 py-1.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg">Berita & Kegiatan</a>
                                <a href="{{ route('agenda') }}"
                                    class="block px-2.5 py-1.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg">Agenda Event</a>
                                <a href="{{ route('galeri') }}"
                                    class="block px-2.5 py-1.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg">Galeri Dokumentasi</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('karir-bisnis') }}"
                        class="px-2 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('karir-bisnis*') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">Karir & Bisnis</a>

                    <!-- Komunitas & Sosial Dropdown -->
                    <div class="relative group">
                        <button
                            class="flex items-center gap-1 px-2 py-1.5 text-sm font-medium text-slate-600 hover:text-blue-600 hover:bg-slate-50 rounded-lg">
                            Komunitas <i class="fa-solid fa-chevron-down text-[10px]"></i>
                        </button>
                        <div
                            class="absolute left-0 top-full pt-1 w-48 origin-top-left transition-all opacity-0 scale-95 pointer-events-none group-hover:opacity-100 group-hover:scale-100 group-hover:pointer-events-auto z-50">
                            <div class="rounded-xl bg-white p-1 shadow-lg ring-1 ring-black/5">
                                <a href="{{ route('donasi') }}"
                                    class="block px-2.5 py-1.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg">Penggalangan Donasi</a>
                                <a href="{{ route('forum') }}"
                                    class="block px-2.5 py-1.5 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 rounded-lg">Forum Diskusi</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('profil') }}"
                        class="px-2 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('profil') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">Profil Almamater</a>

                    <a href="{{ route('ikatan-alumni') }}"
                        class="px-2 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('ikatan-alumni') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">Ikatan Alumni</a>

                    <a href="{{ route('kontak') }}"
                        class="px-2 py-1.5 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('kontak') ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:text-blue-600 hover:bg-slate-50' }}">Hubungi Kami</a>
                </nav>
            @else
                <nav class="hidden lg:flex items-center gap-0.5">
                    <a href="{{ route('portal.home') }}"
                        class="px-3 py-1.5 text-sm font-semibold text-blue-600 hover:text-blue-700 hover:bg-slate-50 rounded-lg transition-colors flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Direktori
                    </a>
                </nav>
            @endif

            <!-- Right Actions (Auth Buttons) -->
            <div class="hidden lg:flex items-center gap-2">
                @auth
                    @if (in_array(auth()->user()->role, ['superadmin', 'admin_alumni']))
                        <a href="{{ auth()->user()->role === 'superadmin' ? route('superadmin.dashboard') : route('admin.dashboard', ['school_slug' => $resolvedSchoolSlug]) }}"
                            class="flex items-center gap-1 text-xs font-semibold px-2 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition-colors">
                            <i class="fa-solid fa-lock"></i> Panel Admin
                        </a>
                    @endif

                    <a href="{{ route('dashboard', ['school_slug' => $resolvedSchoolSlug]) }}"
                        class="flex items-center gap-1.5 px-2 py-1 rounded-lg border border-slate-200 text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                        <img src="{{ auth()->user()->foto ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100' }}"
                            alt="avatar" class="w-5 h-5 rounded-full object-cover">
                        <span>{{ Str::before(auth()->user()->name, ' ') }}</span>
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                            class="p-1.5 text-slate-400 hover:text-red-500 rounded-lg transition-colors" title="Keluar">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-blue-600 hover:text-blue-700 px-2 py-1.5">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 px-3 py-1.5 rounded-lg transition-all shadow-md shadow-blue-600/10 hover:shadow-blue-600/20">Daftar</a>
                @endauth
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex items-center lg:hidden gap-3">
                @auth
                    <a href="{{ route('dashboard', ['school_slug' => $resolvedSchoolSlug]) }}"
                        class="w-8 h-8 rounded-full border border-slate-200 overflow-hidden">
                        <img src="{{ auth()->user()->foto ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100' }}"
                            alt="avatar" class="w-full h-full object-cover">
                    </a>
                @endauth
                <button type="button" id="mobile-menu-toggle"
                    class="p-2 text-slate-600 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition-colors">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Dropdown Nav -->
        <div id="mobile-menu"
            class="hidden lg:hidden border-t border-slate-100 bg-white px-4 py-3 space-y-1 shadow-inner">
            @if (isset($currentSchool))
                <!-- Mobile Alumni Nav -->
                <a href="{{ route('home') }}"
                    class="block px-3 py-2 text-base font-medium rounded-lg text-slate-700 hover:bg-slate-50">Beranda</a>

                <a href="{{ route('alumni') }}"
                    class="block px-3 py-2 text-base font-medium rounded-lg text-slate-700 hover:bg-slate-50">Direktori Alumni</a>

                <div class="px-3 py-1 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Informasi</div>
                <a href="{{ route('berita') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Berita & Kegiatan</a>
                <a href="{{ route('agenda') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Agenda Event</a>
                <a href="{{ route('galeri') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Galeri Dokumentasi</a>

                <a href="{{ route('karir-bisnis') }}"
                    class="block px-3 py-2 text-base font-medium rounded-lg text-slate-700 hover:bg-slate-50">Karir & Bisnis</a>

                <div class="px-3 py-1 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Sosial & Komunitas</div>
                <a href="{{ route('donasi') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Penggalangan Donasi</a>
                <a href="{{ route('forum') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Forum Diskusi</a>

                <div class="px-3 py-1 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Lainnya</div>
                <a href="{{ route('profil') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Profil Almamater</a>
                <a href="{{ route('ikatan-alumni') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Ikatan Alumni</a>
                <a href="{{ route('kontak') }}"
                    class="block pl-6 pr-3 py-1.5 text-sm font-medium rounded-lg text-slate-600 hover:bg-slate-50">Hubungi Kami</a>
            @else
                <a href="{{ route('portal.home') }}"
                    class="block px-3 py-2 text-base font-medium rounded-lg text-slate-700 hover:bg-slate-50">Kembali ke Direktori</a>
            @endif

            <div class="border-t border-slate-100 my-2 pt-2 flex flex-col gap-2">
                @auth
                    @if (in_array(auth()->user()->role, ['superadmin', 'admin_alumni']))
                        <a href="{{ auth()->user()->role === 'superadmin' ? route('superadmin.dashboard') : route('admin.dashboard', ['school_slug' => $resolvedSchoolSlug]) }}"
                            class="block text-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold rounded-xl text-sm transition-colors">
                            <i class="fa-solid fa-lock"></i> Panel Admin
                        </a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full text-center px-4 py-2 border border-slate-200 text-slate-600 font-semibold rounded-xl text-sm hover:bg-slate-50">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                        class="block text-center px-4 py-2 border border-slate-200 text-blue-600 font-semibold rounded-xl text-sm hover:bg-slate-50">Masuk</a>
                    <a href="{{ route('register') }}"
                        class="block text-center px-4 py-2 bg-blue-600 text-white font-semibold rounded-xl text-sm hover:bg-blue-750">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-grow">
        <!-- Toast / Alerts -->
        @if (session('success') || session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                @if (session('success'))
                    <div
                        class="flex items-center gap-3 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl text-sm">
                        <i class="fa-solid fa-circle-check text-base text-emerald-500"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('error'))
                    <div
                        class="flex items-center gap-3 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-xl text-sm">
                        <i class="fa-solid fa-triangle-exclamation text-base text-rose-500"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                @endif
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-blue-950 text-slate-400 border-t border-blue-900">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Col 1: About -->
                <div class="space-y-4">
                    <div class="flex items-center gap-2 text-white">
                        <span
                            class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600 text-white font-bold text-base">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                        <span
                            class="text-lg font-bold tracking-tight text-white">{{ $currentSchool->name ?? 'SMK NEGERI 1' }}</span>
                    </div>
                    <p class="text-sm leading-relaxed text-slate-400">
                        {{ $currentSchool->welcome_headmaster ?? 'Pusat pendidikan vokasi kejuruan terbaik yang mencetak SDM unggul siap kerja global dengan bekal IMTAK dan IPTEK.' }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Layanan</h3>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('alumni.home') }}" class="hover:text-white transition-colors">Portal
                                Alumni</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact -->
                <div>
                    <h3 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">Hubungi Kami</h3>
                    <ul class="space-y-3 text-sm">
                        <li class="flex gap-2">
                            <i class="fa-solid fa-location-dot mt-1 text-blue-500"></i>
                            <span>{{ $currentSchool->address ?? 'Jl. Pendidikan No. 45, Kota Raya, 12345' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                            <span>{{ $currentSchool->phone ?? '+62 812-3456-7890' }}</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <i class="fa-solid fa-envelope text-blue-500"></i>
                            <span>{{ $currentSchool->email ?? 'info@school.sch.id' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-blue-900 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500">&copy; {{ date('Y') }}
                    {{ $currentSchool->name ?? 'SMK Negeri 1' }}. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-4 text-slate-500">
                    <a href="#" class="hover:text-blue-500 transition-colors"><i
                            class="fa-brands fa-facebook text-lg"></i></a>
                    <a href="#" class="hover:text-sky-500 transition-colors"><i
                            class="fa-brands fa-twitter text-lg"></i></a>
                    <a href="#" class="hover:text-pink-500 transition-colors"><i
                            class="fa-brands fa-instagram text-lg"></i></a>
                    <a href="#" class="hover:text-red-500 transition-colors"><i
                            class="fa-brands fa-youtube text-lg"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script Toggle -->
    <script>
        document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
            var menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>
</body>

</html>
