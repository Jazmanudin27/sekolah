@extends('layouts.app')

@section('title', 'Direktori Alumni - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Direktori Alumni</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Direktori Alumni</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Cari dan hubungi rekan-rekan alumni SMK Negeri 1 dari berbagai jurusan dan angkatan kelulusan.</p>
        </div>

        <!-- Filter Box -->
        <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-sm">
            <form action="{{ route('alumni') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4">
                <!-- Search Name -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-450">Nama Alumni</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <!-- Angkatan -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-450">Angkatan</label>
                    <select name="angkatan" class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Semua</option>
                        @foreach($angkatans as $angkatan)
                            <option value="{{ $angkatan }}" {{ request('angkatan') == $angkatan ? 'selected' : '' }}>{{ $angkatan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Jurusan -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-450">Jurusan</label>
                    <select name="jurusan" class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">Semua</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan }}" {{ request('jurusan') == $jurusan ? 'selected' : '' }}>{{ $jurusan }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Domisili -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-450">Kota Domisili</label>
                    <input type="text" name="domisili" value="{{ request('domisili') }}" placeholder="Kota..." class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <!-- Pekerjaan -->
                <div class="space-y-1">
                    <label class="text-[10px] font-bold uppercase tracking-wider text-slate-450">Pekerjaan</label>
                    <input type="text" name="pekerjaan" value="{{ request('pekerjaan') }}" placeholder="Pekerjaan..." class="w-full text-xs px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <!-- Actions -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-grow text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 py-2.5 rounded-lg transition-colors">
                        <i class="fa-solid fa-magnifying-glass mr-1"></i> Filter
                    </button>
                    <a href="{{ route('alumni') }}" class="px-3 py-2.5 border border-slate-200 text-slate-500 hover:bg-slate-50 rounded-lg text-xs font-medium transition-colors" title="Reset Filter">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                </div>
            </form>
        </div>

        <!-- Directory Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($alumni as $member)
                <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col justify-between hover:shadow-md transition-shadow relative">
                    <!-- Verification Badge -->
                    @if($member->status_verifikasi)
                        <span class="absolute top-4 right-4 flex h-6 w-6 items-center justify-center rounded-full bg-blue-50 text-blue-600 text-xs" title="Alumni Terverifikasi">
                            <i class="fa-solid fa-circle-check"></i>
                        </span>
                    @endif
                    
                    <div class="space-y-4 text-center">
                        <img src="{{ $member->foto ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?w=120' }}" class="w-20 h-20 rounded-full mx-auto object-cover border-2 border-slate-100 shadow-inner" alt="avatar">
                        
                        <div class="space-y-1">
                            <h3 class="font-bold text-slate-900 leading-tight truncate">
                                <a href="{{ route('alumni.detail', $member->id) }}" class="hover:text-blue-600">{{ $member->name }}</a>
                            </h3>
                            <p class="text-[10px] font-semibold text-blue-600 uppercase tracking-wider">Angkatan {{ $member->angkatan }} - {{ $member->jurusan }}</p>
                            <p class="text-[10px] text-slate-400">Tahun Lulus: {{ $member->tahun_lulus }}</p>
                        </div>
                        
                        <div class="text-[11px] text-slate-500 space-y-1 bg-slate-50 p-2.5 rounded-xl border border-slate-50 min-h-[50px] flex flex-col justify-center">
                            @if($member->pekerjaan)
                                <p class="font-semibold text-slate-700 truncate"><i class="fa-solid fa-briefcase mr-1.5 text-slate-400"></i>{{ $member->pekerjaan }}</p>
                            @endif
                            @if($member->domisili)
                                <p class="truncate"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400"></i>{{ $member->domisili }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 mt-4">
                        <a href="{{ route('alumni.detail', $member->id) }}" class="block text-center text-xs font-bold text-blue-600 hover:text-blue-700 py-1.5 bg-blue-50 hover:bg-blue-100/50 rounded-lg transition-colors">
                            Lihat Profil Lengkap
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 bg-white border border-slate-100 rounded-2xl text-center text-slate-500">
                    <i class="fa-solid fa-users text-4xl text-slate-300 mb-3"></i>
                    <p class="text-sm font-semibold">Alumni tidak ditemukan.</p>
                    <p class="text-xs text-slate-400 mt-1">Coba gunakan filter pencarian lainnya.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pt-4">
            {{ $alumni->links() }}
        </div>

    </div>
</div>
@endsection
