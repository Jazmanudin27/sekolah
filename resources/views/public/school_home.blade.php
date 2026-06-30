@extends('layouts.app')

@section('title', 'SMK Negeri 1 - Cerdas, Terampil, Berkarakter')

@section('content')
<!-- Hero Section / Banner -->
<section class="relative bg-gradient-brand text-white overflow-hidden py-24 md:py-32">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/25 border border-blue-400/20 text-xs font-semibold uppercase tracking-wider text-blue-200">
                    <span class="h-2 w-2 rounded-full bg-blue-450 animate-ping"></span>
                    SMK Pusat Keunggulan (Center of Excellence)
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    Unggul, Cerdas & <br>
                    <span class="text-blue-300">Siap Kerja Industri</span>
                </h1>
                <p class="text-base sm:text-lg text-blue-100 max-w-xl leading-relaxed">
                    Selamat datang di website resmi SMK Negeri 1. Kami mendidik generasi bertalenta siap kerja di era digital dengan integritas, karakter mulia, dan kompetensi unggul.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('ppdb') }}" class="px-6 py-3.5 bg-white text-blue-900 hover:bg-slate-100 font-bold rounded-xl shadow-lg transition-all flex items-center gap-2">
                        <i class="fa-solid fa-file-signature"></i> Pendaftaran PPDB Online
                    </a>
                    <a href="{{ route('alumni.home') }}" class="px-6 py-3.5 bg-blue-600 text-white hover:bg-blue-700 font-bold rounded-xl border border-blue-500 shadow-lg shadow-blue-650/20 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-graduation-cap"></i> Portal Alumni
                    </a>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <!-- Mock image of school activity -->
                <div class="relative w-full max-w-md mx-auto aspect-[4/3] bg-white/5 border border-white/10 rounded-3xl p-3 backdrop-blur-sm overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=800" class="w-full h-full object-cover rounded-2xl shadow-md" alt="Aktivitas Siswa">
                    <div class="absolute bottom-6 left-6 right-6 p-4 bg-slate-900/80 backdrop-blur-md rounded-xl border border-white/10">
                        <h4 class="text-xs font-bold">Laboratorium Komputer Modern</h4>
                        <p class="text-[10px] text-slate-350 mt-1">Sarana praktek lengkap berstandar kompetensi dunia industri.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Greetings Section -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 items-center">
            <!-- Image headmaster -->
            <div class="lg:col-span-1 text-center">
                <div class="relative inline-block">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400" class="w-64 h-80 rounded-3xl object-cover shadow-lg mx-auto border-4 border-slate-50" alt="Kepala Sekolah">
                    <div class="absolute -bottom-4 left-1/2 -translate-x-1/2 bg-blue-600 text-white py-2 px-4 rounded-xl shadow-md whitespace-nowrap">
                        <span class="block text-xs font-extrabold">Drs. H. Mulyono, M.Pd</span>
                    </div>
                </div>
            </div>
            <!-- Speech text -->
            <div class="lg:col-span-2 space-y-6">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block">Kata Sambutan</span>
                <h2 class="text-3xl font-bold text-slate-900 leading-tight">Sambutan Kepala Sekolah SMK Negeri 1</h2>
                <div class="text-slate-600 text-sm space-y-4 leading-relaxed">
                    <p>
                        Assalamu’alaikum Warahmatullahi Wabarakatuh,
                    </p>
                    <p>
                        Puji syukur kita panjatkan kepada Tuhan Yang Maha Esa atas karunia-Nya. SMK Negeri 1 terus berkomitmen menjadi pelopor pendidikan vokasi unggulan yang relevan dengan perkembangan industri global. Melalui kurikulum berbasis kompetensi, program sertifikasi industri, serta bimbingan karakter kebangsaan, kami membekali siswa agar memiliki daya saing tinggi.
                    </p>
                    <p>
                        Kerja sama erat dengan dunia usaha dan industri (DUDI) menjamin para lulusan kami terserap dengan cepat, baik yang memilih berkarir langsung, melanjutkan ke perguruan tinggi, maupun merintis usaha mandiri. Mari berkolaborasi bersama kami mencetak masa depan gemilang bagi putra-putri bangsa.
                    </p>
                    <p class="font-bold text-slate-900">
                        Wassalamu’alaikum Warahmatullahi Wabarakatuh.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="bg-gradient-brand text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_siswa'] ?? 1200 }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Siswa Aktif</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_guru'] ?? 85 }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Guru & Staf</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_fasilitas'] ?? 12 }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Fasilitas Praktek</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_prestasi'] ?? 35 }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Prestasi Nasional</p>
            </div>
        </div>
    </div>
</section>

