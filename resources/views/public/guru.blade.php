@extends('layouts.app')

@section('title', 'Direktori Guru & Staf - Portal Sekolah')

@section('content')
<div class="relative bg-slate-900 overflow-hidden py-16 sm:py-24 mb-12">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500/10 rounded-full uppercase tracking-wider">Tenaga Kependidikan</span>
        <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Profil Guru & Staf</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Temui para pendidik profesional dan dedikatif yang membimbing siswa meraih prestasi tinggi.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <!-- Grid of Teachers -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($teachers as $teacher)
            <div class="group bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col items-center text-center p-6">
                <!-- Avatar -->
                <div class="relative w-32 h-32 rounded-full overflow-hidden border-2 border-blue-500 p-1 group-hover:scale-105 transition-transform duration-300 mb-6">
                    <img src="{{ $teacher->foto ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200' }}" 
                        alt="{{ $teacher->name }}" class="w-full h-full object-cover rounded-full">
                </div>
                
                <!-- Info -->
                <div class="flex-grow">
                    <h3 class="text-base font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors">{{ $teacher->name }}</h3>
                    <p class="text-xs font-semibold text-blue-600 uppercase tracking-wider mt-1.5">{{ $teacher->subject }}</p>
                    <p class="text-sm text-slate-500 font-medium mt-1">{{ $teacher->role }}</p>
                    @if($teacher->nip)
                        <small class="text-xs text-slate-400 block mt-2 font-mono">NIP: {{ $teacher->nip }}</small>
                    @else
                        <small class="text-xs text-slate-400 block mt-2">NUPTK: -</small>
                    @endif
                </div>

                <!-- Action / Decorative Contact -->
                <div class="w-full border-t border-slate-100 mt-6 pt-4 flex justify-center gap-4 text-slate-400">
                    <a href="#" class="hover:text-blue-600 transition-colors"><i class="fa-solid fa-envelope text-lg"></i></a>
                    <a href="#" class="hover:text-emerald-500 transition-colors"><i class="fa-brands fa-whatsapp text-lg"></i></a>
                    <a href="#" class="hover:text-sky-500 transition-colors"><i class="fa-solid fa-circle-info text-lg"></i></a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-slate-450 font-medium">
                <i class="fa-solid fa-chalkboard-user fs-1 block mb-3 text-slate-300"></i>
                Belum ada data profil guru yang tersimpan.
            </div>
        @endforelse
    </div>
</div>
@endsection
