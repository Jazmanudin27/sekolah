@extends('layouts.app')

@section('title', 'Penerimaan Siswa Baru (PPDB) - SMK Negeri 1')

@section('content')
<div class="relative bg-slate-900 overflow-hidden py-16 sm:py-24 mb-12">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500/10 rounded-full uppercase tracking-wider">PPDB Online 2026/2027</span>
        <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Penerimaan Peserta Didik Baru</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Bergabunglah bersama SMK Negeri 1 untuk meniti karir impian Anda di bidang teknologi dan kreatif digital.</p>
        <div class="mt-8 flex justify-center gap-4">
            <a href="#form-daftar" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-lg shadow-blue-600/20">
                Daftar Sekarang
            </a>
            <a href="{{ route('ppdb.status') }}" class="px-6 py-3 bg-slate-800 hover:bg-slate-700 text-slate-100 font-semibold rounded-xl border border-slate-700 transition-all">
                Cek Status Kelulusan
            </a>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <!-- Info Section & Sidebar Form -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Info & Requirements (Col 2) -->
        <div class="lg:col-span-2 space-y-12">
            <!-- Program Keahlian -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="text-blue-600"><i class="fa-solid fa-layer-group"></i></span>
                    Pilihan Program Keahlian
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="p-5 bg-blue-50/50 border border-blue-100/50 rounded-xl">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600 text-white font-bold mb-3"><i class="fa-solid fa-code text-sm"></i></span>
                        <h4 class="font-bold text-slate-900 text-sm">Rekayasa Perangkat Lunak</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Fokus pada pemrograman web, mobile, database, dan AI technologies.</p>
                    </div>
                    <div class="p-5 bg-purple-50/50 border border-purple-100/50 rounded-xl">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600 text-white font-bold mb-3"><i class="fa-solid fa-network-wired text-sm"></i></span>
                        <h4 class="font-bold text-slate-900 text-sm">Teknik Komputer Jaringan</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Fokus pada administrasi server, fiber optic, keamanan siber, dan cloud.</p>
                    </div>
                    <div class="p-5 bg-amber-50/50 border border-amber-100/50 rounded-xl">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-600 text-white font-bold mb-3"><i class="fa-solid fa-photo-film text-sm"></i></span>
                        <h4 class="font-bold text-slate-900 text-sm">Multimedia / DKV</h4>
                        <p class="text-xs text-slate-500 mt-1 leading-relaxed">Fokus pada desain grafis, editing video, animasi 2D/3D, dan fotografi.</p>
                    </div>
                </div>
            </div>

            <!-- Alur PPDB -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="text-blue-600"><i class="fa-solid fa-route"></i></span>
                    Alur Pendaftaran PPDB Online
                </h2>
                <div class="relative pl-6 border-l border-slate-100 space-y-8">
                    <div class="relative">
                        <span class="absolute -left-[31px] top-0 flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-white text-[10px] font-bold shadow-md shadow-blue-500/25">1</span>
                        <h4 class="font-bold text-slate-900 text-sm">Registrasi Online</h4>
                        <p class="text-xs text-slate-500 mt-1">Mengisi formulir data diri, kontak, dan memilih program keahlian di halaman pendaftaran ini.</p>
                    </div>
                    <div class="relative">
                        <span class="absolute -left-[31px] top-0 flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-slate-600 text-[10px] font-bold">2</span>
                        <h4 class="font-bold text-slate-900 text-sm">Pemeriksaan Berkas (Verifikasi)</h4>
                        <p class="text-xs text-slate-500 mt-1">Panitia PPDB memeriksa data pendaftaran dan keabsahan berkas calon siswa secara bertahap.</p>
                    </div>
                    <div class="relative">
                        <span class="absolute -left-[31px] top-0 flex h-6 w-6 items-center justify-center rounded-full bg-slate-200 text-slate-600 text-[10px] font-bold">3</span>
                        <h4 class="font-bold text-slate-900 text-sm">Pengumuman Kelulusan</h4>
                        <p class="text-xs text-slate-500 mt-1">Siswa dapat mencari Nomor Pendaftaran mereka di halaman cek status untuk melihat kelulusan.</p>
                    </div>
                </div>
            </div>

            <!-- Persyaratan -->
            <div class="bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                    <span class="text-blue-600"><i class="fa-solid fa-circle-info"></i></span>
                    Persyaratan Dokumen Pendaftaran
                </h2>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-slate-600 font-medium">
                    <li class="flex items-center gap-2.5">
                        <span class="text-emerald-500"><i class="fa-solid fa-circle-check"></i></span>
                        <span>Scan Ijazah / Surat Keterangan Lulus (SKL) SMP</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="text-emerald-500"><i class="fa-solid fa-circle-check"></i></span>
                        <span>Scan Kartu Keluarga (KK) & Akta Kelahiran</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="text-emerald-500"><i class="fa-solid fa-circle-check"></i></span>
                        <span>Scan Pas Foto Berwarna ukuran 3x4 (2 Lembar)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <span class="text-emerald-500"><i class="fa-solid fa-circle-check"></i></span>
                        <span>Scan Rapor Nilai Semester 1-5</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Registration Form (Col 1) -->
        <div id="form-daftar" class="lg:col-span-1 scroll-mt-24">
            <div class="bg-white rounded-2xl border border-slate-100 shadow-lg p-6 sticky top-24">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Formulir PPDB</h3>
                <p class="text-xs text-slate-500 mb-6 leading-relaxed">Silakan isi formulir di bawah ini dengan lengkap dan benar.</p>

                <form action="{{ route('ppdb.daftar') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Nama sesuai ijazah SMP..." 
                            class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Email</label>
                        <input type="email" name="email" required placeholder="Alamat email aktif..." 
                            class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">No. WhatsApp / HP</label>
                        <input type="text" name="phone" required placeholder="08xxxxxxxxxx..." 
                            class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Asal Sekolah (SMP / MTs)</label>
                        <input type="text" name="previous_school" required placeholder="Contoh: SMPN 1 Kota..." 
                            class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase mb-1">Pilihan Jurusan</label>
                        <select name="major_choice" required 
                            class="w-full px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                            <option value="">Pilih Jurusan...</option>
                            <option value="RPL">RPL (Rekayasa Perangkat Lunak)</option>
                            <option value="TKJ">TKJ (Teknik Komputer Jaringan)</option>
                            <option value="Multimedia">Multimedia / DKV</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md shadow-blue-600/10 hover:shadow-blue-600/20 mt-6">
                        Kirim Pendaftaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
