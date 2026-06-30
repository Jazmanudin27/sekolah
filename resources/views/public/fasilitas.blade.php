@extends('layouts.app')

@section('title', 'Sarana & Fasilitas Sekolah - Portal Sekolah')

@section('content')
<div class="relative bg-slate-900 overflow-hidden py-16 sm:py-24 mb-12">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500/10 rounded-full uppercase tracking-wider">Sarana & Prasarana</span>
        <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Fasilitas SMK Negeri 1</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Kami menyediakan infrastruktur penunjang belajar berstandar industri demi menjamin kompetensi keahlian siswa.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <!-- Grid of Facilities -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($facilities as $facility)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col h-full">
                <!-- Image Wrapper -->
                <div class="relative aspect-video w-full overflow-hidden bg-slate-100 flex-shrink-0">
                    <img src="{{ $facility->image ?? 'https://images.unsplash.com/photo-1562774053-701939374585?w=800' }}" 
                        alt="{{ $facility->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                    <span class="absolute bottom-4 left-4 px-3 py-1 bg-blue-600/90 text-white text-xs font-semibold rounded-lg backdrop-blur-sm">Fasilitas Unggulan</span>
                </div>
                
                <!-- Details -->
                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $facility->name }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed flex-grow">{{ $facility->description }}</p>
                    <div class="border-t border-slate-100 mt-6 pt-4 flex items-center justify-between text-xs text-slate-400 font-semibold">
                        <span>Standar Nasional & Industri</span>
                        <span class="text-blue-600">Aktif & Terawat <i class="fa-solid fa-circle-check text-emerald-500 ml-1"></i></span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-450 font-medium">
                <i class="fa-solid fa-school-flag fs-1 block mb-3 text-slate-300"></i>
                Belum ada data fasilitas sekolah yang ditambahkan.
            </div>
        @endforelse
    </div>
</div>
@endsection
