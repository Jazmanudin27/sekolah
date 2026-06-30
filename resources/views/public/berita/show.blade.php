@extends('layouts.app')

@section('title', $post->title . ' - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Article Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Navigation -->
                <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                    <i class="fa-solid fa-angle-right text-[8px]"></i>
                    <a href="{{ route('berita') }}" class="hover:text-blue-600">Berita</a>
                    <i class="fa-solid fa-angle-right text-[8px]"></i>
                    <span class="text-slate-500 truncate max-w-xs">{{ $post->title }}</span>
                </nav>

                <!-- Post detail card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">
                    <span class="inline-flex px-2.5 py-1 bg-blue-50 text-blue-800 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                        {{ $post->category }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">{{ $post->title }}</h1>
                    
                    <div class="flex items-center gap-4 text-xs text-slate-400 pb-4 border-b border-slate-100">
                        <p><i class="fa-solid fa-calendar mr-1.5"></i>{{ $post->created_at->format('d M Y') }}</p>
                        <p><i class="fa-solid fa-user mr-1.5"></i>Diterbitkan oleh Admin</p>
                    </div>

                    @if($post->image)
                        <div class="aspect-video w-full rounded-2xl overflow-hidden bg-slate-50">
                            <img src="{{ $post->image }}" class="w-full h-full object-cover animate-fade-in" alt="{{ $post->title }}">
                        </div>
                    @endif

                    <div class="text-slate-650 text-sm leading-relaxed whitespace-pre-line space-y-4">
                        {{ $post->content }}
                    </div>
                </div>
            </div>

            <!-- Right: Related Posts -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-6">
                    <h2 class="text-base font-bold text-slate-900 border-b border-slate-100 pb-3">Berita Terbaru Lainnya</h2>
                    <div class="space-y-4">
                        @foreach($related as $rel)
                            <div class="flex gap-3 text-xs align-middle">
                                <img src="{{ $rel->image }}" class="w-16 h-12 rounded-lg object-cover bg-slate-100" alt="{{ $rel->title }}">
                                <div class="space-y-1 min-w-0">
                                    <h3 class="font-bold text-slate-900 leading-snug line-clamp-2 hover:text-blue-600">
                                        <a href="{{ route('berita.show', $rel->slug) }}">{{ $rel->title }}</a>
                                    </h3>
                                    <p class="text-[10px] text-slate-400">{{ $rel->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
