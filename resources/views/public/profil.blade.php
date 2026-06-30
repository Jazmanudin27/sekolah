@extends('layouts.app')

@section('title', 'Profil Sekolah - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Breadcrumb / Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Profil Almamater</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Profil Sekolah</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Informasi lengkap mengenai sejarah, visi-misi, kepengurusan, dan sarana prasarana almamater tercinta.</p>
        </div>

        <!-- Visi, Misi & Tentang -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i> Sejarah & Profil Singkat
                </h2>
                <div class="text-slate-600 text-sm space-y-4 leading-relaxed">
                    <p>
                        SMK Negeri 1 didirikan pada tahun 1976 atas prakarsa Departemen Pendidikan untuk mencetak tenaga terampil siap pakai di bidang keteknikan dan industri komunikasi. Memulai kegiatan belajar mengajar dengan 3 jurusan awal, kini sekolah kami telah bertransformasi menjadi salah satu sekolah vokasi rujukan nasional.
                    </p>
                    <p>
                        Dengan sarana laboratorium canggih dan kemitraan erat bersama ratusan industri terkemuka baik tingkat nasional maupun internasional, kami terus melahirkan lulusan-lulusan unggul yang terserap di berbagai sektor industri maupun sukses berwirausaha mandiri.
                    </p>
                    <div class="p-4 bg-blue-50 border border-blue-100 rounded-xl text-blue-900 flex gap-3.5">
                        <i class="fa-solid fa-award text-2xl text-blue-500 mt-0.5"></i>
                        <div>
                            <p class="font-bold text-xs">Motto Sekolah</p>
                            <p class="text-xs mt-1 italic">"Cerdas, Terampil, Berkarakter Mulia, dan Siap Kerja Nasional."</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-brand text-white rounded-3xl p-8 shadow-md relative overflow-hidden flex flex-col justify-between">
                <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                <div class="space-y-6 relative z-10">
                    <h2 class="text-lg font-bold flex items-center gap-2 border-b border-white/10 pb-3">
                        <i class="fa-solid fa-bullseye text-blue-300"></i> Visi & Misi
                    </h2>
                    <div class="space-y-4 text-xs leading-relaxed">
                        <div>
                            <p class="font-bold uppercase tracking-wider text-blue-300">Visi:</p>
                            <p class="mt-1 text-slate-100">"Menjadi institusi pendidikan kejuruan yang menghasilkan SDM bertaraf internasional, menguasai IPTEK, berjiwa wirausaha dan memiliki akhlak mulia."</p>
                        </div>
                        <div>
                            <p class="font-bold uppercase tracking-wider text-blue-300">Misi:</p>
                            <ul class="list-disc list-inside space-y-1.5 mt-1 text-slate-100">
                                <li>Melaksanakan sistem pembelajaran berbasis industri.</li>
                                <li>Membekali sertifikasi kompetensi bertaraf internasional.</li>
                                <li>Menanamkan jiwa disiplin, religius, dan berwawasan lingkungan.</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Struktur Organisasi & Staff -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-8">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-sitemap text-blue-600"></i> Struktur Organisasi Sekolah
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=100" class="w-16 h-16 rounded-full mx-auto object-cover" alt="Kepala Sekolah">
                    <h3 class="text-xs font-bold text-slate-900">Drs. H. Mulyono, M.Pd</h3>
                    <p class="text-[10px] text-slate-400">Kepala Sekolah</p>
                </div>
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" class="w-16 h-16 rounded-full mx-auto object-cover" alt="Waka Kurikulum">
                    <h3 class="text-xs font-bold text-slate-900">Siti Rahma, M.Pd</h3>
                    <p class="text-[10px] text-slate-400">Waka Kurikulum</p>
                </div>
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=100" class="w-16 h-16 rounded-full mx-auto object-cover" alt="Waka Kesiswaan">
                    <h3 class="text-xs font-bold text-slate-900">Taufik Hidayat, S.Pd</h3>
                    <p class="text-[10px] text-slate-400">Waka Kesiswaan</p>
                </div>
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" class="w-16 h-16 rounded-full mx-auto object-cover" alt="Kepala Tata Usaha">
                    <h3 class="text-xs font-bold text-slate-900">Aris Munandar, S.E.</h3>
                    <p class="text-[10px] text-slate-400">Kepala Tata Usaha</p>
                </div>
            </div>
        </div>

        <!-- Kepala Sekolah Masa ke Masa -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-users-line text-blue-600"></i> Kepala Sekolah Dari Masa ke Masa
                </h2>
                <div class="space-y-3.5 text-xs text-slate-600">
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <span class="font-bold text-slate-800">Drs. H. Mulyono, M.Pd</span>
                        <span class="px-2.5 py-0.5 bg-blue-100 text-blue-800 rounded-full font-bold text-[9px]">2020 - Sekarang</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <span class="font-bold text-slate-800">Dra. Hj. Wahyuni, M.Si</span>
                        <span class="px-2.5 py-0.5 bg-slate-200 text-slate-600 rounded-full font-bold text-[9px]">2012 - 2020</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <span class="font-bold text-slate-800">Ir. H. Rahmat Hidayat</span>
                        <span class="px-2.5 py-0.5 bg-slate-200 text-slate-600 rounded-full font-bold text-[9px]">2002 - 2012</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <span class="font-bold text-slate-800">Drs. Soetjipto (Alm)</span>
                        <span class="px-2.5 py-0.5 bg-slate-200 text-slate-600 rounded-full font-bold text-[9px]">1976 - 2002</span>
                    </div>
                </div>
            </div>

            <!-- Prestasi Sekolah -->
            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-trophy text-blue-600"></i> Prestasi Unggulan
                </h2>
                <div class="space-y-4">
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-amber-600"><i class="fa-solid fa-graduation-cap mr-1"></i> Akademik</h3>
                        <ul class="list-inside list-disc text-xs text-slate-600 space-y-1">
                            <li>Juara 1 Lomba Kompetensi Siswa (LKS) Tingkat Nasional Bidang IT Software 2025.</li>
                            <li>Sekolah Percontohan SMK Pusat Keunggulan tingkat Provinsi.</li>
                        </ul>
                    </div>
                    <div class="space-y-2">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-blue-600"><i class="fa-solid fa-volleyball mr-1"></i> Non Akademik</h3>
                        <ul class="list-inside list-disc text-xs text-slate-600 space-y-1">
                            <li>Medali Emas Lomba Robotika Nasional 2024.</li>
                            <li>Juara Umum Kejuaraan Futsal Antar Pelajar Tingkat Kabupaten 2025.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sarana & Prasarana -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-building-columns text-blue-600"></i> Sarana & Prasarana
            </h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center text-xs">
                <div class="p-4 border border-slate-100 rounded-2xl bg-slate-50">
                    <i class="fa-solid fa-desktop text-2xl text-blue-600 mb-2"></i>
                    <p class="font-bold">Lab Komputer</p>
                    <p class="text-[10px] text-slate-400 mt-1">Lengkap & Full AC</p>
                </div>
                <div class="p-4 border border-slate-100 rounded-2xl bg-slate-50">
                    <i class="fa-solid fa-book-open-reader text-2xl text-blue-600 mb-2"></i>
                    <p class="font-bold">Perpustakaan Digital</p>
                    <p class="text-[10px] text-slate-400 mt-1">Ribuan E-Book & Jurnal</p>
                </div>
                <div class="p-4 border border-slate-100 rounded-2xl bg-slate-50">
                    <i class="fa-solid fa-seedling text-2xl text-blue-600 mb-2"></i>
                    <p class="font-bold">Green House</p>
                    <p class="text-[10px] text-slate-400 mt-1">Wawasan Lingkungan</p>
                </div>
                <div class="p-4 border border-slate-100 rounded-2xl bg-slate-50">
                    <i class="fa-solid fa-basketball text-2xl text-blue-600 mb-2"></i>
                    <p class="font-bold">Sport Center</p>
                    <p class="text-[10px] text-slate-400 mt-1">Lapangan Indoor/Outdoor</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
