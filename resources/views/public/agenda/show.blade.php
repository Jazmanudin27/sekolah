@extends('layouts.app')

@section('title', $event->title . ' - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Navigation -->
                <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                    <i class="fa-solid fa-angle-right text-[8px]"></i>
                    <a href="{{ route('agenda') }}" class="hover:text-blue-600">Agenda</a>
                    <i class="fa-solid fa-angle-right text-[8px]"></i>
                    <span class="text-slate-500 truncate max-w-xs">{{ $event->title }}</span>
                </nav>

                <!-- Detailed Event Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">{{ $event->title }}</h1>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs bg-slate-50 p-4 rounded-2xl border border-slate-100 text-slate-650">
                        <p class="flex items-center gap-2 font-semibold">
                            <i class="fa-solid fa-calendar-check text-blue-600 text-sm"></i>
                            <span>{{ $event->date->format('d M Y - H:i') }} WIB</span>
                        </p>
                        <p class="flex items-center gap-2 font-semibold">
                            <i class="fa-solid fa-location-dot text-blue-600 text-sm"></i>
                            <span>{{ $event->location }}</span>
                        </p>
                    </div>

                    @if($event->image)
                        <div class="aspect-video w-full rounded-2xl overflow-hidden bg-slate-50">
                            <img src="{{ $event->image }}" class="w-full h-full object-cover" alt="{{ $event->title }}">
                        </div>
                    @endif

                    <div class="text-slate-650 text-sm leading-relaxed whitespace-pre-line space-y-4">
                        <h3 class="font-bold text-slate-900 border-b border-slate-50 pb-2">Deskripsi Kegiatan</h3>
                        {{ $event->description }}
                    </div>
                </div>
            </div>

            <!-- Right Column: RSVP & Attendees -->
            <div class="space-y-6">
                <!-- RSVP Form/Panel -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-3">Konfirmasi Kehadiran</h2>
                    
                    @auth
                        @if($event->date->isFuture())
                            <form action="{{ route('agenda.rsvp', $event->id) }}" method="POST" class="space-y-3">
                                @csrf
                                <label class="text-[10px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Status Kehadiran Anda</label>
                                
                                <div class="grid grid-cols-3 gap-2">
                                    <button type="submit" name="status" value="hadir" class="py-2.5 px-2 text-xs font-semibold rounded-lg border text-center transition-all {{ $myRsvp && $myRsvp->status == 'hadir' ? 'bg-emerald-500 border-emerald-500 text-white shadow-md shadow-emerald-500/10' : 'border-slate-200 hover:bg-slate-50 text-slate-700' }}">
                                        Hadir
                                    </button>
                                    <button type="submit" name="status" value="ragu_ragu" class="py-2.5 px-2 text-xs font-semibold rounded-lg border text-center transition-all {{ $myRsvp && $myRsvp->status == 'ragu_ragu' ? 'bg-amber-500 border-amber-500 text-white shadow-md shadow-amber-500/10' : 'border-slate-200 hover:bg-slate-50 text-slate-700' }}">
                                        Ragu-ragu
                                    </button>
                                    <button type="submit" name="status" value="tidak_hadir" class="py-2.5 px-2 text-xs font-semibold rounded-lg border text-center transition-all {{ $myRsvp && $myRsvp->status == 'tidak_hadir' ? 'bg-rose-500 border-rose-500 text-white shadow-md shadow-rose-500/10' : 'border-slate-200 hover:bg-slate-50 text-slate-700' }}">
                                        Absen
                                    </button>
                                </div>
                            </form>
                            @if($myRsvp)
                                <div class="p-3 bg-blue-50 border border-blue-100 text-blue-900 rounded-xl text-[11px] text-center font-semibold">
                                    Status Anda saat ini: <span class="uppercase font-bold">{{ $myRsvp->status }}</span>
                                </div>
                            @endif
                        @else
                            <div class="p-3 bg-slate-50 border border-slate-100 text-slate-550 rounded-xl text-xs text-center font-semibold">
                                Registrasi ditutup. Kegiatan ini telah selesai diselenggarakan.
                            </div>
                        @endif
                    @else
                        <div class="space-y-3 text-center py-2">
                            <p class="text-xs text-slate-500">Anda harus login terlebih dahulu untuk melakukan RSVP kehadiran agenda ini.</p>
                            <a href="{{ route('login') }}" class="block text-center text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 rounded-xl transition-colors">
                                Login Sekarang
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Attendee List -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center justify-between">
                        <span>Daftar Kehadiran</span>
                        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-800 rounded-full font-bold text-[9px]">{{ $rsvps->where('status', 'hadir')->count() }} Hadir</span>
                    </h2>
                    <div class="space-y-3 text-xs max-h-64 overflow-y-auto pr-1">
                        @forelse($rsvps as $rsvp)
                            <div class="flex items-center justify-between p-2.5 bg-slate-50 rounded-xl border border-slate-50">
                                <div class="min-w-0">
                                    <p class="font-bold text-slate-800 truncate">{{ $rsvp->user->name }}</p>
                                    <p class="text-[9px] text-slate-400">Angkatan {{ $rsvp->user->angkatan }} - {{ $rsvp->user->jurusan }}</p>
                                </div>
                                <span class="px-2 py-0.5 rounded-md font-bold text-[9px] uppercase tracking-wider {{ $rsvp->status == 'hadir' ? 'bg-emerald-100 text-emerald-800' : ($rsvp->status == 'ragu_ragu' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') }}">
                                    {{ $rsvp->status }}
                                </span>
                            </div>
                        @empty
                            <p class="text-slate-400 text-center py-4 text-xs">Belum ada respon kehadiran.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
