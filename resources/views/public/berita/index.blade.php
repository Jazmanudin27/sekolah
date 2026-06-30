@extends('layouts.app')

@section('title', 'Berita & Kegiatan - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Berita & Kegiatan</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Berita & Kegiatan</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Dapatkan informasi berita sekolah, pengumuman ikatan alumni, artikel, serta rilis kegiatan terupdate.</p>
        </div>

        <!-- Categories Filters -->
        <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-4">
            <a href="{{ route('berita') }}" class="px-4 py-2 text-xs font-bold rounded-lg transition-colors {{ !request('category') ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' : 'bg-white text-slate-650 hover:bg-slate-100 border border-slate-200' }}">Semua Kategori</a>
            <a href="{{ route('berita', ['category' => 'sekolah']) }}" class="px-4 py-2 text-xs font-bold rounded-lg transition-colors {{ request('category') == 'sekolah' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' : 'bg-white text-slate-650 hover:bg-slate-100 border border-slate-200' }}">Berita Sekolah</a>
            <a href="{{ route('berita', ['category' => 'alumni']) }}" class="px-4 py-2 text-xs font-bold rounded-lg transition-colors {{ request('category') == 'alumni' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' : 'bg-white text-slate-650 hover:bg-slate-100 border border-slate-200' }}">Berita Alumni</a>
            <a href="{{ route('berita', ['category' => 'pengumuman']) }}" class="px-4 py-2 text-xs font-bold rounded-lg transition-colors {{ request('category') == 'pengumuman' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' : 'bg-white text-slate-650 hover:bg-slate-100 border border-slate-200' }}">Pengumuman</a>
            <a href="{{ route('berita', ['category' => 'artikel']) }}" class="px-4 py-2 text-xs font-bold rounded-lg transition-colors {{ request('category') == 'artikel' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/10' : 'bg-white text-slate-650 hover:bg-slate-100 border border-slate-200' }}">Artikel</a>
        </div>

        <!-- News Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                    <div class="aspect-video bg-slate-100 relative overflow-hidden">
                        <img src="{{ $post->image }}" class="w-full h-full object-cover" alt="{{ $post->title }}">
                        <span class="absolute top-4 left-4 px-2.5 py-1 bg-white/95 backdrop-blur-sm text-[9px] font-bold uppercase tracking-wider text-blue-800 rounded-lg">
                            {{ $post->category }}
                        </span>
                    </div>
                    <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                        <div class="space-y-2">
                            <p class="text-slate-400 text-[10px] font-medium"><i class="fa-solid fa-calendar mr-1"></i>{{ $post->created_at->format('d M Y') }}</p>
                            <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                <a href="{{ route('berita.show', $post->slug) }}" class="hover:text-blue-600">{{ $post->title }}</a>
                            </h3>
                            <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                                {{ strip_tags($post->content) }}
                            </p>
                        </div>
                        <a href="{{ route('berita.show', $post->slug) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                            Baca Selengkapnya <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 bg-white border border-slate-100 rounded-3xl text-center text-slate-500">
                    <i class="fa-solid fa-newspaper text-4xl text-slate-300 mb-3"></i>
                    <p class="text-sm font-semibold">Belum ada berita diterbitkan.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $posts->links() }}
        </div>

    </div>
</div>
@endsection
