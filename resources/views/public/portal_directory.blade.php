<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direktori Sekolah & Alumni Portal - ERP SMKN 1 & SMAN 2</title>

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
    </style>
</head>

<body class="flex flex-col h-full text-slate-100 antialiased overflow-x-hidden">
    <!-- Glowing background elements -->
    <div
        class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/10 rounded-full blur-[120px] pointer-events-none">
    </div>
    <div
        class="absolute bottom-0 right-1/4 w-[600px] h-[600px] bg-emerald-600/10 rounded-full blur-[140px] pointer-events-none">
    </div>

    <!-- Main Container -->
    <main class="flex-grow flex flex-col justify-center py-16 px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="max-w-5xl mx-auto w-full text-center mb-16">
            <!-- Badging -->
            <span
                class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-500/10 text-blue-400 border border-blue-500/20 mb-6">
                <i class="fa-solid fa-server text-[10px]"></i> School ERP & Multi-Tenant Portal
            </span>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-white mb-6">
                Pilih Portal <span
                    class="bg-gradient-to-r from-blue-400 to-emerald-400 bg-clip-text text-transparent">Sekolah
                    Anda</span>
            </h1>
            <p class="text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Selamat datang di platform ERP Manajemen Sekolah dan Ikatan Alumni Terintegrasi. Pilih sekolah di bawah
                ini untuk mengakses Halaman Utama maupun Portal Alumni masing-masing.
            </p>
        </div>

        <!-- School Cards Grid -->
        <div class="max-w-4xl mx-auto w-full grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            @foreach ($schools as $school)
                @php
                    // Dynamic accent borders and colors depending on theme
                    $isSmk = $school->slug === 'smkn1';
                    $accentColor = $isSmk
                        ? 'border-blue-500/30 hover:border-blue-500/80 shadow-blue-500/5'
                        : 'border-emerald-500/30 hover:border-emerald-500/80 shadow-emerald-500/5';
                    $btnColor = $isSmk
                        ? 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20'
                        : 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/20';
                    $badgeBg = $isSmk ? 'bg-blue-500/10 text-blue-400' : 'bg-emerald-500/10 text-emerald-400';
                    $iconColor = $isSmk ? 'text-blue-500' : 'text-emerald-500';
                @endphp

                <div
                    class="relative group bg-slate-800/50 backdrop-blur-md rounded-3xl p-8 border {{ $accentColor }} transition-all duration-300 hover:-translate-y-1 shadow-2xl flex flex-col justify-between">
                    <div>
                        <!-- Header Card -->
                        <div class="flex items-center justify-between mb-6">
                            <span
                                class="flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-800 text-white font-bold text-2xl border border-slate-700 shadow-lg">
                                <i class="fa-solid fa-school {{ $iconColor }}"></i>
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $badgeBg }}">
                                {{ strtoupper($school->slug) }}
                            </span>
                        </div>

                        <!-- Info -->
                        <h2
                            class="text-2xl font-bold text-white mb-2 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-white group-hover:to-slate-300 transition-colors">
                            {{ $school->name }}
                        </h2>
                        <p class="text-sm text-slate-400 mb-6 line-clamp-2">
                            {{ $school->welcome_headmaster ?? 'Mencetak generasi unggul yang berkarakter mulia dan siap mengabdi pada bangsa.' }}
                        </p>

                        <!-- Stats counters -->
                        <div
                            class="grid grid-cols-3 gap-2 bg-slate-900/50 rounded-2xl p-4 border border-slate-700/50 mb-8">
                            <div class="text-center">
                                <span class="block text-lg font-bold text-white">{{ $school->students_count }}</span>
                                <span
                                    class="text-[10px] uppercase text-slate-500 font-semibold tracking-wider">Siswa</span>
                            </div>
                            <div class="text-center border-x border-slate-700/50">
                                <span class="block text-lg font-bold text-white">{{ $school->teachers_count }}</span>
                                <span
                                    class="text-[10px] uppercase text-slate-500 font-semibold tracking-wider">Guru</span>
                            </div>
                            <div class="text-center">
                                <span class="block text-lg font-bold text-white">{{ $school->users_count }}</span>
                                <span
                                    class="text-[10px] uppercase text-slate-500 font-semibold tracking-wider">Alumni</span>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col gap-3">
                        @php
                            $baseHost = request()->getHost();
                            foreach($schools as $s) {
                                if (str_starts_with($baseHost, $s->slug . '.')) {
                                    $baseHost = substr($baseHost, strlen($s->slug . '.'));
                                    break;
                                }
                            }
                            $schoolUrl = '//' . $school->slug . '.' . $baseHost . (request()->getPort() ? ':' . request()->getPort() : '');
                        @endphp
                        <a href="{{ $schoolUrl }}"
                            class="w-full text-center py-3 px-4 rounded-xl text-sm font-semibold text-white {{ $btnColor }} transition-all shadow-lg hover:shadow-xl">
                            Masuk Portal Alumni
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Superadmin Access Point -->
        <div class="text-center">
            @auth
                @if (auth()->user()->role === 'superadmin')
                    <a href="{{ route('superadmin.dashboard') }}"
                        class="inline-flex items-center gap-2 text-sm text-blue-400 hover:text-blue-300 font-medium transition-colors">
                        <i class="fa-solid fa-lock"></i> Masuk Panel Super Admin ERP
                    </a>
                @else
                    <span class="text-slate-500 text-sm">
                        Anda masuk sebagai <strong class="text-white">{{ auth()->user()->name }}</strong>
                    </span>
                @endif
            @else
                <div class="d-flex flex-wrap justify-content-center align-items-center gap-3">
                    <span class="text-sm text-slate-500"><i class="fa-solid fa-circle-info"></i> Login Admin:</span>
                    @foreach ($schools as $school)
                        @php
                            $schoolLoginUrl = '//' . $school->slug . '.' . $baseHost . (request()->getPort() ? ':' . request()->getPort() : '') . '/login';
                        @endphp
                        <a href="{{ $schoolLoginUrl }}"
                            class="px-3.5 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white border border-slate-700 rounded-xl text-xs font-semibold transition-colors">
                            {{ $school->name }}
                        </a>
                    @endforeach
                </div>
            @endauth
        </div>
    </main>

    <footer class="py-8 text-center text-slate-600 text-xs border-t border-slate-800/50 bg-slate-950/20">
        &copy; {{ date('Y') }} School ERP Multi-Tenant System. All rights reserved.
    </footer>
</body>

</html>
