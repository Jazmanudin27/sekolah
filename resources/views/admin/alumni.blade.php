@extends('layouts.admin')

@section('title', 'Kelola Alumni - Panel Admin')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

    <div class="card card-custom p-4">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border-bottom pb-3 mb-4">
            <h5 class="font-weight-bold text-dark m-0 d-flex align-items-center gap-2">
                <i class="fa-solid fa-users text-primary"></i> Kelola & Verifikasi Akun Alumni
            </h5>
            
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
            @else
                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill"
                    style="font-size: 0.75rem; font-weight: 600;">
                    Total Alumni Terdaftar: {{ $alumni->total() }}
                </span>
            @endif
        </div>

        <!-- Table alumni -->
        <div class="table-responsive">
            <table class="table table-hover align-middle table-custom" style="font-size: 0.8rem;">
                <thead class="table-light text-secondary uppercase font-semibold" style="font-size: 0.75rem;">
                    <tr>
                        @if(auth()->user()->role === 'superadmin')
                            <th scope="col" class="border-0">Sekolah</th>
                        @endif
                        <th scope="col" class="border-0">Nama</th>
                        <th scope="col" class="border-0">Angkatan & Jurusan</th>
                        <th scope="col" class="border-0">Domisili</th>
                        <th scope="col" class="border-0">Status</th>
                        <th scope="col" class="text-end border-0">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumni as $userItem)
                        <tr class="align-middle">
                            @if(auth()->user()->role === 'superadmin')
                                <td><span class="badge bg-light text-dark border">{{ $userItem->school->name ?? 'Default' }}</span></td>
                            @endif
                            <td>
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle"
                                        style="width: 34px; height: 34px; font-weight: 700; font-size: 0.85rem;">
                                        {{ strtoupper(substr($userItem->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark" style="font-weight: 700;">
                                            {{ $userItem->name }}</div>
                                        <small class="text-secondary d-block mt-0.5"
                                            style="font-size: 0.7rem;">{{ $userItem->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="font-weight-semibold text-secondary" style="font-weight: 600;">
                                Angkatan {{ $userItem->angkatan }} - {{ $userItem->jurusan }}
                            </td>
                            <td>
                                {{ $userItem->domisili ?? '-' }}
                            </td>
                            <td>
                                <span
                                    class="badge text-uppercase {{ $userItem->status_verifikasi ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning-emphasis border border-warning' }}"
                                    style="font-size: 0.65rem; font-weight: 700;">
                                    {{ $userItem->status_verifikasi ? 'Verified' : 'Pending' }}
                                </span>
                            </td>
                            <td class="text-end">
                                <div class="d-flex align-items-center justify-content-end gap-2">
                                    <form action="{{ route($routePrefix . 'alumni.verify', $userItem->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        <button type="submit"
                                            class="btn btn-sm font-weight-bold text-white transition-colors px-3 {{ $userItem->status_verifikasi ? 'btn-warning text-dark' : 'btn-success' }}"
                                            style="font-size: 0.7rem; font-weight: 700; border-radius: 6px;">
                                            {{ $userItem->status_verifikasi ? 'Unverify' : 'Verify' }}
                                        </button>
                                    </form>

                                    <form action="{{ route($routePrefix . 'alumni.delete', $userItem->id) }}" method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm btn-outline-danger p-1.5 d-flex align-items-center justify-content-center"
                                            style="border-radius: 6px;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'superadmin' ? '6' : '5' }}" class="text-center text-secondary py-5">Belum ada alumni mendaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($alumni->hasPages())
            <div class="pt-3 border-top mt-3 d-flex justify-content-center">
                {{ $alumni->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
