@extends('layouts.app')

@section('title', 'Detail Profil Alumni - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header / Navigation -->
        <div class="flex items-center justify-between">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <a href="{{ route('alumni') }}" class="hover:text-blue-600">Direktori</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">{{ $alumnus->name }}</span>
            </nav>
            <a href="{{ route('alumni') }}" class="text-xs font-semibold text-slate-500 hover:text-blue-600"><i class="fa-solid fa-chevron-left mr-1"></i> Kembali</a>
        </div>

        <!-- Main Card layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Card: Avatar & Basic Meta -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm text-center space-y-6">
                <div class="relative inline-block">
                    <img src="{{ $alumnus->foto ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=160' }}" class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-slate-50 shadow-md" alt="avatar">
                    @if($alumnus->status_verifikasi)
                        <span class="absolute bottom-1 right-1 flex h-7 w-7 items-center justify-center rounded-full bg-blue-600 text-white border-2 border-white text-xs" title="Alumni Terverifikasi">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    @endif
                </div>

                <div class="space-y-1">
                    <h2 class="text-lg font-bold text-slate-900 leading-snug">{{ $alumnus->name }}</h2>
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider">Angkatan {{ $alumnus->angkatan }}</p>
                    <p class="text-[10px] text-slate-400 font-medium">Jurusan: {{ $alumnus->jurusan }} | Lulus: {{ $alumnus->tahun_lulus }}</p>
                </div>

                <!-- Media Sosial -->
                @if($alumnus->media_sosial)
                    <div class="flex items-center justify-center gap-3 pt-4 border-t border-slate-50 text-slate-450">
                        @foreach($alumnus->media_sosial as $platform => $url)
                            @if($url)
                                <a href="https://{{ $url }}" target="_blank" class="hover:text-blue-600 text-base" title="{{ ucfirst($platform) }}">
                                    @if($platform == 'linkedin')
                                        <i class="fa-brands fa-linkedin"></i>
                                    @elseif($platform == 'github')
                                        <i class="fa-brands fa-github"></i>
                                    @elseif($platform == 'instagram')
                                        <i class="fa-brands fa-instagram"></i>
                                    @else
                                        <i class="fa-solid fa-link"></i>
                                    @endif
                                </a>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Card: Full Details -->
            <div class="md:col-span-2 space-y-6">
                <!-- Bio & Career Details -->
                <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Tentang Saya</h3>
                        <p class="text-sm text-slate-600 leading-relaxed italic">
                            "{{ $alumnus->bio ?? 'Alumni belum menuliskan deskripsi profil singkat.' }}"
                        </p>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-6 border-t border-slate-50 text-xs">
                        <div class="space-y-1">
                            <p class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Pekerjaan Sekarang</p>
                            <p class="font-semibold text-slate-800"><i class="fa-solid fa-briefcase mr-1.5 text-blue-500"></i>{{ $alumnus->pekerjaan ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Domisili Saat Ini</p>
                            <p class="font-semibold text-slate-800"><i class="fa-solid fa-location-dot mr-1.5 text-blue-500"></i>{{ $alumnus->domisili ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Pendidikan Terakhir</p>
                            <p class="font-semibold text-slate-800"><i class="fa-solid fa-user-graduate mr-1.5 text-blue-500"></i>{{ $alumnus->pendidikan_terakhir ?? '-' }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="font-bold text-slate-400 uppercase tracking-wider text-[10px]">Hubungi Alumni</p>
                            @if($alumnus->kontak_whatsapp)
                                <a href="https://wa.me/{{ $alumnus->kontak_whatsapp }}" target="_blank" class="inline-flex items-center gap-1 font-bold text-emerald-600 hover:text-emerald-700">
                                    <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i> WhatsApp Alumni
                                </a>
                            @else
                                <p class="text-slate-500">Kontak disembunyikan</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
