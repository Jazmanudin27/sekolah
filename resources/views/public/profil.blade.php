@extends('layouts.app')

@section('title', 'Profil Almamater - ' . ($currentSchool->name ?? 'Sekolah'))

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Breadcrumb / Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Profil Almamater</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Profil Almamater</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Informasi mengenai sejarah singkat, visi, dan misi almamater {{ $currentSchool->name ?? 'Sekolah' }}.</p>
        </div>

        <!-- Visi, Misi & Tentang -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 p-8 shadow-sm space-y-6">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i> Sejarah & Profil Singkat
                </h2>
                <div class="text-slate-600 text-sm space-y-4 leading-relaxed whitespace-pre-line">
                    {{ $currentSchool->history ?? 'Informasi sejarah sekolah belum dikonfigurasi.' }}
                </div>
            </div>

            <div class="bg-gradient-brand text-white rounded-3xl p-8 shadow-md relative overflow-hidden flex flex-col justify-between">
                <div class="absolute inset-0 opacity-5 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
                <div class="space-y-6 relative z-10">
                    <h2 class="text-lg font-bold flex items-center gap-2 border-b border-white/10 pb-3">
                        <i class="fa-solid fa-bullseye text-blue-300"></i> Visi & Misi
                    </h2>
                    <div class="space-y-4 text-xs leading-relaxed">
                        <div>
                            <p class="font-bold uppercase tracking-wider text-blue-300">Visi:</p>
                            <p class="mt-1 text-slate-100 italic">"{{ $currentSchool->vision ?? 'Visi belum diatur.' }}"</p>
                        </div>
                        <div>
                            <p class="font-bold uppercase tracking-wider text-blue-300">Misi:</p>
                            <p class="mt-1 text-slate-100 whitespace-pre-line">{{ $currentSchool->mission ?? 'Misi belum diatur.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
