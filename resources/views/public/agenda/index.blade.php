@extends('layouts.app')

@section('title', 'Agenda Kegiatan - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Agenda Kegiatan</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Agenda & Jadwal Kegiatan</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Daftar agenda reuni, halal bihalal, seminar kompetensi, lomba olahraga, hingga agenda webinar mendatang.</p>
        </div>

        <!-- Upcoming Events -->
        <div class="space-y-6">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3 flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></span> Kegiatan Mendatang (Upcoming)
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @forelse($upcomingEvents as $event)
                    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                        <div class="aspect-video relative overflow-hidden bg-slate-100">
                            <img src="{{ $event->image }}" class="w-full h-full object-cover" alt="{{ $event->title }}">
                            <div class="absolute top-4 left-4 flex gap-2">
                                <span class="px-2.5 py-1 bg-white/95 backdrop-blur-sm text-[10px] font-bold text-blue-800 rounded-lg">
                                    <i class="fa-solid fa-clock mr-1"></i>{{ $event->date->format('H:i') }} WIB
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2.5">
                                <div class="flex gap-2.5 text-xs text-blue-700 font-bold uppercase tracking-wider">
                                    <span>{{ $event->date->format('d M Y') }}</span>
                                    <span>&bull;</span>
                                    <span class="text-slate-500 truncate max-w-[200px]"><i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 leading-snug">
                                    <a href="{{ route('agenda.show', $event->slug) }}" class="hover:text-blue-600">{{ $event->title }}</a>
                                </h3>
                                <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                                    {{ $event->description }}
                                </p>
                            </div>
                            <a href="{{ route('agenda.show', $event->slug) }}" class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 rounded-xl text-center transition-colors">
                                RSVP & Kehadiran <i class="fa-solid fa-angle-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 text-sm col-span-full py-8 text-center bg-white rounded-3xl border border-slate-100">Belum ada kegiatan mendatang.</p>
                @endforelse
            </div>
        </div>

        <!-- Past Events -->
        <div class="space-y-6">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-slate-400"></i> Riwayat Kegiatan (Past Events)
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($pastEvents as $event)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col opacity-80 hover:opacity-100 transition-opacity">
                        <div class="aspect-video bg-slate-100">
                            <img src="{{ $event->image }}" class="w-full h-full object-cover grayscale" alt="{{ $event->title }}">
                        </div>
                        <div class="p-5 space-y-3">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $event->date->format('d M Y') }} &bull; {{ $event->location }}</p>
                            <h3 class="text-sm font-bold text-slate-800 line-clamp-2">
                                <a href="{{ route('agenda.show', $event->slug) }}" class="hover:text-blue-600">{{ $event->title }}</a>
                            </h3>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 text-sm col-span-full py-8 text-center bg-white rounded-2xl border border-slate-100">Belum ada riwayat kegiatan.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
