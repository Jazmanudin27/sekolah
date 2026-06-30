@extends('layouts.app')

@section('title', 'Donasi Alumni - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Donasi</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Donasi & Kontribusi Alumni</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Mari berpartisipasi menyalurkan donasi terbaik Anda demi mendukung renovasi sarana prasarana sekolah dan program beasiswa.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Campaign Cards -->
            <div class="lg:col-span-2 space-y-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($donations as $campaign)
                        @php
                            $percentage = min(100, round(($campaign->raised_amount / $campaign->target_amount) * 100));
                        @endphp
                        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow">
                            <div class="aspect-video relative overflow-hidden bg-slate-100">
                                <img src="{{ $campaign->image }}" class="w-full h-full object-cover" alt="{{ $campaign->title }}">
                                <span class="absolute top-4 left-4 px-2.5 py-1 bg-white/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-blue-800 rounded-lg">
                                    {{ $campaign->type }}
                                </span>
                            </div>
                            <div class="p-6 space-y-4 flex-grow flex flex-col justify-between">
                                <div class="space-y-2">
                                    <h3 class="text-base font-bold text-slate-900 leading-snug">
                                        <a href="{{ route('donasi.show', $campaign->slug) }}" class="hover:text-blue-600">{{ $campaign->title }}</a>
                                    </h3>
                                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                                        {{ $campaign->description }}
                                    </p>
                                </div>
                                
                                <div class="space-y-3.5 pt-4 border-t border-slate-50">
                                    <!-- Progress Bar -->
                                    <div class="space-y-1">
                                        <div class="flex items-center justify-between text-[10px] font-bold">
                                            <span class="text-blue-600">Rp {{ number_format($campaign->raised_amount, 0, ',', '.') }}</span>
                                            <span class="text-slate-400">{{ $percentage }}% Terkumpul</span>
                                        </div>
                                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-600 rounded-full transition-all" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-[10px] text-slate-400">
                                        <span>Target Donasi:</span>
                                        <span class="font-bold text-slate-800">Rp {{ number_format($campaign->target_amount, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    <a href="{{ route('donasi.show', $campaign->slug) }}" class="block text-center text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 rounded-xl transition-colors">
                                        Donasikan Sekarang <i class="fa-solid fa-heart ml-1 text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm col-span-full">Belum ada penggalangan donasi aktif.</p>
                    @endforelse
                </div>
            </div>

            <!-- Right: Top Donors leaderboard -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-6">
                    <h2 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-medal text-amber-500 text-lg"></i> Donatur Terbesar
                    </h2>
                    <div class="space-y-4">
                        @forelse($topDonors as $index => $donor)
                            <div class="flex items-center justify-between p-3 bg-slate-50 rounded-2xl border border-slate-50 text-xs">
                                <div class="flex items-center gap-2.5 min-w-0">
                                    <span class="flex h-5 w-5 items-center justify-center rounded-full text-[10px] font-bold {{ $index == 0 ? 'bg-amber-100 text-amber-800' : ($index == 1 ? 'bg-slate-200 text-slate-800' : 'bg-orange-100 text-orange-800') }}">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="font-bold text-slate-800 truncate">{{ $donor->donor_name }}</span>
                                </div>
                                <span class="font-bold text-blue-700">Rp {{ number_format($donor->total, 0, ',', '.') }}</span>
                            </div>
                        @empty
                            <p class="text-slate-400 text-xs text-center py-4">Belum ada transaksi donasi.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
