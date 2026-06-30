@extends('layouts.app')

@section('title', $topic->title . ' - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 space-y-6">
        
        <!-- Navigation -->
        <div class="flex items-center justify-between">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <a href="{{ route('forum') }}" class="hover:text-blue-600">Forum</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500 truncate max-w-xs">{{ $topic->title }}</span>
            </nav>
            <a href="{{ route('forum') }}" class="text-xs font-semibold text-slate-500 hover:text-blue-600"><i class="fa-solid fa-chevron-left mr-1"></i> Kembali</a>
        </div>

        <!-- Main Topic Card -->
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6 sm:p-8 space-y-5">
            <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                <img src="{{ $topic->user->foto ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100' }}" class="w-10 h-10 rounded-full object-cover border border-slate-100" alt="avatar">
                <div class="min-w-0 text-xs">
                    <p class="font-bold text-slate-800">{{ $topic->user->name }}</p>
                    <p class="text-[9px] text-slate-400">Angkatan {{ $topic->user->angkatan }} - {{ $topic->user->jurusan }} | {{ $topic->created_at->diffForHumans() }}</p>
                </div>
            </div>
            
            <h1 class="text-xl font-extrabold text-slate-900 leading-snug">{{ $topic->title }}</h1>
            <p class="text-slate-650 text-sm leading-relaxed whitespace-pre-line">
                {{ $topic->content }}
            </p>
        </div>

        <!-- Replies Section -->
        <div class="space-y-4">
            <h2 class="text-sm font-bold uppercase tracking-wider text-slate-450 border-b border-slate-200 pb-2"><i class="fa-solid fa-comments text-blue-600 mr-1.5"></i> Balasan ({{ $topic->replies->count() }})</h2>
            
            <div class="space-y-4">
                @forelse($topic->replies as $reply)
                    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 space-y-3">
                        <div class="flex items-center gap-3 border-b border-slate-50 pb-3">
                            <img src="{{ $reply->user->foto ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=100' }}" class="w-8 h-8 rounded-full object-cover border border-slate-100" alt="avatar">
                            <div class="min-w-0 text-[11px]">
                                <p class="font-bold text-slate-800">{{ $reply->user->name }}</p>
                                <p class="text-[9px] text-slate-400">Angkatan {{ $reply->user->angkatan }} &bull; {{ $reply->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-slate-650 text-xs leading-relaxed whitespace-pre-line">
                            {{ $reply->content }}
                        </p>
                    </div>
                @empty
                    <p class="text-slate-400 text-xs text-center py-6">Belum ada tanggapan untuk diskusi ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Reply Form -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b border-slate-50 pb-2">Balas Diskusi</h3>
            
            @auth
                <form action="{{ route('forum.reply.submit', $topic->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div class="space-y-1">
                        <textarea name="content" rows="4" required placeholder="Tuliskan tanggapan atau opini Anda..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-xs"></textarea>
                    </div>
                    <button type="submit" class="font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 px-6 rounded-lg transition-colors">
                        Kirim Balasan <i class="fa-solid fa-paper-plane ml-1"></i>
                    </button>
                </form>
            @else
                <div class="text-center py-4 space-y-3">
                    <p class="text-xs text-slate-500">Anda harus login terlebih dahulu untuk memberikan komentar/balasan.</p>
                    <a href="{{ route('login') }}" class="inline-block text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-2 px-6 rounded-lg transition-colors">
                        Login Sekarang
                    </a>
                </div>
            @endauth
        </div>

    </div>
</div>
@endsection
