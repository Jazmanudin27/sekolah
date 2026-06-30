@extends('layouts.app')

@section('title', 'Ekstrakurikuler Siswa - Portal Sekolah')

@section('content')
<div class="relative bg-slate-900 overflow-hidden py-16 sm:py-24 mb-12">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500/10 rounded-full uppercase tracking-wider">Kreativitas & Minat</span>
        <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Ekstrakurikuler Sekolah</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Wadah pengembangan bakat kepemimpinan, seni, olahraga, dan kreativitas luar kelas bagi seluruh siswa kami.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <!-- Grid of Extracurriculars -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @forelse($ekstras as $ekstra)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col h-full">
                <!-- Image Wrapper -->
                <div class="relative aspect-video w-full overflow-hidden bg-slate-100 flex-shrink-0">
                    <img src="{{ $ekstra->image ?? 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800' }}" 
                        alt="{{ $ekstra->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 to-transparent"></div>
                </div>
                
                <!-- Details -->
                <div class="p-6 flex-grow flex flex-col">
                    <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $ekstra->name }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed flex-grow">{{ $ekstra->description }}</p>
                    
                    <div class="bg-slate-50 p-3.5 rounded-xl mt-6 flex items-center gap-3 border border-slate-100/50">
                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-100 text-blue-600 text-sm flex-shrink-0"><i class="fa-solid fa-user-tie"></i></span>
                        <div class="min-w-0">
                            <span class="block text-[10px] text-slate-400 font-semibold uppercase leading-none">Pembina / Mentor</span>
                            <span class="text-xs font-bold text-slate-800 truncate block mt-1">{{ $ekstra->mentor }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-450 font-medium">
                <i class="fa-solid fa-people-group fs-1 block mb-3 text-slate-300"></i>
                Belum ada data ekstrakurikuler yang tersimpan.
            </div>
        @endforelse
    </div>
</div>
@endsection
