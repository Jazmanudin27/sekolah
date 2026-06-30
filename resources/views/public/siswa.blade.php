@extends('layouts.app')

@section('title', 'Direktori Data Siswa - Portal Sekolah')

@section('content')
<div class="relative bg-slate-900 overflow-hidden py-16 sm:py-24 mb-12">
    <div class="absolute inset-0 opacity-20">
        <div class="absolute -top-40 -left-40 w-80 h-80 bg-blue-500 rounded-full filter blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-80 h-80 bg-indigo-500 rounded-full filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="px-3 py-1 text-xs font-semibold text-blue-300 bg-blue-500/10 rounded-full uppercase tracking-wider">Akademik Sekolah</span>
        <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold text-white tracking-tight">Direktori Data Siswa</h1>
        <p class="mt-4 max-w-2xl mx-auto text-lg text-slate-300">Daftar siswa aktif SMK Negeri 1 yang sedang menempuh pendidikan di berbagai program keahlian unggulan.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-24">
    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 fs-4">
                <i class="fa-solid fa-users"></i>
            </span>
            <div>
                <span class="block text-2xl font-bold text-slate-900">{{ $totalStudents }}</span>
                <span class="text-sm text-slate-500 font-medium">Siswa Aktif</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 fs-4">
                <i class="fa-solid fa-code"></i>
            </span>
            <div>
                <span class="block text-2xl font-bold text-slate-900">{{ $totalRPL }}</span>
                <span class="text-sm text-slate-500 font-medium">Siswa RPL</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-purple-600 fs-4">
                <i class="fa-solid fa-network-wired"></i>
            </span>
            <div>
                <span class="block text-2xl font-bold text-slate-900">{{ $totalTKJ }}</span>
                <span class="text-sm text-slate-500 font-medium">Siswa TKJ</span>
            </div>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-4">
            <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600 fs-4">
                <i class="fa-solid fa-photo-film"></i>
            </span>
            <div>
                <span class="block text-2xl font-bold text-slate-900">{{ $totalMM }}</span>
                <span class="text-sm text-slate-500 font-medium">Siswa Multimedia</span>
            </div>
        </div>
    </div>

    <!-- Search / Filter -->
    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm mb-8">
        <form action="{{ route('siswa') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="relative w-full md:max-w-md">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIS siswa..." 
                    class="w-full pl-10 pr-4 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
            </div>

            <div class="flex gap-3 w-full md:w-auto">
                <select name="major" class="w-full md:w-48 px-3 py-2 text-sm bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white transition-all">
                    <option value="">Semua Jurusan</option>
                    <option value="RPL" {{ request('major') == 'RPL' ? 'selected' : '' }}>RPL (Software)</option>
                    <option value="TKJ" {{ request('major') == 'TKJ' ? 'selected' : '' }}>TKJ (Networking)</option>
                    <option value="Multimedia" {{ request('major') == 'Multimedia' ? 'selected' : '' }}>Multimedia</option>
                </select>

                <button type="submit" class="w-full md:w-auto px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition-all shadow-md shadow-blue-600/10">
                    Cari Data
                </button>
            </div>
        </form>
    </div>

    <!-- Student List Table -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 border-b border-slate-100 text-xs font-semibold uppercase">
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">NIS</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Program Keahlian</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($students as $index => $student)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-400">{{ $students->firstItem() + $index }}</td>
                            <td class="px-6 py-4 font-semibold text-slate-900">{{ $student->nis }}</td>
                            <td class="px-6 py-4 font-medium">{{ $student->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 text-xs font-semibold bg-slate-100 text-slate-700 rounded-md">{{ $student->class }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($student->major == 'RPL')
                                    <span class="text-blue-600 font-semibold">Rekayasa Perangkat Lunak</span>
                                @elseif($student->major == 'TKJ')
                                    <span class="text-purple-600 font-semibold">Teknik Komputer & Jaringan</span>
                                @else
                                    <span class="text-amber-600 font-semibold">{{ $student->major }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2.5 py-1 text-xs font-bold bg-emerald-50 text-emerald-700 rounded-full">Aktif</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-450 font-medium">
                                <i class="fa-solid fa-users-slash fs-2 block mb-3 text-slate-300"></i>
                                Tidak ada data siswa aktif yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div>
        {{ $students->links() }}
    </div>
</div>
@endsection
