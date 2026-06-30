@extends('layouts.app')

@section('title', 'Portal Ikatan Alumni - SMK Negeri 1')

@section('content')
<!-- Hero Section / Banner -->
<section class="relative bg-gradient-brand text-white overflow-hidden py-24 md:py-32">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/25 border border-blue-400/20 text-xs font-semibold uppercase tracking-wider text-blue-200">
                    <span class="h-2 w-2 rounded-full bg-blue-400 animate-ping"></span>
                    Portal Resmi Ikatan Alumni (IKA)
                </span>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight">
                    Terhubung Kembali, <br>
                    <span class="text-blue-300">Kolaborasi & Berbagi</span>
                </h1>
                <p class="text-base sm:text-lg text-blue-100 max-w-xl leading-relaxed">
                    Wadah silaturahmi seluruh keluarga besar alumni SMK Negeri 1. Bangun jaringan profesional, dapatkan info karir terbaru, dan berikan kontribusi terbaik Anda.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('register') }}" class="px-6 py-3.5 bg-white text-blue-900 hover:bg-slate-100 font-bold rounded-xl shadow-lg transition-all flex items-center gap-2">
                        <i class="fa-solid fa-user-plus"></i> Gabung Alumni
                    </a>
                    <a href="{{ route('donasi') }}" class="px-6 py-3.5 bg-blue-550 text-white hover:bg-blue-600 font-bold rounded-xl border border-blue-400/40 shadow-lg shadow-blue-650/20 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-heart-pulse"></i> Donasi Sekarang
                    </a>
                </div>
            </div>
            <div class="hidden lg:block relative">
                <!-- Stacked grid mockup of alumni network -->
                <div class="relative w-full max-w-md mx-auto aspect-square bg-white/5 border border-white/10 rounded-3xl p-6 backdrop-blur-sm overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-900/30 to-blue-500/10"></div>
                    <!-- Mock profile circles -->
                    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 h-36 w-36 rounded-full border-4 border-blue-500/30 bg-blue-600/20 flex items-center justify-center animate-pulse">
                        <i class="fa-solid fa-network-wired text-4xl text-blue-200"></i>
                    </div>
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100" class="absolute top-12 left-12 w-14 h-14 rounded-full border-2 border-white object-cover" alt="alumni">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" class="absolute bottom-16 left-16 w-12 h-12 rounded-full border-2 border-white object-cover" alt="alumni">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=100" class="absolute top-20 right-16 w-16 h-16 rounded-full border-2 border-white object-cover" alt="alumni">
                    <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100" class="absolute bottom-24 right-12 w-14 h-14 rounded-full border-2 border-white object-cover" alt="alumni">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Greetings Section -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 lg:gap-20">
            <!-- Greeting 1: Headmaster -->
            <div class="flex flex-col sm:flex-row gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=120" class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover shadow-md" alt="Kepala Sekolah">
                </div>
                <div class="space-y-3">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Sambutan Almamater</span>
                    <h3 class="text-xl font-bold text-blue-950">Drs. H. Mulyono, M.Pd</h3>
                    <p class="text-slate-500 text-xs italic leading-tight">Kepala Sekolah SMKN 1</p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        "Sekolah selalu bangga atas dedikasi para alumni. Tetaplah terhubung untuk saling membagi inspirasi serta mendukung adik-adik kelas."
                    </p>
                </div>
            </div>

            <!-- Greeting 2: Chairman -->
            <div class="flex flex-col sm:flex-row gap-6 p-6 rounded-2xl bg-slate-50 border border-slate-100">
                <div class="flex-shrink-0">
                    <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=120" class="w-24 h-24 sm:w-28 sm:h-28 rounded-2xl object-cover shadow-md" alt="Ketua Alumni">
                </div>
                <div class="space-y-3">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-widest">Sambutan Pengurus</span>
                    <h3 class="text-xl font-bold text-blue-950">Hendra Wijaya, S.T.</h3>
                    <p class="text-slate-500 text-xs italic leading-tight">Ketua Umum Ikatan Alumni</p>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        "Mari kita pererat tali silaturahmi. Bersama-sama, kita bisa membangun ikatan yang saling mendukung kemajuan karir dan pembangunan sekolah."
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="bg-gradient-brand text-white py-16 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:24px_24px]"></div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_alumni'] }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Total Alumni</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_angkatan'] }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Total Angkatan</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_donatur'] }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Total Donatur</p>
            </div>
            <div class="space-y-2">
                <p class="text-4xl sm:text-5xl font-extrabold tracking-tight text-blue-300">{{ $stats['total_kegiatan'] }}</p>
                <p class="text-xs sm:text-sm font-semibold uppercase tracking-wider text-blue-100">Total Kegiatan</p>
            </div>
        </div>
    </div>
