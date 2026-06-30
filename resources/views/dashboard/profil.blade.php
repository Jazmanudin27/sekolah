@extends('layouts.app')

@section('title', 'Edit Profil Alumni - Portal Alumni SMK Negeri 1')

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
                        <a href="{{ route('dashboard.profil') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-bold rounded-xl transition-all bg-blue-50 text-blue-700">
                            <i class="fa-solid fa-user-gear"></i> Edit Profil
                        </a>
                        <a href="{{ route('dashboard.kartu') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-id-card"></i> Kartu Alumni Digital
                        </a>
                        <a href="{{ route('dashboard.event') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-calendar-check"></i> Event Saya
                        </a>
                        <a href="{{ route('dashboard.donasi') }}" class="flex items-center gap-2.5 px-3 py-2.5 font-semibold rounded-xl transition-all text-slate-600 hover:bg-slate-50 hover:text-blue-600">
                            <i class="fa-solid fa-wallet"></i> Donasi Saya
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Content Area (Right) -->
            <div class="lg:col-span-3">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-6">
                    <h2 class="text-lg font-bold text-slate-900 border-b border-slate-50 pb-3 flex items-center gap-2">
                        <i class="fa-solid fa-user-gear text-blue-600"></i> Edit Detail Profil Alumni
                    </h2>
                    
                    <form action="{{ route('dashboard.profil.update') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                        @csrf
                        
                        <!-- Full Name -->
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Email (Disabled) -->
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Alamat Email (Akun)</label>
                            <input type="email" disabled value="{{ $user->email }}" class="w-full px-3 py-2 bg-slate-50 text-slate-400 border border-slate-200 rounded-lg cursor-not-allowed">
                        </div>

                        <!-- Domisili -->
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Kota Domisili</label>
                            <input type="text" name="domisili" value="{{ old('domisili', $user->domisili) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Pekerjaan -->
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Pekerjaan Sekarang</label>
                            <input type="text" name="pekerjaan" value="{{ old('pekerjaan', $user->pekerjaan) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Whatsapp -->
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Kontak WhatsApp (Mulai 62...)</label>
                            <input type="text" name="kontak_whatsapp" value="{{ old('kontak_whatsapp', $user->kontak_whatsapp) }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Pendidikan Terakhir -->
                        <div class="space-y-1">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Pendidikan Terakhir</label>
                            <input type="text" name="pendidikan_terakhir" value="{{ old('pendidikan_terakhir', $user->pendidikan_terakhir) }}" placeholder="Contoh: S1 Teknik Komputer" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Avatar image URL (mock file upload) -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Foto Profil URL (Gunakan Link Foto)</label>
                            <input type="text" name="foto_url" value="{{ old('foto_url', $user->foto) }}" placeholder="Contoh: https://images.unsplash.com/photo-..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        </div>

                        <!-- Media Sosial Links -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px] block border-b border-slate-50 pb-1 mb-1">Sosial Media Link</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <div>
                                    <label class="text-[8px] font-bold text-slate-450 uppercase">Linkedin Username</label>
                                    <input type="text" name="linkedin" value="{{ $user->media_sosial['linkedin'] ?? '' }}" placeholder="linkedin.com/in/..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="text-[8px] font-bold text-slate-450 uppercase">Github Username</label>
                                    <input type="text" name="github" value="{{ $user->media_sosial['github'] ?? '' }}" placeholder="github.com/..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="text-[8px] font-bold text-slate-450 uppercase">Instagram Handle</label>
                                    <input type="text" name="instagram" value="{{ $user->media_sosial['instagram'] ?? '' }}" placeholder="instagram.com/..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <!-- Bio -->
                        <div class="space-y-1 sm:col-span-2">
                            <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Tentang Saya / Bio Singkat</label>
                            <textarea name="bio" rows="4" placeholder="Tuliskan pengalaman keahlian Anda..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">{{ old('bio', $user->bio) }}</textarea>
                        </div>

                        <!-- Password fields -->
                        <div class="space-y-1 block border-t border-slate-50 pt-4 sm:col-span-2">
                            <p class="font-bold text-slate-400 uppercase tracking-wider text-[9px] mb-2">Ubah Kata Sandi (Kosongkan jika tidak ingin mengubah)</p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[8px] font-bold text-slate-450 uppercase">Kata Sandi Baru</label>
                                    <input type="password" name="password" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="text-[8px] font-bold text-slate-450 uppercase">Ulangi Kata Sandi Baru</label>
                                    <input type="password" name="password_confirmation" class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2 pt-4 flex justify-end gap-2">
                            <button type="submit" class="w-full font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-all shadow-md shadow-blue-500/10">
                                Simpan Perubahan Profil <i class="fa-solid fa-floppy-disk ml-1.5"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
