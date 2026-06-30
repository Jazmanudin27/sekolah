@extends('layouts.app')

@section('title', 'Galeri Sekolah - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Galeri</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Galeri Dokumentasi</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Dokumentasi foto dan video kegiatan reuni akbar, aksi sosial, seminar karir, serta sarana prasarana sekolah.</p>
        </div>

        <!-- Photos Grid -->
        <div class="space-y-6">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3"><i class="fa-solid fa-camera text-blue-600 mr-1.5"></i> Galeri Foto</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($photos as $pic)
                    <div class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow group">
                        <div class="aspect-square bg-slate-100 overflow-hidden relative">
                            <img src="{{ $pic->url }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform" alt="{{ $pic->title }}">
                            <span class="absolute bottom-3 left-3 px-2 py-0.5 bg-black/70 backdrop-blur-sm text-[9px] font-bold text-white rounded-md uppercase tracking-wider">
                                {{ $pic->category }}
                            </span>
                        </div>
                        <div class="p-4 text-xs font-bold text-slate-800 leading-tight">
                            {{ $pic->title }}
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 text-xs py-4 col-span-full">Belum ada foto galeri.</p>
                @endforelse
            </div>
        </div>

        <!-- Videos Grid -->
        <div class="space-y-6">
            <h2 class="text-lg font-bold text-slate-900 border-b border-slate-200 pb-3"><i class="fa-solid fa-video text-blue-600 mr-1.5"></i> Galeri Video</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($videos as $vid)
                    <div class="bg-white border border-slate-100 shadow-sm rounded-2xl overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                        <div class="aspect-video bg-slate-950 flex items-center justify-center relative">
                            <!-- Placeholder cover or real if possible -->
                            <img src="https://images.unsplash.com/photo-1511578314322-379afb476865?w=400" class="w-full h-full object-cover opacity-50 absolute inset-0" alt="Video cover">
                            <a href="{{ $vid->url }}" target="_blank" class="h-10 w-10 rounded-full bg-white text-blue-900 flex items-center justify-center text-sm shadow-md hover:scale-110 transition-transform relative z-10">
                                <i class="fa-solid fa-play"></i>
                            </a>
                            <span class="absolute bottom-3 left-3 px-2 py-0.5 bg-black/70 backdrop-blur-sm text-[9px] font-bold text-white rounded-md uppercase tracking-wider">
                                {{ $vid->category }}
                            </span>
                        </div>
                        <div class="p-4 text-xs font-bold text-slate-800 leading-tight">
                            {{ $vid->title }}
                        </div>
                    </div>
                @empty
                    <p class="text-slate-500 text-xs py-4 col-span-full">Belum ada video galeri.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