<!-- Program Keahlian / Majors -->
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-16">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Pilihan Kompetensi Keahlian</h2>
            <p class="text-slate-500 text-sm">Menyelenggarakan 3 Program Jurusan unggulan di bidang teknologi informasi dan komunikasi terakreditasi A.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Major 1 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600 text-xl font-bold mb-6"><i class="fa-solid fa-code"></i></span>
                    <h3 class="text-lg font-bold text-slate-900 mb-3">Rekayasa Perangkat Lunak (RPL)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">Mempelajari pemrograman aplikasi web, mobile, desktop, basis data, kecerdasan buatan, serta manajemen proyek perangkat lunak berskala industri.</p>
                </div>
                <a href="{{ route('siswa') }}?jurusan=RPL" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat Data Siswa RPL <i class="fa-solid fa-chevron-right text-[8px]"></i>
                </a>
            </div>

            <!-- Major 2 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-100 text-purple-600 text-xl font-bold mb-6"><i class="fa-solid fa-network-wired"></i></span>
                    <h3 class="text-lg font-bold text-slate-900 mb-3">Teknik Komputer Jaringan (TKJ)</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">Mempelajari administrasi server, instalasi infrastruktur fiber optic, perancangan siber security, cloud computing, serta konfigurasi mikrotik Cisco.</p>
                </div>
                <a href="{{ route('siswa') }}?jurusan=TKJ" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat Data Siswa TKJ <i class="fa-solid fa-chevron-right text-[8px]"></i>
                </a>
            </div>

            <!-- Major 3 -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all flex flex-col justify-between">
                <div>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 text-xl font-bold mb-6"><i class="fa-solid fa-photo-film"></i></span>
                    <h3 class="text-lg font-bold text-slate-900 mb-3">Multimedia / DKV</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">Mempelajari desain grafis, fotografi studio, pembuatan film animasi 2D/3D, videografi pasca-produksi, serta ilustrasi kreatif digital.</p>
                </div>
                <a href="{{ route('siswa') }}?jurusan=Multimedia" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    Lihat Data Siswa Multimedia <i class="fa-solid fa-chevron-right text-[8px]"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Latest News (School Posts) -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-16">
        <div class="flex justify-between items-end border-b border-slate-200 pb-5">
            <div class="space-y-2">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block">Kabar Sekolah</span>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Berita & Pengumuman Terbaru</h2>
            </div>
            <a href="{{ route('berita') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                Semua Berita <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($news as $item)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        <img src="{{ $item->image }}" class="w-full h-full object-cover" alt="{{ $item->title }}">
                        <span class="absolute top-3 left-3 px-2.5 py-1 bg-white/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-blue-800 rounded-lg">
                            {{ $item->category }}
                        </span>
                    </div>
                    <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <p class="text-slate-400 text-[10px] font-medium"><i class="fa-solid fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y') }}</p>
                            <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                <a href="{{ route('berita.show', $item->slug) }}" class="hover:text-blue-600">{{ $item->title }}</a>
                            </h3>
                            <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                                {{ strip_tags($item->content) }}
                            </p>
                        </div>
                        <a href="{{ route('berita.show', $item->slug) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                            Baca Selengkapnya <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 text-sm col-span-full text-center">Belum ada berita sekolah terbaru.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Achievements Preview -->
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-16">
        <div class="flex justify-between items-end border-b border-slate-200 pb-5">
            <div class="space-y-2">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-widest block">Hall of Fame</span>
                <h2 class="text-3xl font-bold tracking-tight text-slate-900">Prestasi Gemilang Terkini</h2>
            </div>
            <a href="{{ route('prestasi') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                Semua Prestasi <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($achievements as $ach)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-all">
                    <div class="aspect-video relative overflow-hidden bg-slate-100">
                        <img src="{{ $ach->image ?? 'https://images.unsplash.com/photo-1505156868547-9b49f4df4e04?w=800' }}" class="w-full h-full object-cover" alt="{{ $ach->title }}">
                        <span class="absolute top-3 left-3 px-2.5 py-1 bg-amber-500 text-white text-[10px] font-extrabold rounded-lg">Tahun {{ $ach->year }}</span>
                    </div>
                    <div class="p-5 flex-grow">
                        <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-2">{{ $ach->title }}</h3>
                        <p class="text-xs text-slate-500 mt-2 line-clamp-3">{{ $ach->description }}</p>
                    </div>
                </div>
            @empty
                <p class="text-slate-500 text-sm col-span-full text-center">Belum ada catatan prestasi terdaftar.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- Call to Action PPDB -->
<section class="py-16 bg-blue-900 text-white relative overflow-hidden">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-4xl mx-auto px-4 text-center space-y-6">
        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Pendaftaran Peserta Didik Baru (PPDB) Dibuka!</h2>
        <p class="text-base text-blue-150 max-w-xl mx-auto leading-relaxed">Persiapkan diri Anda untuk bergabung menjadi bagian dari SMK Pusat Keunggulan dengan fasilitas modern standar internasional.</p>
        <div class="pt-4 flex justify-center gap-4 flex-wrap">
            <a href="{{ route('ppdb') }}" class="px-6 py-3 bg-white text-blue-900 font-bold rounded-xl shadow-lg hover:bg-slate-100 transition-all">
                Daftar PPDB Online
            </a>
            <a href="{{ route('ppdb.status') }}" class="px-6 py-3 bg-blue-700 text-white border border-blue-550 font-bold rounded-xl hover:bg-blue-650 transition-all">
                Cek Status Kelulusan
            </a>
        </div>
    </div>
</section>
@endsection
