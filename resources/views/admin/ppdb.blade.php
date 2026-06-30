@extends('layouts.admin')

@section('title', 'Verifikasi Pendaftaran PPDB - Admin Console')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

<div class="row g-4">
    <!-- Header Title -->
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-bold" style="font-weight: 700;">Verifikasi PPDB Online</h1>
            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Tinjau, terima, atau tolak aplikasi calon peserta didik baru.</p>
        </div>

        @if(auth()->user()->role === 'superadmin')
            <form method="GET" class="d-flex align-items-center gap-2 bg-white p-2 rounded-3 border">
                <label class="small text-muted font-bold text-nowrap m-0 uppercase tracking-wider" style="font-size: 10px; font-weight: 700;">Filter Sekolah:</label>
                <select name="school_id" onchange="this.form.submit()" class="form-select form-select-sm rounded-3" style="font-size: 0.8rem; width: 220px;">
                    <option value="">-- Semua Sekolah --</option>
                    @foreach($allSchools as $s)
                        <option value="{{ $s->id }}" {{ request('school_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                    @endforeach
                </select>
            </form>
        @endif
    </div>

    <!-- Table Section -->
    <div class="col-12">
        <div class="card card-custom p-4">
            <!-- Search & Filters -->
            <div class="d-flex flex-column md:flex-row justify-content-between align-items-stretch md:align-items-center gap-3 mb-4">
                <h5 class="m-0 font-bold" style="font-weight: 700;">Daftar Pendaftar PPDB</h5>
                
                <form action="{{ route($routePrefix . 'ppdb') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center justify-content-md-end">
                    @if(request('school_id'))
                        <input type="hidden" name="school_id" value="{{ request('school_id') }}">
                    @endif
                    <select name="status" class="form-select form-select-sm" style="width: 140px; font-size: 0.8rem;" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Diterima</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    <div class="input-group input-group-sm" style="width: 250px;">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control rounded-start-3 border-end-0" placeholder="Cari nama, No. daftar, SMP...">
                        <button class="btn btn-outline-secondary border-start-0 rounded-end-3" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table List -->
            <div class="table-responsive">
                <table class="table table-hover align-middle" style="font-size: 0.82rem;">
                    <thead class="table-light text-muted uppercase" style="font-size: 0.7rem; font-weight: 700;">
                        <tr>
                            @if(auth()->user()->role === 'superadmin')
                                <th>Sekolah</th>
                            @endif
                            <th>No. Daftar</th>
                            <th>Nama Lengkap</th>
                            <th>SMP Asal</th>
                            <th>Pilihan Jurusan</th>
                            <th>Kontak / HP</th>
                            <th>Status</th>
                            <th class="text-end">Aksi Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admissions as $admission)
                            <tr>
                                @if(auth()->user()->role === 'superadmin')
                                    <td><span class="badge bg-light text-dark border">{{ $admission->school->name ?? 'Default' }}</span></td>
                                @endif
                                <td class="font-bold text-primary font-mono">{{ $admission->registration_number }}</td>
                                <td class="font-bold">{{ $admission->name }}</td>
                                <td>{{ $admission->previous_school }}</td>
                                <td>
                                    @if($admission->major_choice == 'RPL')
                                        <span class="text-blue font-semibold">RPL</span>
                                    @elseif($admission->major_choice == 'TKJ')
                                        <span class="text-purple font-semibold">TKJ</span>
                                    @else
                                        <span class="text-amber font-semibold">{{ $admission->major_choice }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span>{{ $admission->phone }}</span>
                                        <small class="text-muted" style="font-size: 0.72rem;">{{ $admission->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    @if($admission->status == 'approved')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5">Diterima</span>
                                    @elseif($admission->status == 'rejected')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2.5">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-2.5">Pending</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1.5 align-items-center">
                                        <!-- Approve Action -->
                                        @if($admission->status != 'approved')
                                            <form action="{{ route($routePrefix . 'ppdb.verify', $admission->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-outline-success btn-sm px-2.5" title="Terima Calon Siswa">
                                                    <i class="fa-solid fa-circle-check"></i> Terima
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Reject Action -->
                                        @if($admission->status != 'rejected')
                                            <form action="{{ route($routePrefix . 'ppdb.verify', $admission->id) }}" method="POST" class="m-0">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-outline-danger btn-sm px-2.5" title="Tolak Calon Siswa">
                                                    <i class="fa-solid fa-circle-xmark"></i> Tolak
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Delete Action -->
                                        <form action="{{ route($routePrefix . 'ppdb.delete', $admission->id) }}" method="POST" class="m-0" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data registrasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger p-0 border-0 ms-2" title="Hapus"><i class="fa-solid fa-trash-can fs-6"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'superadmin' ? '8' : '7' }}" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-inbox fs-2 block mb-2 text-white-50"></i><br>
                                    Belum ada aplikasi pendaftaran PPDB.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $admissions->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
