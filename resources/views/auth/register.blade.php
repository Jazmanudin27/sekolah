@extends('layouts.app')

@section('title', 'Pendaftaran Alumni - ' . ($currentSchool->name ?? 'SMK Negeri 1'))

@section('content')
<div class="py-16 bg-slate-50 flex items-center justify-center min-h-[90vh]">
    <div class="w-full max-w-2xl mx-auto px-4 space-y-6">
        
        <!-- Registration Card -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
            <div class="text-center space-y-2">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 text-2xl shadow-inner">
                    <i class="fa-solid fa-user-plus"></i>
                </span>
                <h1 class="text-2xl font-extrabold text-blue-950">Daftar Akun Alumni</h1>
                <p class="text-xs text-slate-400">Isi formulir pendaftaran di bawah ini untuk diverifikasi oleh Admin.</p>
            </div>

            <form action="{{ route('register') }}" method="POST" class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                @csrf

                <!-- School Selection -->
                <div class="sm:col-span-2 space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Asal Sekolah</label>
                    <select name="school_id" required class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="">-- Pilih Sekolah --</option>
                        @foreach($schools as $school)
                            <option value="{{ $school->id }}" {{ old('school_id') == $school->id ? 'selected' : '' }}>{{ $school->name }}</option>
                        @endforeach
                    </select>
                    @error('school_id') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Full Name -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('name') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('email') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Min. 8 Karakter" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('password') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi Kata Sandi" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <!-- Angkatan -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Angkatan (Tahun Masuk)</label>
                    <input type="number" name="angkatan" value="{{ old('angkatan', 2018) }}" required placeholder="Contoh: 2018" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('angkatan') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Jurusan -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Jurusan Kelulusan</label>
                    <select name="jurusan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                        <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                        <option value="TKJ">Teknik Komputer & Jaringan (TKJ)</option>
                        <option value="Multimedia">Multimedia / DKV</option>
                        <option value="TKR">Teknik Kendaraan Ringan (TKR)</option>
                    </select>
                    @error('jurusan') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tahun Lulus -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Tahun Lulus</label>
                    <input type="number" name="tahun_lulus" value="{{ old('tahun_lulus', 2021) }}" required placeholder="Contoh: 2021" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('tahun_lulus') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Domisili -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Kota Domisili Saat Ini</label>
                    <input type="text" name="domisili" value="{{ old('domisili') }}" required placeholder="Contoh: Jakarta Selatan" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('domisili') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Pekerjaan -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Pekerjaan / Instansi Sekarang</label>
                    <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" required placeholder="Contoh: Backend Developer di Toko" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('pekerjaan') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- WA -->
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">No. Whatsapp (Mulai 62...)</label>
                    <input type="text" name="kontak_whatsapp" value="{{ old('kontak_whatsapp', '628') }}" required placeholder="Contoh: 62812345678" class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    @error('kontak_whatsapp') <p class="text-[10px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="sm:col-span-2 pt-4">
                    <button type="submit" class="w-full font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-all shadow-md shadow-blue-500/10 hover:shadow-blue-500/20">
                        Kirim Pendaftaran Alumni <i class="fa-solid fa-paper-plane ml-1.5"></i>
                    </button>
                </div>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center text-xs">
                <p class="text-slate-500">Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Masuk di sini</a></p>
            </div>
        </div>

    </div>
</div>
@endsection
