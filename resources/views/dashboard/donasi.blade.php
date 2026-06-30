@extends('layouts.app')

@section('title', 'Donasi Saya - Portal Alumni SMK Negeri 1')

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
                        <a href="{{ route('dashboard.event') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-calendar-check"></i> Event Saya
                        </a>
                        <a href="{{ route('dashboard.donasi') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-bold rounded-xl transition-all bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-wallet"></i> Donasi Saya
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Content Area -->
            <div class="lg:col-span-3">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-wallet text-blue-600"></i> Riwayat Donasi Anda
                    </h2>
                    
                    <div class="space-y-4">
                        @forelse($donations as $tx)
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between p-5 bg-slate-50 border border-slate-50 rounded-2xl gap-4 text-xs">
                                <div class="space-y-1">
                                    <h3 class="text-sm font-bold text-slate-900 hover:text-blue-600">
                                        <a href="{{ route('donasi.show', $tx->donation->slug) }}">{{ $tx->donation->title }}</a>
                                    </h3>
                                    <p class="text-slate-450">Tanggal: {{ $tx->created_at->format('d M Y - H:i') }} WIB</p>
                                    <p class="text-[10px] text-slate-500 font-semibold uppercase">Metode: {{ $tx->payment_method }}</p>
                                    @if($tx->message)
                                        <p class="text-slate-500 italic mt-1.5 leading-relaxed">"{{ $tx->message }}"</p>
                                    @endif
                                </div>
                                
                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <span class="block font-extrabold text-blue-700 text-sm">Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                                        <span class="text-[9px] uppercase font-bold px-1.5 py-0.5 rounded {{ $tx->status == 'completed' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $tx->status }}
                                        </span>
                                    </div>
                                    <button onclick="window.print()" class="px-2.5 py-1.5 border border-slate-200 hover:bg-slate-100 rounded-lg text-slate-650 font-bold transition-all text-[10px]">
                                        Cetak Bukti
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center text-slate-400">
                                <i class="fa-solid fa-hand-holding-dollar text-3xl mb-2 text-slate-300"></i>
                                <p class="text-xs">Anda belum pernah melakukan transaksi donasi apapun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
