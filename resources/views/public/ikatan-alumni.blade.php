@extends('layouts.app')

@section('title', 'Ikatan Alumni - Portal Alumni ' . ($currentSchool->name ?? 'Sekolah'))

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Ikatan Alumni</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Ikatan Alumni (IKA)</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Organisasi resmi wadah persatuan, koordinasi, dan penyaluran aspirasi seluruh alumni {{ $currentSchool->name ?? 'Sekolah' }}.</p>
        </div>

        <!-- Profil Organisasi -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-circle-info text-blue-600"></i> Tentang Organisasi Alumni
                </h2>
                <div class="text-slate-600 text-sm space-y-4 leading-relaxed">
                    <p>
                        Ikatan Alumni {{ $currentSchool->name ?? 'Sekolah' }} (IKA {{ $currentSchool->name ?? 'Sekolah' }}) dideklarasikan sebagai tindak lanjut atas keinginan bersama mempererat tali kekeluargaan antarlulusan. Kami bertujuan menyatukan alumni dari berbagai generasi guna membentuk sinergi yang kuat, baik untuk kemajuan anggota maupun kemajuan almamater.
                    </p>
                    <p>
                        Sejak awal berdiri, IKA {{ $currentSchool->name ?? 'Sekolah' }} aktif menyelenggarakan berbagai kegiatan sosial, reuni berkala, pembinaan karir bagi lulusan baru, serta penggalangan dana pembangunan beasiswa pendidikan siswa kurang mampu.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-4">
                <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-3"><i class="fa-solid fa-file-shield text-blue-600 mr-1.5"></i> AD/ART & Program</h2>
                <ul class="space-y-3 text-xs text-slate-600">
                    <li class="p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors">
                        <a href="#" class="flex items-center justify-between font-semibold">
                            <span>Anggaran Dasar (AD)</span>
                            <i class="fa-solid fa-download text-blue-600"></i>
                        </a>
                    </li>
                    <li class="p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors">
                        <a href="#" class="flex items-center justify-between font-semibold">
                            <span>Anggaran Rumah Tangga (ART)</span>
                            <i class="fa-solid fa-download text-blue-600"></i>
                        </a>
                    </li>
                    <li class="p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors">
                        <a href="#" class="flex items-center justify-between font-semibold">
                            <span>Program Kerja Tahunan</span>
                            <i class="fa-solid fa-download text-blue-600"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Visi & Misi Alumni -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-4">
                <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-2"><i class="fa-solid fa-eye text-blue-600 mr-2"></i> Visi IKA</h2>
                <p class="text-sm text-slate-650 leading-relaxed italic">
                    "Terwujudnya ikatan alumni yang solid, dinamis, profesional, peduli sosial, serta berdaya saing global untuk memajukan almamater dan kesejahteraan bersama."
                </p>
            </div>
            <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-4">
                <h2 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-2"><i class="fa-solid fa-list-check text-blue-600 mr-2"></i> Misi IKA</h2>
                <ul class="list-decimal list-inside text-xs text-slate-600 space-y-2">
                    <li>Membangun database alumni terintegrasi untuk memperluas jejaring komunikasi.</li>
                    <li>Menyelenggarakan kegiatan peningkatan kapasitas karir dan bisnis alumni.</li>
                    <li>Berkolaborasi aktif dengan pihak sekolah dalam pengembangan sarana pendidikan.</li>
                </ul>
            </div>
        </div>

        <!-- Struktur Kepengurusan -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-8">
            <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                <i class="fa-solid fa-users text-blue-600"></i> Struktur Organisasi Pengurus Alumni
            </h2>
            <p class="text-xs text-slate-400">Periode Jabatan Aktif: 2024 - 2028</p>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <h3 class="text-xs font-bold text-slate-900">Hendra Wijaya, S.T.</h3>
                    <p class="text-[10px] text-slate-400">Ketua Umum</p>
                </div>
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <h3 class="text-xs font-bold text-slate-900">Diana Safitri, S.E.</h3>
                    <p class="text-[10px] text-slate-400">Wakil Ketua</p>
                </div>
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <h3 class="text-xs font-bold text-slate-900">Budi Santoso, S.Kom</h3>
                    <p class="text-[10px] text-slate-400">Sekretaris Jenderal</p>
                </div>
                <div class="space-y-2 p-4 rounded-xl border border-slate-50 bg-slate-50">
                    <h3 class="text-xs font-bold text-slate-900">Rina Handayani, Ak.</h3>
                    <p class="text-[10px] text-slate-400">Bendahara Umum</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