</section>

<!-- News & Events Grid -->
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- News Column (Left 2 cols) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                        <i class="fa-solid fa-newspaper text-blue-600 mr-2"></i>Berita & Kegiatan Alumni
                    </h2>
                    <a href="{{ route('berita') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @forelse($news as $item)
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col hover:shadow-md transition-shadow">
                            <div class="aspect-video relative overflow-hidden bg-slate-100">
                                <img src="{{ $item->image }}" class="w-full h-full object-cover" alt="{{ $item->title }}">
                                <span class="absolute top-3 left-3 px-2.5 py-1 bg-white/95 backdrop-blur-sm text-[10px] font-bold uppercase tracking-wider text-blue-800 rounded-lg">
                                    {{ $item->category }}
                                </span>
                            </div>
                            <div class="p-5 flex-grow flex flex-col justify-between space-y-4">
                                <div class="space-y-2">
                                    <p class="text-slate-400 text-[10px] font-medium"><i class="fa-solid fa-calendar mr-1"></i>{{ $item->created_at->format('d M Y') }}</p>
                                    <h3 class="text-base font-bold text-slate-900 leading-snug line-clamp-2">
                                        <a href="{{ route('berita.show', $item->slug) }}" class="hover:text-blue-600">{{ $item->title }}</a>
                                    </h3>
                                    <p class="text-slate-500 text-xs leading-relaxed line-clamp-3">
                                        {{ strip_tags($item->content) }}
                                    </p>
                                </div>
                                <a href="{{ route('berita.show', $item->slug) }}" class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                    Baca Selengkapnya <i class="fa-solid fa-angle-right"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm">Belum ada berita.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Events Column (Right 1 col) -->
            <div class="space-y-8">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <h2 class="text-2xl font-bold tracking-tight text-slate-900">
                        <i class="fa-solid fa-calendar-days text-blue-600 mr-2"></i>Agenda Reuni & Event
                    </h2>
                    <a href="{{ route('agenda') }}" class="text-sm font-semibold text-blue-600 hover:text-blue-700">Lihat Semua <i class="fa-solid fa-arrow-right text-[10px]"></i></a>
                </div>
                <div class="space-y-4">
                    @forelse($events as $event)
                        <div class="flex gap-4 p-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex-shrink-0 flex flex-col items-center justify-center w-14 h-16 bg-blue-50 text-blue-700 rounded-xl">
                                <span class="text-lg font-bold leading-none">{{ $event->date->format('d') }}</span>
                                <span class="text-[10px] font-bold uppercase tracking-wider mt-1">{{ $event->date->format('M') }}</span>
                            </div>
                            <div class="space-y-1.5 min-w-0">
                                <h3 class="text-sm font-bold text-slate-900 truncate">
                                    <a href="{{ route('agenda.show', $event->slug) }}" class="hover:text-blue-600">{{ $event->title }}</a>
                                </h3>
                                <p class="text-slate-500 text-xs truncate"><i class="fa-solid fa-location-dot mr-1"></i>{{ $event->location }}</p>
                                <a href="{{ route('agenda.show', $event->slug) }}" class="inline-flex text-[10px] font-semibold text-blue-600 hover:text-blue-700">
                                    RSVP & Detail Event <i class="fa-solid fa-angle-right ml-1"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm">Belum ada agenda terdekat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alumni Testimonials -->
<section class="py-20 bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-16">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900">Alumni Berprestasi & Testimoni</h2>
            <p class="text-slate-500 text-sm">Kisah sukses alumni yang mengharumkan nama almamater dan memberikan inspirasi untuk generasi penerus.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($testimonials as $testi)
                <div class="p-8 bg-slate-50 border border-slate-100 rounded-2xl shadow-sm relative flex flex-col justify-between">
                    <i class="fa-solid fa-quote-left text-3xl text-blue-200 absolute top-6 left-6"></i>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6 pl-6 relative z-10">
                        "{{ $testi['content'] }}"
                    </p>
                    <div class="flex items-center gap-3.5 pl-6">
                        <img src="{{ $testi['avatar'] }}" alt="avatar" class="w-10 h-10 rounded-full object-cover">
                        <div>
                            <h4 class="text-sm font-bold text-slate-900">{{ $testi['name'] }}</h4>
                            <p class="text-[10px] text-slate-400 font-medium">Terverifikasi Anggota Alumni</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
