@extends('layouts.admin')

@section('title', 'Kelola Agenda - Panel Admin')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

<div class="row g-4">
    
    <!-- Left Column: Add Event Form -->
    <div class="col-12 col-xl-4">
        <div class="card card-custom p-4">
            <h5 class="font-weight-bold text-dark border-bottom pb-3 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-calendar-plus text-primary"></i> Buat Agenda Baru
            </h5>
            
            <form action="{{ route($routePrefix . 'event.submit') }}" method="POST" style="font-size: 0.8rem;">
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
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Nama Event / Kegiatan</label>
                        <input type="text" name="title" required placeholder="Contoh: Reuni Akbar" class="form-control form-control-sm rounded-3 py-2">
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Waktu Kegiatan</label>
                        <input type="datetime-local" name="date" required class="form-control form-control-sm rounded-3 py-2">
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Lokasi Kegiatan</label>
                        <input type="text" name="location" required placeholder="Aula Utama / Zoom Meeting" class="form-control form-control-sm rounded-3 py-2">
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Foto Pamflet URL</label>
                        <input type="text" name="image" placeholder="Contoh: https://images.unsplash.com/..." class="form-control form-control-sm rounded-3 py-2">
                    </div>
                    <div>
                        <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" style="font-size: 0.65rem; font-weight: 700;">Deskripsi Detail Kegiatan</label>
                        <textarea name="description" rows="5" required placeholder="Tuliskan detail jadwal acara, biaya kontribusi, dan RSVP..." class="form-control rounded-3 py-2"></textarea>
                    </div>
                    <div class="pt-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100 py-2.5 font-weight-bold shadow-sm d-flex align-items-center justify-content-center gap-2" style="font-weight: 700;">
                            Buat Kegiatan <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Right Column: Existing Events Table -->
    <div class="col-12 col-xl-8">
        <div class="card card-custom p-4">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border-bottom pb-3 mb-4">
                <h5 class="font-weight-bold text-dark m-0">Daftar Agenda Terjadwal</h5>
                
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
                            <th scope="col" class="border-0">Nama Kegiatan</th>
                            <th scope="col" class="border-0">Tanggal</th>
                            <th scope="col" class="border-0">Lokasi</th>
                            <th scope="col" class="text-end border-0">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $eventItem)
                            <tr>
                                @if(auth()->user()->role === 'superadmin')
                                    <td><span class="badge bg-light text-dark border">{{ $eventItem->school->name ?? 'Default' }}</span></td>
                                @endif
                                <td class="font-weight-bold text-dark truncate" style="max-width: 250px; font-weight: 700;">
                                    {{ $eventItem->title }}
                                </td>
                                <td class="text-secondary">
                                    {{ $eventItem->date->format('d M Y H:i') }}
                                </td>
                                <td class="font-weight-semibold text-dark" style="font-weight: 600;">
                                    {{ $eventItem->location }}
                                </td>
                                <td class="text-end">
                                    <form action="{{ route($routePrefix . 'event.delete', $eventItem->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus agenda kegiatan ini?')" class="d-inline">
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
                                <td colspan="{{ auth()->user()->role === 'superadmin' ? '5' : '4' }}" class="text-center text-secondary py-5">Belum ada agenda terjadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($events->hasPages())
                <div class="pt-3 border-top mt-3 d-flex justify-content-center">
                    {{ $events->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
