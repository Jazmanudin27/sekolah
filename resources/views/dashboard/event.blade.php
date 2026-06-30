@extends('layouts.app')

@section('title', 'Agenda Saya - Portal Alumni SMK Negeri 1')

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
                        <a href="{{ route('dashboard.kartu') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-id-card"></i> Kartu Alumni Digital
                        </a>
                        <a href="{{ route('dashboard.event') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-bold rounded-xl transition-all bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-calendar-check"></i> Event Saya
                        </a>
                        <a href="{{ route('dashboard.donasi') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-wallet"></i> Donasi Saya
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Content Area -->
            <div class="lg:col-span-3">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-check text-blue-600"></i> Riwayat Agenda Kegiatan Diikuti
                    </h2>
                    
                    <div class="space-y-4">
                        @forelse($rsvps as $rsvp)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-slate-50 border border-slate-50 rounded-2xl gap-4 text-xs">
                                <div class="space-y-1">
                                    <h3 class="text-sm font-bold text-slate-900 hover:text-blue-600">
                                        <a href="{{ route('agenda.show', $rsvp->event->slug) }}">{{ $rsvp->event->title }}</a>
                                    </h3>
                                    <p class="text-slate-450"><i class="fa-solid fa-clock mr-1 text-[10px]"></i>{{ $rsvp->event->date->format('d M Y - H:i') }} WIB</p>
                                    <p class="text-slate-500"><i class="fa-solid fa-location-dot mr-1 text-[10px]"></i>{{ $rsvp->event->location }}</p>
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <span class="px-2.5 py-1 rounded-lg font-bold text-[9px] uppercase tracking-wider {{ $rsvp->status == 'hadir' ? 'bg-emerald-100 text-emerald-800' : ($rsvp->status == 'ragu_ragu' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                        {{ $rsvp->status }}
                                    </span>
                                    <a href="{{ route('agenda.show', $rsvp->event->slug) }}" class="px-3 py-1.5 border border-slate-200 hover:bg-slate-100 rounded-lg font-bold transition-all text-[10px]">
                                        Detail Event
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-calendar text-3xl mb-2 text-slate-300"></i>
                                <p class="text-xs">Anda belum pernah mengonfirmasi kehadiran agenda apapun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
