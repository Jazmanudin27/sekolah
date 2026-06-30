@extends('layouts.app')

@section('title', 'Masuk Portal Alumni - ' . ($currentSchool->name ?? 'SMK Negeri 1'))

@section('content')
<div class="py-16 bg-slate-50 flex items-center justify-center min-h-[80vh]">
    <div class="w-full max-w-md mx-auto px-4 space-y-6">
        
        <!-- Login Card -->
        <div class="bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
            <div class="text-center space-y-2">
                <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600 text-2xl shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </span>
                <h1 class="text-2xl font-extrabold text-blue-950">Masuk Portal Alumni</h1>
                <p class="text-xs text-slate-400">Silakan masukkan email dan kata sandi akun Anda.</p>
            </div>

            <!-- Demo accounts info box -->
            <div class="bg-indigo-50 border border-indigo-150 p-4 rounded-2xl text-[11px] text-indigo-950 space-y-2">
                <p class="font-bold"><i class="fa-solid fa-circle-info text-indigo-600 mr-1"></i> Demo Akun Pengujian:</p>
                <ul class="list-disc list-inside space-y-1 text-slate-650">
                    <li><span class="font-bold text-indigo-950">Admin:</span> admin@alumni.com (pwd: password)</li>
                    <li><span class="font-bold text-indigo-950">Alumni:</span> rian@alumni.com (pwd: password)</li>
                </ul>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com" class="w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    @error('email')
                        <p class="text-[10px] text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Kata Sandi</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full pl-9 pr-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>

                <div class="flex items-center justify-between text-[11px] pt-1">
                    <label class="flex items-center gap-1.5 text-slate-600 font-semibold cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                        Ingat Saya
                    </label>
                    <a href="#" class="font-semibold text-blue-600 hover:underline">Lupa password?</a>
                </div>

                <button type="submit" class="w-full font-bold text-white bg-blue-600 hover:bg-blue-700 py-3 rounded-xl transition-all shadow-md shadow-blue-500/10 hover:shadow-blue-500/20">
                    Masuk Sekarang <i class="fa-solid fa-arrow-right-to-bracket ml-1.5"></i>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center text-xs">
                <p class="text-slate-500">Belum terdaftar? <a href="{{ route('register') }}" class="font-bold text-blue-600 hover:underline">Daftar Akun Alumni</a></p>
            </div>
        </div>

    </div>
</div>
@endsection
