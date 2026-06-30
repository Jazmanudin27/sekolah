@extends('layouts.app')

@section('title', 'Forum Alumni - Portal Alumni SMK Negeri 1')

@section('content')
<div class="py-12 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header -->
        <div class="space-y-2">
            <nav class="text-xs font-semibold text-slate-400 uppercase tracking-wider flex items-center gap-2">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Beranda</a>
                <i class="fa-solid fa-angle-right text-[8px]"></i>
                <span class="text-slate-500">Forum Alumni</span>
            </nav>
            <h1 class="text-3xl font-extrabold tracking-tight text-blue-950">Forum Diskusi Alumni</h1>
            <p class="text-sm text-slate-500 max-w-2xl">Ruang bertukar gagasan, diskusi umum, sharing lowongan kerja/karir, tanya jawab guru-siswa, dan info alumni.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Topics list -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h2 class="text-lg font-bold text-slate-900">Diskusi Aktif</h2>
                    @auth
                        <button onclick="toggleForm('form-topic')" class="px-4 py-2 text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl transition-all shadow-md shadow-blue-500/10">
                            <i class="fa-solid fa-pen-to-square mr-1"></i> Mulai Diskusi
                        </button>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 text-xs font-semibold border border-slate-200 text-slate-650 hover:bg-slate-50 rounded-xl transition-all">
                            Login untuk Diskusi
                        </a>
                    @endauth
                </div>

                <!-- Create Topic Collapse Form -->
                @auth
                    <div id="form-topic" class="hidden bg-white p-6 rounded-3xl border border-slate-150 shadow-sm text-xs space-y-4">
                        <h3 class="text-sm font-bold text-slate-900 border-b border-slate-50 pb-2">Buat Topik Diskusi Baru</h3>
                        <form action="{{ route('forum.topic.submit') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="space-y-1">
                                <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Judul Topik / Diskusi</label>
                                <input type="text" name="title" required placeholder="Tuliskan judul yang menarik dan jelas..." class="w-full px-3 py-2.5 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-xs">
                            </div>
                            <div class="space-y-1">
                                <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Isi Topik Diskusi</label>
                                <textarea name="content" rows="6" required placeholder="Deskripsikan dengan detail mengenai informasi atau pertanyaan Anda..." class="w-full px-3 py-2 border border-slate-200 rounded-lg focus:outline-none focus:border-blue-500 text-xs"></textarea>
                            </div>
                            <div class="pt-2 flex justify-end gap-2">
                                <button type="button" onclick="toggleForm('form-topic')" class="px-4 py-2 border border-slate-200 rounded-lg font-bold text-slate-500">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-bold hover:bg-blue-700">Mulai Diskusi</button>
                            </div>
                        </form>
                    </div>
                @endauth

                <!-- Topics list -->
                <div class="space-y-4">
                    @forelse($topics as $topic)
                        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:shadow-md transition-shadow">
                            <div class="space-y-2 min-w-0">
                                <h3 class="text-base font-bold text-slate-900 hover:text-blue-600 leading-snug">
                                    <a href="{{ route('forum.show', $topic->id) }}">{{ $topic->title }}</a>
                                </h3>
                                <div class="flex flex-wrap items-center gap-2.5 text-[10px] text-slate-400">
                                    <span class="font-bold text-slate-650">{{ $topic->user->name }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $topic->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0 flex items-center gap-6 text-slate-400 text-xs">
                                <div class="text-center">
                                    <span class="block font-bold text-slate-800 text-sm">{{ $topic->replies->count() }}</span>
                                    <span class="text-[9px] uppercase font-semibold text-slate-400 tracking-wider">Balasan</span>
                                </div>
                                <a href="{{ route('forum.show', $topic->id) }}" class="p-2 bg-slate-50 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors">
                                    <i class="fa-solid fa-angle-right text-sm"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 text-sm py-8 text-center bg-white rounded-3xl border border-slate-100">Belum ada diskusi.</p>
                    @endforelse
                </div>

                <div class="pt-4">
                    {{ $topics->links() }}
                </div>
            </div>

            <!-- Right: Info/Rule Panel -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm space-y-4">
                    <h2 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-2">Aturan Berdiskusi</h2>
                    <ul class="list-decimal list-inside text-xs text-slate-600 space-y-2 leading-relaxed">
                        <li>Gunakan bahasa yang santun, sopan, dan saling menghormati sesama alumni.</li>
                        <li>Dilarang menyebarkan berita bohong (hoax) atau provokasi sara.</li>
                        <li>Gunakan kategori karir/sharing bisnis pada modul terpisah untuk iklan usaha.</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function toggleForm(formId) {
        var form = document.getElementById(formId);
        form.classList.toggle('hidden');
    }
</script>
@endsection
