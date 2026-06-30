@extends('layouts.app')

@section('title', 'Dashboard Alumni - Portal Alumni SMK Negeri 1')

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
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-bold rounded-xl transition-all bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-gauge-high"></i> Dashboard Saya
                        </a>
                        <a href="{{ route('dashboard.profil') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-user-gear"></i> Edit Profil
                        </a>
                        <a href="{{ route('dashboard.kartu') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
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
                <!-- Welcome Banner -->
                <div class="bg-gradient-brand text-white p-8 rounded-3xl shadow-sm relative overflow-hidden">
                    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                    <div class="space-y-2.5 relative z-10">
                        <h2 class="text-xl sm:text-2xl font-extrabold leading-tight">Halo, Selamat Datang {{ $user->name }}!</h2>
                        <p class="text-xs text-blue-150 leading-relaxed max-w-xl">
                            Senang melihat Anda bergabung kembali di portal alumni. Akses menu kartu anggota digital Anda, kelola RSVP agenda, atau perbarui profil karir Anda kapan saja.
                        </p>
                    </div>
                </div>

                <!-- Stats summary widgets -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 text-lg shadow-inner">
                            <i class="fa-solid fa-calendar-days"></i>
                        </span>
                        <div class="space-y-0.5 text-xs">
                            <p class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Event Diikuti</p>
                            <p class="text-2xl font-extrabold text-slate-900">{{ $rsvpsCount }}</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-4">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 text-lg shadow-inner">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </span>
                        <div class="space-y-0.5 text-xs">
                            <p class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Total Donasi Saya</p>
                            <p class="text-2xl font-extrabold text-slate-900">Rp {{ number_format($donationsTotal, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Registered Events -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-50 pb-2"><i class="fa-solid fa-calendar-check text-blue-600 mr-1.5"></i> Jadwal Agenda Saya Mendatang</h3>
                    <div class="space-y-3.5">
                        @forelse($myEvents as $rsvp)
                            <div class="flex items-center justify-between p-4 bg-slate-50 border border-slate-50 rounded-2xl text-xs">
                                <div class="space-y-1">
                                    <h4 class="font-bold text-slate-800 leading-snug">{{ $rsvp->event->title }}</h4>
                                    <p class="text-[10px] text-slate-400"><i class="fa-solid fa-clock mr-1 text-[9px]"></i>{{ $rsvp->event->date->format('d M Y - H:i') }} WIB</p>
                                </div>
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 rounded-lg font-bold text-[9px] uppercase tracking-wider">
                                    {{ $rsvp->status }}
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-400 text-xs text-center py-4">Belum ada agenda terdaftar.</p>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection
