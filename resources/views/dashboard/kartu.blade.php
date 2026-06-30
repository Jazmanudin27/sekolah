@extends('layouts.app')

@section('title', 'Kartu Alumni Digital - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- Sidebar Navigation -->
            <div class="space-y-4">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ $user->foto ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100' }}" class="w-10 h-10 rounded-full object-cover border border-slate-100 shadow-sm" alt="avatar">
                        <div class="min-w-0 text-xs">
                            <p class="font-bold text-slate-800 truncate">{{ $user->name }}</p>
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full font-bold text-[8px] uppercase tracking-wider">{{ $user->role }}</span>
                        </div>
                    </div>
                    
                    <nav class="flex flex-col gap-1 text-xs">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-gauge-high"></i> Dashboard Saya
                        </a>
                        <a href="{{ route('dashboard.profil') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-user-gear"></i> Edit Profil
                        </a>
                        <a href="{{ route('dashboard.kartu') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-bold rounded-xl transition-all bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-id-card"></i> Kartu Alumni Digital
                        </a>
                        <a href="{{ route('dashboard.event') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-calendar-check"></i> Event Saya
                        </a>
                        <a href="{{ route('dashboard.donasi') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-wallet"></i> Donasi Saya
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Content Area (Right) -->
            <div class="lg:col-span-3 space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <div class="flex items-center justify-between border-b border-slate-50 pb-3">
                        <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                            <i class="fa-solid fa-id-card text-blue-600"></i> Kartu Anggota Alumni Digital
                        </h2>
                        <button onclick="window.print()" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-lg text-xs flex items-center gap-1">
                            <i class="fa-solid fa-print"></i> Cetak Kartu
                        </button>
                    </div>

                    <!-- Digital Card Grid Container (Aesthetic layout) -->
                    <div class="flex flex-col md:flex-row items-center justify-center gap-8 py-8">
                        <!-- FRONT OF CARD -->
                        <div class="relative w-full max-w-sm aspect-[1.586/1] bg-gradient-brand text-white rounded-2xl shadow-xl overflow-hidden p-6 border border-white/10 flex flex-col justify-between">
                            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:12px_12px]"></div>
                            <!-- Card Header -->
                            <div class="flex items-center justify-between border-b border-white/20 pb-3 relative z-10">
                                <div class="flex items-center gap-2">
                                    <span class="flex h-7 w-7 items-center justify-center rounded-lg bg-white/20 text-white font-bold text-xs">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </span>
                                    <div>
                                        <span class="block text-xs font-bold leading-none uppercase tracking-wide">KARTU ALUMNI</span>
                                        <span class="block text-[8px] text-blue-200 tracking-widest font-semibold uppercase leading-none mt-0.5">SMK NEGERI 1</span>
                                    </div>
                                </div>
                                @if($user->status_verifikasi)
                                    <span class="px-2 py-0.5 bg-emerald-500/25 border border-emerald-400/20 text-[8px] font-bold uppercase tracking-wider rounded-md text-emerald-200">
                                        Terverifikasi
                                    </span>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="flex gap-4 items-center py-4 relative z-10">
                                <img src="{{ $user->foto ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100' }}" class="w-16 h-16 rounded-xl object-cover border-2 border-white/25 shadow-md bg-white/10" alt="avatar">
                                <div class="min-w-0 space-y-1">
                                    <h3 class="font-extrabold text-sm truncate leading-snug tracking-tight">{{ $user->name }}</h3>
                                    <p class="text-[9px] text-blue-200 tracking-wide font-bold uppercase">{{ $user->jurusan }} (Angkatan {{ $user->angkatan }})</p>
                                    <p class="text-[8px] text-blue-300">No. Alumni: IKA-{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="flex items-end justify-between text-[7px] text-blue-200 border-t border-white/10 pt-2.5 relative z-10">
                                <p>Motto: Cerdas, Terampil, Berkarakter</p>
                                <p class="font-semibold uppercase tracking-wider">Masa Berlaku: Seumur Hidup</p>
                            </div>
                        </div>

                        <!-- BACK OF CARD -->
                        <div class="relative w-full max-w-sm aspect-[1.586/1] bg-slate-900 text-white rounded-2xl shadow-xl overflow-hidden p-6 border border-white/15 flex flex-col justify-between">
                            <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:12px_12px]"></div>
                            
                            <!-- Card terms -->
                            <div class="text-[9px] text-slate-400 space-y-1.5 leading-relaxed relative z-10">
                                <p class="font-bold border-b border-slate-800 pb-1 text-slate-200 uppercase tracking-wide">Ketentuan Penggunaan:</p>
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Kartu ini adalah identitas resmi alumni SMK Negeri 1.</li>
                                    <li>Dapat digunakan untuk verifikasi kehadiran agenda alumni.</li>
                                    <li>Gunakan QR Code untuk mendapatkan benefit promosi mitra bisnis alumni.</li>
                                </ul>
                            </div>

                            <!-- QR Code rendering -->
                            <div class="flex justify-between items-end relative z-10">
                                <div class="text-[7px] text-slate-500">
                                    <p>Sekretariat Ikatan Alumni SMKN 1</p>
                                    <p>Jl. Pendidikan No. 45, Kota Raya</p>
                                </div>
                                <div class="bg-white p-1 rounded-lg">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=70x70&data=IKA-{{ $user->id }}" alt="QR Code" class="w-14 h-14">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
