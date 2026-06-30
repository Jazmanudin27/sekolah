@extends('layouts.admin')

@section('title', 'Kelola Prestasi - Admin Console')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

<div class="row g-4">
    <!-- Header Title -->
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-bold" style="font-weight: 700;">Kelola Prestasi Sekolah</h1>
            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Tambah, edit, atau hapus dokumentasi prestasi akademik dan non-akademik sekolah.</p>
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

    <!-- Form Section (Col 4) & Table Section (Col 8) -->
    <div class="col-lg-4">
        <div class="card card-custom p-4">
            <h5 class="font-bold mb-3" id="form-title" style="font-weight: 700;">Tambah Prestasi</h5>
            <form action="{{ route($routePrefix . 'prestasi.submit') }}" method="POST" id="prestasi-form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" id="input-id">

                @if(auth()->user()->role === 'superadmin')
                    <div class="mb-3">
                        <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Sekolah Tenant</label>
                        <select name="school_id" id="input-school-id" required class="form-select rounded-3" style="font-size: 0.85rem;">
                            <option value="">Pilih Sekolah...</option>
                            @foreach($allSchools as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Judul / Nama Prestasi</label>
                    <input type="text" name="title" id="input-title" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: Juara 1 LKS RPL Tingkat Nasional...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Tahun Perolehan</label>
                    <input type="text" name="year" id="input-year" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: 2025, 2026...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Kategori</label>
                    <select name="category" id="input-category" required class="form-select rounded-3" style="font-size: 0.85rem;">
                        <option value="akademik">Akademik</option>
                        <option value="non-akademik">Non-Akademik</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Deskripsi Singkat Pencapaian</label>
                    <textarea name="description" id="input-description" required rows="4" class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Jelaskan kontingen perlombaan, capaian medali, atau detail prestasi lainnya..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Foto Penghargaan / Piala</label>
                    <input type="file" name="image_file" id="input-image" class="form-control rounded-3" style="font-size: 0.85rem;">
                    <small class="text-muted block mt-1 d-block" style="font-size: 0.7rem;">Maksimal 2 MB (Format: JPG, PNG, WEBP)</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 rounded-3 w-100 font-semibold" style="font-size: 0.85rem;">Simpan Prestasi</button>
                    <button type="button" id="btn-cancel" class="btn btn-light px-3 rounded-3 d-none font-semibold text-secondary" style="font-size: 0.85rem;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section (Col 8) -->
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <!-- Search & Title -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-bold m-0" style="font-weight: 700;">Daftar Prestasi</h5>
                
                <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2 text-xs">
                    @if(request('school_id'))
                        <input type="hidden" name="school_id" value="{{ request('school_id') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama prestasi..." class="form-control form-control-sm px-3 rounded-lg border-slate-200" style="width: 200px;">
                    <button type="submit" class="btn btn-primary btn-sm px-3 rounded-lg"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-custom align-middle text-xs">
                    <thead>
                        <tr class="text-secondary font-semibold" style="font-size: 0.75rem;">
                            @if(auth()->user()->role === 'superadmin')
                                <th>Sekolah</th>
                            @endif
                            <th>Foto</th>
                            <th>Tahun</th>
                            <th>Nama Prestasi</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($achievements as $ach)
                            <tr>
                                @if(auth()->user()->role === 'superadmin')
                                    <td><span class="badge bg-light text-dark border">{{ $ach->school->name ?? 'Default' }}</span></td>
                                @endif
                                <td>
                                    <img src="{{ $ach->image ?? 'https://images.unsplash.com/photo-1578575437130-527eed3abbec?w=100' }}" alt="foto" class="rounded-3 border object-cover" style="width: 48px; height: 36px;">
                                </td>
                                <td class="font-semibold text-dark">{{ $ach->year }}</td>
                                <td>
                                    <div class="font-bold text-dark">{{ $ach->title }}</div>
                                </td>
                                <td>
                                    @if ($ach->category === 'akademik')
                                        <span class="badge bg-success-subtle text-success px-2.5 py-1.5 rounded-2">Akademik</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning px-2.5 py-1.5 rounded-2">Non-Akademik</span>
                                    @endif
                                </td>
                                <td class="text-muted text-wrap" style="max-width: 220px;">{{ Str::limit($ach->description, 80) }}</td>
                                <td class="text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <button class="btn btn-outline-primary btn-sm edit-btn px-2.5"
                                            data-id="{{ $ach->id }}"
                                            data-school-id="{{ $ach->school_id }}"
                                            data-title="{{ $ach->title }}"
                                            data-year="{{ $ach->year }}"
                                            data-category="{{ $ach->category }}"
                                            data-description="{{ $ach->description }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route($routePrefix . 'prestasi.delete', $ach->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data prestasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2.5"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'superadmin' ? '7' : '6' }}" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-trophy fs-2 block mb-2 text-white-50"></i><br>
                                    Belum ada data prestasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $achievements->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- jQuery script to handle Edit Mode dynamically in card form -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.edit-btn').on('click', function() {
            var id = $(this).data('id');
            var school_id = $(this).data('school-id');
            var title = $(this).data('title');
            var year = $(this).data('year');
            var category = $(this).data('category');
            var description = $(this).data('description');

            $('#input-id').val(id);
            $('#input-school-id').val(school_id);
            $('#input-title').val(title);
            $('#input-year').val(year);
            $('#input-category').val(category);
            $('#input-description').val(description);

            $('#form-title').text('Edit Prestasi');
            $('#btn-cancel').removeClass('d-none');
        });

        $('#btn-cancel').on('click', function() {
            $('#prestasi-form')[0].reset();
            $('#input-id').val('');
            $('#form-title').text('Tambah Prestasi');
            $(this).addClass('d-none');
        });
    });
</script>
@endsection
