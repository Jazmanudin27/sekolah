@extends('layouts.app')

@section('title', 'Karir & Bisnis Alumni - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Karir & Bisnis</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Karir & Bisnis Alumni</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Temukan lowongan pekerjaan, peluang magang, serta direktori usaha mikro, kecil, dan menengah milik alumni sekolah.</p>
        </div>

        <!-- Navigation Tabs -->
        <div class="flex border-b border-slate-200" id="tabs" role="tablist">
            <button onclick="switchTab('karir')" id="tab-karir" class="px-6 py-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 focus:outline-none transition-all">
                <i class="fa-solid fa-briefcase mr-1.5"></i> Lowongan Kerja & Magang
            </button>
            <button onclick="switchTab('bisnis')" id="tab-bisnis" class="px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-blue-650 focus:outline-none transition-all">
                <i class="fa-solid fa-store mr-1.5"></i> Direktori Usaha Alumni
            </button>
        </div>

        <!-- Tab 1: Karir Content -->
        <div id="content-karir" class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">Lowongan Pekerjaan Aktif</h2>
                @auth
                    <button onclick="toggleForm('form-karir')" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-md shadow-blue-500/10">
                        <i class="fa-solid fa-plus mr-1"></i> Pasang Lowongan
                    </button>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold border border-slate-200 text-slate-650 hover:bg-slate-50 rounded-xl transition-all">
                        Login untuk Pasang Loker
                    </a>
                @endauth
            </div>

            <!-- Add Career Collapse Form -->
            @auth
                <div id="form-karir" class="hidden bg-white p-6 rounded-3xl border border-slate-150 shadow-sm max-w-2xl text-xs space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-50 pb-2">Form Tambah Lowongan Pekerjaan</h3>
                    <form action="{{ route('karir-bisnis.karir.submit') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Posisi / Pekerjaan</label>
                            <input type="text" name="title" required placeholder="Contoh: Web Designer" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Perusahaan / Industri</label>
                            <input type="text" name="company" required placeholder="Nama Perusahaan" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Tipe Pekerjaan</label>
                            <select name="type" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                                <option value="fulltime">Full-Time (Penuh Waktu)</option>
                                <option value="parttime">Part-Time (Paruh Waktu)</option>
                                <option value="internship">Magang / Internship</option>
                                <option value="freelance">Freelance / Proyek</option>
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Lokasi Kerja</label>
                            <input type="text" name="location" required placeholder="Jakarta / Remote" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Cara Melamar / Kontak HRD</label>
                            <input type="text" name="contact" required placeholder="Email HRD / Link Pendaftaran / Whatsapp" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Deskripsi & Syarat Kualifikasi</label>
                            <textarea name="description" rows="4" required placeholder="Tuliskan syarat usia, pendidikan, deskripsi pekerjaan utama..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                        <div class="sm:col-span-2 pt-2 flex justify-end gap-2">
                            <button type="button" onclick="toggleForm('form-karir')" class="px-4 py-2 border border-slate-200 rounded-lg font-bold text-slate-500">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700">Simpan Lowongan</button>
                        </div>
                    </form>
                </div>
            @endauth

            <!-- Career Listings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($careers as $job)
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col justify-between hover:shadow-md transition-shadow relative">
                        <span class="absolute top-6 right-6 px-2.5 py-0.5 bg-blue-50 text-blue-800 text-[9px] font-bold uppercase tracking-wider rounded-md">
                            {{ $job->type }}
                        </span>
                        
                        <div class="space-y-4">
                            <div class="space-y-1 min-w-0">
                                <h3 class="font-bold text-slate-900 text-base truncate">{{ $job->title }}</h3>
                                <p class="text-xs font-semibold text-slate-500">{{ $job->company }}</p>
                                <p class="text-[10px] text-slate-400"><i class="fa-solid fa-location-dot mr-1"></i>{{ $job->location }}</p>
                            </div>
                            
                            <p class="text-xs text-slate-600 leading-relaxed whitespace-pre-line line-clamp-4">
                                {{ $job->description }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-50 mt-4 flex items-center justify-between text-[10px]">
                            <p class="text-slate-400">Dipasang oleh: <span class="font-semibold text-slate-700">{{ $job->user->name }}</span></p>
                            <a href="mailto:{{ $job->contact }}" class="px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition-colors">
                                Lamar Sekarang
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-550 text-sm py-8 text-center bg-white rounded-3xl border border-slate-100 col-span-full">Belum ada lowongan pekerjaan saat ini.</p>
                @endforelse
            </div>
        </div>

        <!-- Tab 2: Bisnis Content -->
        <div id="content-bisnis" class="space-y-6 hidden">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-bold text-slate-900">Direktori Usaha Terdaftar</h2>
                @auth
                    <button onclick="toggleForm('form-bisnis')" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-md shadow-blue-500/10">
                        <i class="fa-solid fa-plus mr-1"></i> Daftarkan Usaha
                    </button>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold border border-slate-200 text-slate-650 hover:bg-slate-50 rounded-xl transition-all">
                        Login untuk Daftarkan Usaha
                    </a>
                @endauth
            </div>

            <!-- Add Business Collapse Form -->
            @auth
                <div id="form-bisnis" class="hidden bg-white p-6 rounded-3xl border border-slate-150 shadow-sm max-w-2xl text-xs space-y-4">
                    <h3 class="text-sm font-bold text-slate-900 border-b border-slate-50 pb-2">Form Pendaftaran Usaha Alumni</h3>
                    <form action="{{ route('karir-bisnis.bisnis.submit') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Nama Usaha / Toko</label>
                            <input type="text" name="name" required placeholder="Contoh: Coffee Shop Kita" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Kategori Bisnis</label>
                            <input type="text" name="category" required placeholder="Contoh: Kuliner / Jasa Kreatif" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Kontak Pemasaran / Instagram / WA</label>
                            <input type="text" name="contact" required placeholder="Contoh: @kafealumni / 08123456789" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Profil Usaha / Deskripsi Produk & Promo</label>
                            <textarea name="description" rows="4" required placeholder="Jelaskan mengenai produk utama, alamat toko fisik, dan tawaran diskon spesial khusus alumni jika ada..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                        </div>
                        <div class="sm:col-span-2 pt-2 flex justify-end gap-2">
                            <button type="button" onclick="toggleForm('form-bisnis')" class="px-4 py-2 border border-slate-200 rounded-lg font-bold text-slate-500">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700">Daftarkan Bisnis</button>
                        </div>
                    </form>
                </div>
            @endauth

            <!-- Business Directory Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($businesses as $shop)
                    <div class="bg-white border border-slate-100 shadow-sm rounded-3xl overflow-hidden flex flex-col justify-between hover:shadow-md transition-shadow relative">
                        <div>
                            @if($shop->product_image)
                                <div class="aspect-video bg-slate-100">
                                    <img src="{{ $shop->product_image }}" class="w-full h-full object-cover" alt="{{ $shop->name }}">
                                </div>
                            @endif
                            <div class="p-5 space-y-3">
                                <span class="px-2.5 py-0.5 bg-blue-50 text-blue-800 text-[9px] font-bold uppercase tracking-wider rounded-md inline-block">
                                    {{ $shop->category }}
                                </span>
                                <h3 class="font-bold text-slate-900 text-base leading-tight">{{ $shop->name }}</h3>
                                <p class="text-xs text-slate-650 leading-relaxed whitespace-pre-line">
                                    {{ $shop->description }}
                                </p>
                            </div>
                        </div>

                        <div class="p-5 border-t border-slate-50 bg-slate-50 flex items-center justify-between text-[10px]">
                            <p class="text-slate-400">Owner: <span class="font-semibold text-slate-700">{{ $shop->user->name }}</span></p>
                            <span class="font-bold text-blue-700"><i class="fa-solid fa-address-card mr-1"></i>{{ $shop->contact }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-550 text-sm py-8 text-center bg-white rounded-3xl border border-slate-100 col-span-full">Belum ada usaha alumni terdaftar.</p>
                @endforelse
            </div>
        </div>

    </div>
</div>

<script>
    function switchTab(tab) {
        var tabKarir = document.getElementById('tab-karir');
        var tabBisnis = document.getElementById('tab-bisnis');
        var contentKarir = document.getElementById('content-karir');
        var contentBisnis = document.getElementById('content-bisnis');
        
        if (tab === 'karir') {
            tabKarir.className = "px-6 py-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 focus:outline-none transition-all";
            tabBisnis.className = "px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-blue-650 focus:outline-none transition-all";
            contentKarir.classList.remove('hidden');
            contentBisnis.classList.add('hidden');
        } else {
            tabKarir.className = "px-6 py-3 text-sm font-bold border-b-2 border-transparent text-slate-500 hover:text-blue-650 focus:outline-none transition-all";
            tabBisnis.className = "px-6 py-3 text-sm font-bold border-b-2 border-blue-600 text-blue-600 focus:outline-none transition-all";
            contentKarir.classList.add('hidden');
            contentBisnis.classList.remove('hidden');
        }
    }
    
    function toggleForm(formId) {
        var form = document.getElementById(formId);
        form.classList.toggle('hidden');
    }
</script>
@endsection
