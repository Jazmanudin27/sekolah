<!DOCTYPE html>
<html lang="id" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Console - Portal Alumni Sekolah')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f4f6fa;
        }

        .admin-sidebar {
            width: 260px;
            background: linear-gradient(180deg, #005cff 0%, #0039a6 100%);
            min-height: 100vh;
            color: #ffffff;
            transition: all 0.3s;
        }

        .admin-sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            font-weight: 600;
            font-size: 0.85rem;
            padding: 0.6rem 0.85rem;
            border-radius: 0.6rem;
            margin-bottom: 0.15rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.2s;
        }

        .admin-sidebar .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(3px);
        }

        .admin-sidebar .nav-link.active {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .admin-sidebar-brand {
            height: 64px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.12);
        }

        .admin-sidebar-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            background-color: rgba(0, 0, 0, 0.15);
        }

        .main-wrapper {
            min-width: 0;
            overflow-x: hidden;
        }

        /* Premium UI Elements */
        .card-custom {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            background: #ffffff;
            transition: all 0.2s ease-in-out;
        }

        .card-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px -2px rgba(0, 0, 0, 0.08);
        }

        .table-custom {
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table-custom tr {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 2px 8px -2px rgba(0, 0, 0, 0.02);
        }

        .table-custom td,
        .table-custom th {
            padding: 1rem;
            border: none;
        }

        .table-custom tr:hover {
            background-color: #f8fafc;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #005cff;
            box-shadow: 0 0 0 0.25rem rgba(0, 92, 255, 0.12);
        }

        .admin-sidebar .nav-link[aria-expanded="true"] .toggle-icon {
            transform: rotate(180deg);
        }

        .admin-sidebar .nav-link .toggle-icon {
            transition: transform 0.2s;
        }

        /* Fallbacks for collapse/dropdown visibility */
        .collapse:not(.show) {
            display: none !important;
        }

        .collapse.show {
            display: block !important;
        }

        .dropdown-menu.show {
            display: block !important;
        }

        /* Mobile styles */
        @media (max-width: 767.98px) {
            .admin-sidebar {
                margin-left: -260px;
                position: fixed;
                z-index: 1040;
                height: 100vh;
            }

            .admin-sidebar.show {
                margin-left: 0;
            }

            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: rgba(0, 0, 0, 0.4);
                backdrop-filter: blur(4px);
                z-index: 1030;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body class="h-100 overflow-hidden">
    @php
        $isSuperRoute = request()->routeIs('superadmin.*');
        $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
        $currentSchoolName = isset($currentSchool) ? $currentSchool->name : 'SUPER ADMIN';
    @endphp

    <!-- Sidebar Overlay for mobile screen -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="d-flex h-100">

        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar d-flex flex-column flex-shrink-0" id="admin-sidebar">
            <!-- Brand -->
            <div class="admin-sidebar-brand d-flex align-items-center px-4 gap-2">
                <span class="d-flex align-items-center justify-content-center bg-white rounded-3 text-primary shadow-sm"
                    style="width: 36px; height: 36px;">
                    <i class="fa-solid fa-graduation-cap fs-5"></i>
                </span>
                <div>
                    <h6 class="m-0 font-weight-bold text-white leading-none"
                        style="font-size: 0.9rem; font-weight: 800; letter-spacing: -0.5px;">{{ $isSuperRoute ? 'SYSTEM ERP' : $currentSchoolName }}</h6>
                    <small class="text-white-50 uppercase tracking-widest font-semibold"
                        style="font-size: 0.6rem; display: block; letter-spacing: 1px; font-weight: 700;">{{ $isSuperRoute ? 'Super Admin' : 'Admin Console' }}</small>
                </div>
                <!-- Close btn for mobile only -->
                <button type="button" class="btn btn-close btn-close-white ms-auto d-md-none" id="mobile-close-btn"
                    aria-label="Close"></button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-grow-1 overflow-y-auto px-2 py-3">
                <ul class="nav nav-pills flex-column">
                    @if (auth()->user()->role === 'superadmin')
                        <li class="nav-item">
                            <a href="{{ route('superadmin.schools') }}"
                                class="nav-link {{ request()->routeIs('superadmin.schools') ? 'active' : '' }}">
                                <i class="fa-solid fa-server fs-6"></i>
                                <span>Kelola Sekolah</span>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{ route($routePrefix . 'dashboard') }}"
                            class="nav-link {{ request()->routeIs($routePrefix . 'dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-chart-pie fs-6"></i>
                            <span>Statistik Utama</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route($routePrefix . 'alumni') }}"
                            class="nav-link {{ request()->routeIs($routePrefix . 'alumni') ? 'active' : '' }}">
                            <i class="fa-solid fa-users fs-6"></i>
                            <span>Master Data Alumni</span>
                        </a>
                    </li>
                    
                    <!-- Akademik & PPDB Group -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs($routePrefix . 'siswa', $routePrefix . 'guru', $routePrefix . 'ppdb') ? 'active' : '' }}"
                            data-manual-toggle="collapse" href="#collapseSchoolAkademik" role="button"
                            aria-expanded="{{ request()->routeIs($routePrefix . 'siswa', $routePrefix . 'guru', $routePrefix . 'ppdb') ? 'true' : 'false' }}"
                            aria-controls="collapseSchoolAkademik">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-school fs-6"></i>
                                <span>Akademik & PPDB</span>
                            </div>
                            <i class="fa-solid fa-chevron-down toggle-icon" style="font-size: 0.65rem;"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs($routePrefix . 'siswa', $routePrefix . 'guru', $routePrefix . 'ppdb') ? 'show' : '' }}"
                            id="collapseSchoolAkademik">
                            <ul class="nav flex-column ms-2 mt-0 ps-2 border-start border-white-10">
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'siswa') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'siswa') ? 'active' : '' }}">
                                        <i class="fa-solid fa-user-graduate fs-7"></i>
                                        <span>Kelola Siswa</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'guru') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'guru') ? 'active' : '' }}">
                                        <i class="fa-solid fa-chalkboard-user fs-7"></i>
                                        <span>Kelola Guru</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'ppdb') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'ppdb') ? 'active' : '' }}">
                                        <i class="fa-solid fa-clipboard-list fs-7"></i>
                                        <span>Verifikasi PPDB</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Profil & Fasilitas Group -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs($routePrefix . 'fasilitas', $routePrefix . 'ekstrakurikuler', $routePrefix . 'prestasi') ? 'active' : '' }}"
                            data-manual-toggle="collapse" href="#collapseSchoolProfil" role="button"
                            aria-expanded="{{ request()->routeIs($routePrefix . 'fasilitas', $routePrefix . 'ekstrakurikuler', $routePrefix . 'prestasi') ? 'true' : 'false' }}"
                            aria-controls="collapseSchoolProfil">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-building-columns fs-6"></i>
                                <span>Profil & Fasilitas</span>
                            </div>
                            <i class="fa-solid fa-chevron-down toggle-icon" style="font-size: 0.65rem;"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs($routePrefix . 'fasilitas', $routePrefix . 'ekstrakurikuler', $routePrefix . 'prestasi') ? 'show' : '' }}"
                            id="collapseSchoolProfil">
                            <ul class="nav flex-column ms-2 mt-0 ps-2 border-start border-white-10">
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'fasilitas') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'fasilitas') ? 'active' : '' }}">
                                        <i class="fa-solid fa-school-flag fs-7"></i>
                                        <span>Kelola Fasilitas</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'ekstrakurikuler') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'ekstrakurikuler') ? 'active' : '' }}">
                                        <i class="fa-solid fa-people-group fs-7"></i>
                                        <span>Kelola Ekstra</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'prestasi') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'prestasi') ? 'active' : '' }}">
                                        <i class="fa-solid fa-trophy fs-7"></i>
                                        <span>Kelola Prestasi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Akademik & Informasi Group -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs($routePrefix . 'berita', $routePrefix . 'event', $routePrefix . 'galeri') ? 'active' : '' }}"
                            data-manual-toggle="collapse" href="#collapseAkademik" role="button"
                            aria-expanded="{{ request()->routeIs($routePrefix . 'berita', $routePrefix . 'event', $routePrefix . 'galeri') ? 'true' : 'false' }}"
                            aria-controls="collapseAkademik">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-graduation-cap fs-6"></i>
                                <span>Akademik & Info</span>
                            </div>
                            <i class="fa-solid fa-chevron-down toggle-icon" style="font-size: 0.65rem;"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs($routePrefix . 'berita', $routePrefix . 'event', $routePrefix . 'galeri') ? 'show' : '' }}"
                            id="collapseAkademik">
                            <ul class="nav flex-column ms-2 mt-0 ps-2 border-start border-white-10">
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'berita') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'berita') ? 'active' : '' }}">
                                        <i class="fa-solid fa-newspaper fs-7"></i>
                                        <span>Kelola Berita</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'event') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'event') ? 'active' : '' }}">
                                        <i class="fa-solid fa-calendar-days fs-7"></i>
                                        <span>Kelola Agenda</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'galeri') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'galeri') ? 'active' : '' }}">
                                        <i class="fa-solid fa-camera fs-7"></i>
                                        <span>Kelola Galeri</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Sosial & Donasi Group -->
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center justify-content-between {{ request()->routeIs($routePrefix . 'donasi') ? 'active' : '' }}"
                            data-manual-toggle="collapse" href="#collapseSosial" role="button"
                            aria-expanded="{{ request()->routeIs($routePrefix . 'donasi') ? 'true' : 'false' }}"
                            aria-controls="collapseSosial">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-handshake-angle fs-6"></i>
                                <span>Sosial & Donasi</span>
                            </div>
                            <i class="fa-solid fa-chevron-down toggle-icon" style="font-size: 0.65rem;"></i>
                        </a>
                        <div class="collapse {{ request()->routeIs($routePrefix . 'donasi') ? 'show' : '' }}"
                            id="collapseSosial">
                            <ul class="nav flex-column ms-2 mt-0 ps-2 border-start border-white-10">
                                <li class="nav-item">
                                    <a href="{{ route($routePrefix . 'donasi') }}"
                                        class="nav-link py-2 {{ request()->routeIs($routePrefix . 'donasi') ? 'active' : '' }}">
                                        <i class="fa-solid fa-hand-holding-dollar fs-7"></i>
                                        <span>Kelola Donasi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <hr class="text-white-50 my-3">
                    </li>

                    <li class="nav-item">
                        <a href="{{ $isSuperRoute ? route('portal.home') : route('home') }}" class="nav-link">
                            <i class="fa-solid fa-globe fs-6"></i>
                            <span>{{ $isSuperRoute ? 'Ke Direktori Utama' : 'Ke Website Utama' }}</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- User Profile Footer -->
            <div class="admin-sidebar-footer p-3 d-flex align-items-center gap-3">
                <img src="{{ auth()->user()->foto ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100' }}"
                    alt="avatar" class="rounded-2 object-cover border border-white-50"
                    style="width: 36px; height: 36px;">
                <div class="min-w-0 flex-grow-1">
                    <p class="m-0 font-weight-bold text-white text-truncate"
                        style="font-size: 0.8rem; font-weight: 700;">{{ auth()->user()->name }}</p>
                    <small class="text-white-50 uppercase"
                        style="font-size: 0.65rem; font-weight: 600;">Administrator</small>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="main-wrapper d-flex flex-column flex-grow-1 h-100 overflow-hidden">
            <!-- Top Navbar Header -->
            <header class="d-flex align-items-center justify-content-between px-4 bg-white border-bottom flex-shrink-0"
                style="height: 64px;">
                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn btn-outline-secondary btn-sm d-md-none" id="mobile-toggle-btn">
                        <i class="fa-solid fa-bars fs-5"></i>
                    </button>
                    <h5 class="m-0 font-weight-bold text-dark tracking-tight"
                        style="font-size: 1rem; font-weight: 700;">Console Management</h5>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <div class="dropdown">
                        <button
                            class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2 p-0 border-0"
                            type="button" id="userProfileDropdown" data-manual-toggle="dropdown"
                            aria-expanded="false">
                            <img src="{{ auth()->user()->foto ?? 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100' }}"
                                alt="avatar" class="rounded-circle object-cover border"
                                style="width: 32px; height: 32px;">
                            <span class="text-dark font-weight-bold d-none d-sm-inline"
                                style="font-size: 0.85rem; font-weight: 600;">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm rounded-3 mt-2 border-0"
                            aria-labelledby="userProfileDropdown" style="font-size: 0.8rem;">
                            <li class="px-3 py-2 border-bottom">
                                <div class="font-weight-bold text-dark text-truncate" style="font-weight: 700;">
                                    {{ auth()->user()->name }}</div>
                                <small
                                    class="text-secondary text-truncate d-block">{{ auth()->user()->email }}</small>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2"
                                    href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-user-gear text-secondary"></i> Member Panel
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 d-flex align-items-center gap-2"
                                    href="{{ route('home') }}">
                                    <i class="fa-solid fa-globe text-secondary"></i> Ke Website Utama
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider my-1">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="dropdown-item py-2 text-danger d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Main Content Scroll -->
            <main class="flex-grow-1 overflow-y-auto p-4 p-lg-5">
                <!-- Toast / Alerts -->
                @if (session('success') || session('error'))
                    <div class="container-fluid p-0 mb-4">
                        @if (session('success'))
                            <div class="alert alert-success d-flex align-items-center gap-2 rounded-3 border-0 py-3 shadow-sm"
                                role="alert" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                <div class="text-success-emphasis font-semibold">{{ session('success') }}</div>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center gap-2 rounded-3 border-0 py-3 shadow-sm"
                                role="alert" style="font-size: 0.8rem;">
                                <i class="fa-solid fa-triangle-exclamation text-danger fs-5"></i>
                                <div class="text-danger-emphasis font-semibold">{{ session('error') }}</div>
                            </div>
                        @endif
                    </div>
                @endif

                @yield('content')
            </main>
        </div>

    </div>

    <!-- jQuery and Bootstrap Bundle JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Sidebar Toggle Script with jQuery -->
    <script>
        $(document).ready(function() {
            // Open mobile sidebar
            $('#mobile-toggle-btn').on('click', function() {
                $('#admin-sidebar').addClass('show');
                $('#sidebar-overlay').addClass('show');
            });

            // Close mobile sidebar
            $('#mobile-close-btn, #sidebar-overlay').on('click', function() {
                $('#admin-sidebar').removeClass('show');
                $('#sidebar-overlay').removeClass('show');
            });

            // Custom manual toggle for profile dropdown
            $('[data-manual-toggle="dropdown"]').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).next('.dropdown-menu').toggleClass('show');
            });

            // Close dropdown menus when clicking elsewhere
            $(document).on('click', function() {
                $('.dropdown-menu').removeClass('show');
            });

            // Custom manual toggle for collapsible sidebar groups
            $('[data-manual-toggle="collapse"]').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var target = $(this).attr('href');
                var $target = $(target);

                // Toggle show class
                $target.toggleClass('show');

                // Toggle aria-expanded
                var expanded = $(this).attr('aria-expanded') === 'true';
                $(this).attr('aria-expanded', !expanded);
            });
        });
    </script>
</body>

</html>
