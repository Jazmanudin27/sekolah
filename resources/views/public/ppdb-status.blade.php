@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran PPDB - SMK Negeri 1')

@section('content')
<div class="relative bg-slate-900 overflow-hidden py-16 sm:py-24 mb-12">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500/10 rounded-full uppercase tracking-wider">Verifikasi Berkas</span>
        <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Cek Status PPDB Online</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Masukkan nomor pendaftaran PPDB Anda (contoh: PPDB-2026-0001) untuk memantau status aplikasi Anda.</p>
    </div>
</div>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <!-- Search Form -->
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-md mb-10">
        <form action="{{ route('ppdb.status') }}" method="GET" class="flex gap-3">
            <div class="relative flex-grow">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-barcode"></i>
                </span>
                <input type="text" name="q" value="{{ request('q') }}" required placeholder="Contoh: PPDB-2026-0001" 
                    class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md shadow-blue-600/10 hover:shadow-blue-600/20">
                Cari Data
            </button>
        </form>
    </div>

    @if($search)
        @if($admission)
            <!-- Status Card -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-lg overflow-hidden">
                <!-- Card Header -->
                <div class="bg-slate-50 p-6 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Nomor Pendaftaran</span>
                        <h3 class="text-lg font-bold text-slate-900">{{ $admission->registration_number }}</h3>
                    </div>
                    <div>
                        @if($admission->status == 'approved')
                            <span class="px-4 py-1.5 text-xs font-extrabold bg-emerald-50 text-emerald-700 rounded-full border border-emerald-200">DITERIMA</span>
                        @elseif($admission->status == 'rejected')
                            <span class="px-4 py-1.5 text-xs font-extrabold bg-rose-50 text-rose-700 rounded-full border border-rose-200">DITOLAK / TIDAK LULUS</span>
                        @else
                            <span class="px-4 py-1.5 text-xs font-extrabold bg-amber-50 text-amber-700 rounded-full border border-amber-200">PROSES VERIFIKASI</span>
                        @endif
                    </div>
                </div>

                <!-- Card Body Details -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase">Nama Lengkap</span>
                            <span class="font-bold text-slate-800">{{ $admission->name }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase">Sekolah Asal</span>
                            <span class="font-bold text-slate-800">{{ $admission->previous_school }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase">Pilihan Jurusan</span>
                            <span class="font-bold text-slate-800">
                                @if($admission->major_choice == 'RPL')
                                    Rekayasa Perangkat Lunak (RPL)
                                @elseif($admission->major_choice == 'TKJ')
                                    Teknik Komputer Jaringan (TKJ)
                                @else
                                    {{ $admission->major_choice }}
                                @endif
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-slate-400 uppercase">Tanggal Daftar</span>
                            <span class="font-bold text-slate-800">{{ $admission->created_at->format('d M Y - H:i') }}</span>
                        </div>
                    </div>

                    <!-- Flow Timeline Status -->
                    <div class="border-t border-slate-100 pt-8 mt-4">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-6 text-center">Progress Pendaftaran</h4>
                        <div class="relative flex items-center justify-between w-full">
                            <!-- Background line -->
                            <div class="absolute left-0 right-0 h-1 bg-slate-100 -translate-y-4 z-0"></div>
                            
                            <!-- Active progress line based on status -->
                            @if($admission->status == 'approved' || $admission->status == 'rejected')
                                <div class="absolute left-0 right-0 h-1 bg-blue-600 -translate-y-4 z-0"></div>
                            @else
                                <div class="absolute left-0 w-1/2 h-1 bg-blue-600 -translate-y-4 z-0"></div>
                            @endif

                            <!-- Step 1: Registered -->
                            <div class="relative z-10 flex flex-col items-center">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold shadow-md shadow-blue-500/25">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                                <span class="text-[11px] font-bold text-slate-800 mt-2">Terdaftar</span>
                            </div>

                            <!-- Step 2: Under Review -->
                            <div class="relative z-10 flex flex-col items-center">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 text-white text-xs font-bold shadow-md shadow-blue-500/25">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </span>
                                <span class="text-[11px] font-bold text-slate-800 mt-2">Verifikasi Dokumen</span>
                            </div>

                            <!-- Step 3: Result -->
                            <div class="relative z-10 flex flex-col items-center">
                                @if($admission->status == 'approved')
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-600 text-white text-xs font-bold shadow-md shadow-emerald-500/25">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </span>
                                    <span class="text-[11px] font-bold text-emerald-600 mt-2">Diterima</span>
                                @elseif($admission->status == 'rejected')
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-rose-600 text-white text-xs font-bold shadow-md shadow-rose-500/25">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                    </span>
                                    <span class="text-[11px] font-bold text-rose-650 mt-2">Ditolak</span>
                                @else
                                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-200 text-slate-400 text-xs font-bold">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                    </span>
                                    <span class="text-[11px] font-bold text-slate-400 mt-2">Pengumuman</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Informational Box based on status -->
                    <div class="border-t border-slate-100 pt-6 mt-6">
                        @if($admission->status == 'approved')
                            <div class="p-4 bg-emerald-50 border border-emerald-100 rounded-xl text-emerald-800 text-xs leading-relaxed">
                                <strong class="block mb-1 text-sm">Selamat! Anda Dinyatakan Lulus Seleksi.</strong>
                                Harap segera melakukan pendaftaran ulang di sekretariat PPDB sekolah dengan membawa bukti print pendaftaran ini dan fotokopi berkas fisik asli pada jam kerja (08.00 - 14.00).
                            </div>
                        @elseif($admission->status == 'rejected')
                            <div class="p-4 bg-rose-50 border border-rose-100 rounded-xl text-rose-800 text-xs leading-relaxed">
                                <strong class="block mb-1 text-sm">Mohon Maaf. Anda Belum Lulus Seleksi.</strong>
                                Terima kasih atas partisipasi Anda mendaftar di SMK Negeri 1. Kuota program keahlian yang Anda pilih saat ini sudah penuh terisi. Tetap semangat menempuh pendidikan di lembaga lainnya!
                            </div>
                        @else
                            <div class="p-4 bg-amber-50 border border-amber-100 rounded-xl text-amber-800 text-xs leading-relaxed">
                                <strong class="block mb-1 text-sm">Pendaftaran Sedang Ditinjau.</strong>
                                Berkas administrasi Anda saat ini dalam proses verifikasi oleh panitia seleksi. Update pengumuman kelulusan akan diberitahukan secara bertahap. Harap periksa halaman ini secara berkala.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @else
            <!-- Not Found Box -->
            <div class="bg-white p-12 rounded-2xl border border-slate-100 shadow-md text-center text-slate-500 font-medium">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 fs-1 block mb-3"></i>
                Nomor pendaftaran <strong class="text-slate-800 font-bold">"{{ $search }}"</strong> tidak ditemukan.<br>
                <span class="text-xs text-slate-400 block mt-1">Harap periksa kembali format nomor pendaftaran Anda.</span>
            </div>
        @endif
    @endif
</div>
@endsection
