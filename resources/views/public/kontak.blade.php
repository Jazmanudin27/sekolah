@extends('layouts.app')

@section('title', 'Hubungi Kami - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Hubungi Kami</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Hubungi Kami</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Punya pertanyaan seputar keanggotaan, donasi, program ikatan alumni? Silakan hubungi sekretariat kami.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Contact Details & Google Maps -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Info cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm space-y-2.5">
                        <i class="fa-solid fa-map-location-dot text-xl text-blue-600"></i>
                        <p class="font-bold text-slate-900">Alamat Sekretariat</p>
                        <p class="text-slate-500 leading-relaxed">Jl. Pendidikan No. 45, Komplek SMKN 1, Kota Raya, 12345</p>
                    </div>
                    <div class="p-5 bg-white border border-slate-100 rounded-2xl shadow-sm space-y-2.5">
                        <i class="fa-brands fa-whatsapp text-xl text-emerald-500"></i>
                        <p class="font-bold text-slate-900">WhatsApp Gateway</p>
                        <p class="text-slate-500 leading-relaxed">+62 812-3456-7890 (Chat Only)</p>
                    </div>
                </div>


                <!-- Google Maps Embed -->
                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-3 h-80">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.56347862272!2d107.57311641640625!3d-6.9034443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a16c4f3e654eb!2sSMK%20Negeri%201%20Bandung!5e0!3m2!1sid!2sid!4v1719665000000!5m2!1sid!2sid" 
                        class="w-full h-full rounded-2xl border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>

            <!-- Right: Contact Form -->
            <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-8 shadow-sm space-y-4">
                <h2 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-3">Kirim Pesan</h2>
                <form action="{{ route('kontak.submit') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div class="space-y-1">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Nama Lengkap</label>
                        <input type="text" name="name" required placeholder="Nama Anda" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-xs">
                    </div>
                    
                    <div class="space-y-1">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Alamat Email</label>
                        <input type="email" name="email" required placeholder="email@contoh.com" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-xs">
                    </div>

                    <div class="space-y-1">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Isi Pesan / Pertanyaan</label>
                        <textarea name="message" rows="5" required placeholder="Tuliskan detail pertanyaan Anda..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-xs"></textarea>
                    </div>

                    <button type="submit" class="w-full font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-colors shadow-md shadow-blue-500/10">
                        Kirim Pesan <i class="fa-solid fa-paper-plane ml-1"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
