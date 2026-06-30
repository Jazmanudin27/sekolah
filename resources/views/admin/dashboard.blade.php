@extends('layouts.admin')

@section('title', 'Panel Admin - System Dashboard')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
@endphp

<div class="container-fluid p-0">
    <!-- Header / Welcome Banner -->
    <div class="card card-custom p-4 mb-4" style="background: linear-gradient(135deg, #005cff 0%, #0039a6 100%); color: white;">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h4 class="m-0 font-weight-bold" style="font-weight: 800; letter-spacing: -0.5px;">
                    {{ $isSuperRoute ? 'Console Statistik Super Admin' : 'Selamat Datang di Panel Admin!' }}
                </h4>
                <p class="m-0 text-white-50 mt-1" style="font-size: 0.85rem;">
                    {{ $isSuperRoute 
                        ? 'Analisis rekapitulasi data dari seluruh tenant sekolah yang terdaftar dalam platform ERP.'
                        : 'Kelola seluruh portal alumni, verifikasi pengguna, serta publikasi berita dan agenda donasi.' }}
                </p>
            </div>
            
            @if(auth()->user()->role === 'superadmin')
                <form method="GET" class="d-flex align-items-center gap-2 bg-white bg-opacity-20 p-2 rounded-3">
                    <label class="small text-white font-bold text-nowrap m-0 uppercase tracking-wider" style="font-size: 10px; font-weight: 700;">Filter Sekolah:</label>
                    <select name="school_id" onchange="this.form.submit()" class="form-select form-select-sm rounded-3 bg-transparent text-white border-0" style="font-size: 0.8rem; width: 220px; color-scheme: dark;">
                        <option value="" class="text-dark">-- Semua Sekolah --</option>
                        @foreach($allSchools as $s)
                            <option value="{{ $s->id }}" {{ request('school_id') == $s->id ? 'selected' : '' }} class="text-dark">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </form>
            @else
                <span class="d-flex align-items-center justify-content-center bg-white bg-opacity-20 text-white rounded-3 shadow-sm" style="width: 44px; height: 44px;">
                    <i class="fa-solid fa-gauge-high fs-5"></i>
                </span>
            @endif
        </div>
    </div>
    
    <!-- Stat Cards -->
    <div class="row g-4 mb-4">
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card card-custom p-4 d-flex flex-row align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-3 flex-shrink-0" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-users fs-4"></i>
                </div>
                <div>
                    <p class="text-secondary text-uppercase m-0" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Total User</p>
                    <h3 class="m-0" style="font-weight: 800;">{{ $stats['total_users'] }}</h3>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card card-custom p-4 d-flex flex-row align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-3 flex-shrink-0" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-user-clock fs-4"></i>
                </div>
                <div>
                    <p class="text-secondary text-uppercase m-0" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Menunggu Verifikasi</p>
                    <h3 class="m-0 text-warning" style="font-weight: 800;">{{ $stats['pending_verifications'] }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-4">
            <div class="card card-custom p-4 d-flex flex-row align-items-center gap-3">
                <div class="d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-3 flex-shrink-0" style="width: 48px; height: 48px;">
                    <i class="fa-solid fa-hand-holding-dollar fs-4"></i>
                </div>
                <div>
                    <p class="text-secondary text-uppercase m-0" style="font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px;">Total Dana Donasi</p>
                    <h4 class="m-0 text-success" style="font-weight: 800; font-size: 1.25rem;">Rp {{ number_format($stats['total_donations'], 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Alumni & Transactions Table -->
    <div class="row g-4">
        <!-- Column 1: Recent Registered Alumni -->
        <div class="col-12 col-lg-6">
            <div class="card card-custom p-4 h-100">
                <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-user-plus text-primary me-2"></i> Alumni Baru Mendaftar</h6>
                <div class="d-flex flex-column gap-2">
                    @forelse($recentAlumni as $newAlumnus)
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border border-light-subtle">
                            <div class="min-w-0">
                                <p class="m-0 text-dark text-truncate" style="font-size: 0.85rem; font-weight: 700;">{{ $newAlumnus->name }}</p>
                                <small class="text-muted" style="font-size: 0.7rem;">Angkatan {{ $newAlumnus->angkatan }} - {{ $newAlumnus->jurusan }} ({{ $newAlumnus->school->name ?? 'Default' }})</small>
                            </div>
                            <span class="badge text-uppercase {{ $newAlumnus->status_verifikasi ? 'bg-success' : 'bg-warning text-dark' }}" style="font-size: 0.6rem; font-weight: 700;">
                                {{ $newAlumnus->status_verifikasi ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4 m-0" style="font-size: 0.8rem;">Belum ada pendaftaran baru.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Column 2: Recent Transactions -->
        <div class="col-12 col-lg-6">
            <div class="card card-custom p-4 h-100">
                <h6 class="font-weight-bold text-dark border-bottom pb-2 mb-3"><i class="fa-solid fa-wallet text-primary me-2"></i> Transaksi Donasi Masuk</h6>
                <div class="d-flex flex-column gap-2">
                    @forelse($recentTransactions as $tx)
                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border border-light-subtle">
                            <div class="min-w-0">
                                <p class="m-0 text-dark text-truncate" style="font-size: 0.85rem; font-weight: 700;">{{ $tx->donor_name }}</p>
                                <small class="text-muted" style="font-size: 0.7rem;">{{ $tx->donation->title }} ({{ $tx->donation->school->name ?? 'Default' }})</small>
                            </div>
                            <span class="text-success font-weight-bold" style="font-size: 0.85rem; font-weight: 700;">Rp {{ number_format($tx->amount, 0, ',', '.') }}</span>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4 m-0" style="font-size: 0.8rem;">Belum ada transaksi.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
