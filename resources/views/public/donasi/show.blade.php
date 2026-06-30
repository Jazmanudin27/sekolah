@extends('layouts.app')

@section('title', $donation->title . ' - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left: Campaign details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Navigation -->
                <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                    <i class="fa-solid fa-angle-right text-[8px]"></i>
                    <a href="{{ route('donasi') }}" class="hover:text-blue-600">Donasi</a>
                    <i class="fa-solid fa-angle-right text-[8px]"></i>
                    <span class="text-slate-500 truncate max-w-xs">{{ $donation->title }}</span>
                </nav>

                <!-- Detailed Campaign Card -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-6 sm:p-8 space-y-6">
                    <span class="inline-flex px-2.5 py-1 bg-blue-50 text-blue-800 text-[10px] font-bold uppercase tracking-wider rounded-lg">
                        {{ $donation->type }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">{{ $donation->title }}</h1>
                    
                    @if($donation->image)
                        <div class="aspect-video w-full rounded-2xl overflow-hidden bg-slate-50">
                            <img src="{{ $donation->image }}" class="w-full h-full object-cover" alt="{{ $donation->title }}">
                        </div>
                    @endif

                    <div class="text-slate-650 text-sm leading-relaxed whitespace-pre-line space-y-4">
                        <h3 class="font-bold text-slate-900 border-b border-slate-50 pb-2">Deskripsi Penggalangan Dana</h3>
                        {{ $donation->description }}
                    </div>
                </div>
            </div>

            <!-- Right: Donation Form & Donor list -->
            <div class="space-y-6">
                <!-- Form Donasi -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-3">Kirim Donasi</h2>
                    
                    @php
                        $percentage = min(100, round(($donation->raised_amount / $donation->target_amount) * 100));
                    @endphp
                    <div class="space-y-2">
                        <div class="flex items-center justify-between text-xs font-bold">
                            <span class="text-blue-700">Rp {{ number_format($donation->raised_amount, 0, ',', '.') }}</span>
                            <span class="text-slate-450">{{ $percentage }}%</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-blue-600 rounded-full" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-[9px] text-slate-400">
                            <span>Target: Rp {{ number_format($donation->target_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('donasi.submit', $donation->id) }}" method="POST" class="space-y-4 pt-4 border-t border-slate-150 text-xs">
                        @csrf
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Nama Donatur</label>
                            <input type="text" name="donor_name" value="{{ Auth::check() ? Auth::user()->name : 'Hamba Allah' }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Nominal Donasi (Rp)</label>
                            <input type="number" name="amount" min="10000" step="5000" placeholder="Min. Rp 10.000" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Metode Pembayaran</label>
                            <select name="payment_method" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="Bank Transfer">Bank Transfer (BRI/BCA/Mandiri)</option>
                                <option value="GoPay">GoPay / ShopeePay / QRIS</option>
                                <option value="Credit Card">Kartu Kredit</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Pesan Baik (Opsional)</label>
                            <textarea name="message" rows="3" placeholder="Pesan atau doa untuk almamater..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                        </div>

                        <button type="submit" class="w-full font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-colors shadow-md shadow-blue-500/10">
                            Kirim Donasi <i class="fa-solid fa-heart-circle-check ml-1.5"></i>
                        </button>
                    </form>
                </div>

                <!-- Recent Transactions -->
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center justify-between">
                        <span>Riwayat Donatur</span>
                        <span class="px-2.5 py-0.5 bg-blue-50 text-blue-800 rounded-full font-bold text-[9px]">{{ $transactions->count() }} Orang</span>
                    </h2>
                    
                    <div class="space-y-3.5 max-h-60 overflow-y-auto pr-1 text-[11px]">
                        @forelse($transactions as $tx)
                            <div class="space-y-1.5 p-3 bg-slate-50 rounded-2xl border border-slate-50">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-slate-800">{{ $tx->donor_name }}</span>
                                    <span class="font-bold text-blue-700">Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                                </div>
                                @if($tx->message)
                                    <p class="text-slate-500 italic leading-relaxed">"{{ $tx->message }}"</p>
                                @endif
                                <p class="text-[9px] text-slate-400">{{ $tx->created_at->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-slate-400 text-center py-4">Belum ada donasi terkirim.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
