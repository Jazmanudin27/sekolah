@extends('layouts.app')

@section('title', 'Prestasi Sekolah - Portal Sekolah')

@section('content')
<div class="relative bg-slate-900 overflow-hidden py-16 sm:py-24 mb-12">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500/10 rounded-full uppercase tracking-wider">Hall of Fame</span>
        <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Prestasi & Penghargaan</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Catatan torehan prestasi gemilang siswa-siswi SMK Negeri 1 di bidang akademik maupun non-akademik.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <!-- Category Tabs -->
    <div class="flex justify-center gap-3 mb-12">
        <a href="{{ route('prestasi') }}" 
            class="px-5 py-2 text-sm font-semibold rounded-xl transition-all {{ !request('category') ? 'bg-blue-600 text-white shadow-md shadow-blue-600/15' : 'bg-white text-slate-650 hover:bg-slate-50 border border-slate-150' }}">
            Semua Kategori
        </a>
        <a href="{{ route('prestasi', ['category' => 'akademik']) }}" 
            class="px-5 py-2 text-sm font-semibold rounded-xl transition-all {{ request('category') == 'akademik' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/15' : 'bg-white text-slate-650 hover:bg-slate-50 border border-slate-150' }}">
            Akademik
        </a>
        <a href="{{ route('prestasi', ['category' => 'non-akademik']) }}" 
            class="px-5 py-2 text-sm font-semibold rounded-xl transition-all {{ request('category') == 'non-akademik' ? 'bg-blue-600 text-white shadow-md shadow-blue-600/15' : 'bg-white text-slate-650 hover:bg-slate-50 border border-slate-150' }}">
            Non-Akademik
        </a>
    </div>

    <!-- Achievement Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($achievements as $ach)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col h-full">
                <!-- Image Wrapper -->
                <div class="relative aspect-video w-full overflow-hidden bg-slate-100 flex-shrink-0">
                    <img src="{{ $ach->image ?? 'https://images.unsplash.com/photo-1505156868547-9b49f4df4e04?w=800' }}" 
                        alt="{{ $ach->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                    <span class="absolute top-4 left-4 px-2.5 py-1 bg-amber-500 text-white text-[10px] font-extrabold uppercase rounded-md tracking-wider">Tahun {{ $ach->year }}</span>
                    @if($ach->category == 'akademik')
                        <span class="absolute top-4 right-4 px-2.5 py-1 bg-blue-600/90 text-white text-[10px] font-bold rounded-md backdrop-blur-sm">Akademik</span>
                    @else
                        <span class="absolute top-4 right-4 px-2.5 py-1 bg-purple-600/90 text-white text-[10px] font-bold rounded-md backdrop-blur-sm">Non-Akademik</span>
                    @endif
                </div>
                
                <!-- Details -->
                <div class="p-6 flex-grow flex flex-col justify-between">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors leading-tight">{{ $ach->title }}</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">{{ $ach->description }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-450 font-medium">
                <i class="fa-solid fa-trophy fs-1 block mb-3 text-slate-300"></i>
                Belum ada catatan prestasi yang ditambahkan untuk kategori ini.
            </div>
        @endforelse
    </div>
</div>
@endsection
