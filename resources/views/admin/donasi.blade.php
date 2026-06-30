@extends('layouts.admin')

@section('title', 'Kelola Donasi - Panel Admin')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

<div class="row g-4">
    
    <!-- Left Column: Add Donation Form -->
    <div class="col-12 col-xl-4">
        <div class="card card-custom p-4">
            <h5 class="font-weight-bold text-dark border-bottom pb-3 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-file-invoice-dollar text-primary"></i> Tambah Kampanye
            </h5>
            
            <form action="{{ route($routePrefix . 'donasi.submit') }}" method="POST" style="font-size: 0.8rem;">
                @csrf
                <div class="d-flex flex-column gap-3">
                    @if(auth()->user()->role === 'superadmin')
                        <div>
                            <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Sekolah Tenant</label>
                            <select name="school_id" required class="form-select form-select-sm rounded-3 py-2">
                                <option value="">Pilih Sekolah...</option>
                                @foreach($allSchools as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Nama Kampanye / Penggalangan</label>
                        <input type="text" name="title" required placeholder="Beasiswa Lulusan 2026" class="form-control form-control-sm rounded-3 py-2">
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Target Nominal (Rp)</label>
                        <input type="number" name="target_amount" required placeholder="Contoh: 50000000" class="form-control form-control-sm rounded-3 py-2">
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Tipe Donasi</label>
                        <select name="type" class="form-select form-select-sm rounded-3 py-2">
                            <option value="pembangunan">Pembangunan Sekolah</option>
                            <option value="beasiswa">Beasiswa Siswa</option>
                            <option value="sosial">Santunan Sosial</option>
                            <option value="bencana">Donasi Bencana</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Foto Kampanye URL</label>
                        <input type="text" name="image" placeholder="Contoh: https://images.unsplash.com/..." class="form-control form-control-sm rounded-3 py-2">
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Deskripsi & Anggaran</label>
                        <textarea name="description" rows="4" required class="form-control rounded-3 py-2" placeholder="Jelaskan tujuan penggalangan dana..."></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100 py-2.5 font-weight-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="font-weight: 700;">
                            Simpan Kampanye <i class="fa-solid fa-save"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Campaigns and Transactions -->
    <div class="col-12 col-xl-8 d-flex flex-column gap-4">
        
        <!-- Campaigns Table -->
        <div class="card card-custom p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border-bottom pb-3 mb-4">
                <h5 class="font-weight-bold text-dark m-0">Kampanye Donasi Aktif</h5>
                
                @if(auth()->user()->role === 'superadmin')
                    <form method="GET" class="d-flex align-items-center gap-2 bg-white p-2 rounded-3 border">
                        <label class="small text-muted font-bold text-nowrap m-0 uppercase tracking-wider" style="font-size: 10px; font-weight: 700;">Filter Sekolah:</label>
                        <select name="school_id" onchange="this.form.submit()" class="form-select form-select-sm rounded-3" style="font-size: 0.8rem; width: 200px;">
                            <option value="">-- Semua Sekolah --</option>
                            @foreach($allSchools as $s)
                                <option value="{{ $s->id }}" {{ request('school_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle table-custom" style="font-size: 0.8rem;">
                    <thead class="table-light text-secondary uppercase font-semibold" style="font-size: 0.75rem;">
                        <tr>
                            @if(auth()->user()->role === 'superadmin')
                                <th scope="col" class="border-0">Sekolah</th>
                            @endif
                            <th scope="col" class="border-0">Judul Kampanye</th>
                            <th scope="col" class="border-0">Tipe</th>
                            <th scope="col" class="border-0">Target Dana</th>
                            <th scope="col" class="border-0">Dana Terkumpul</th>
                            <th scope="col" class="text-end border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($donations as $donationItem)
                            <tr>
                                @if(auth()->user()->role === 'superadmin')
                                    <td><span class="badge bg-light text-dark border">{{ $donationItem->school->name ?? 'Default' }}</span></td>
                                @endif
                                <td class="font-weight-bold text-dark truncate" style="max-width: 250px; font-weight: 700;">
                                    {{ $donationItem->title }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle text-uppercase" style="font-size: 0.65rem; font-weight: 700;">
                                        {{ $donationItem->type }}
                                    </span>
                                </td>
                                <td class="text-dark">
                                    Rp {{ number_format($donationItem->target_amount, 0, ',', '.') }}
                                </td>
                                <td class="font-weight-bold text-primary" style="font-weight: 700;">
                                    Rp {{ number_format($donationItem->raised_amount, 0, ',', '.') }}
                                </td>
                                <td class="text-end">
                                    <form action="{{ route($routePrefix . 'donasi.delete', $donationItem->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kampanye ini?')" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger p-1.5 d-flex align-items-center justify-content-center ms-auto" style="border-radius: 6px;">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'superadmin' ? '6' : '5' }}" class="text-center text-secondary py-5">Belum ada kampanye donasi dibuat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Transactions Log Table -->
        <div class="card card-custom p-4">
            <h5 class="font-weight-bold text-dark border-bottom pb-3 mb-4">Log Seluruh Transaksi Donasi Masuk</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle table-custom" style="font-size: 0.8rem;">
                    <thead class="table-light text-secondary uppercase font-semibold" style="font-size: 0.75rem;">
                        <tr>
                            <th scope="col" class="border-0">Nama Donatur</th>
                            <th scope="col" class="border-0">Kampanye</th>
                            <th scope="col" class="border-0">Jumlah</th>
                            <th scope="col" class="border-0">Metode</th>
                            <th scope="col" class="border-0">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $txItem)
                            <tr>
                                <td class="font-weight-bold text-dark" style="font-weight: 700;">
                                    {{ $txItem->donor_name }}
                                </td>
                                <td class="truncate" style="max-width: 200px;">
                                    {{ $txItem->donation->title }} ({{ $txItem->donation->school->name ?? 'Default' }})
                                </td>
                                <td class="font-weight-bold text-success" style="font-weight: 700;">
                                    Rp {{ number_format($txItem->amount, 0, ',', '.') }}
                                </td>
                                <td class="text-dark">
                                    <span class="badge bg-light text-dark border" style="font-size: 0.65rem;">{{ $txItem->payment_method }}</span>
                                </td>
                                <td class="text-secondary">
                                    {{ $txItem->created_at->format('d M Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-secondary py-5">Belum ada transaksi terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($transactions->hasPages())
                <div class="pt-3 border-top mt-3 d-flex justify-content-center">
                    {{ $transactions->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
