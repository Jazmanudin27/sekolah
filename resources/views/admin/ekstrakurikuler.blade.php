@extends('layouts.admin')

@section('title', 'Kelola Ekstrakurikuler - Admin Console')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

<div class="row g-4">
    <!-- Header Title -->
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-bold" style="font-weight: 700;">Kelola Ekstrakurikuler</h1>
            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Tambah, edit, atau hapus kegiatan ekstrakurikuler siswa sekolah.</p>
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
            <h5 class="font-bold mb-3" id="form-title" style="font-weight: 700;">Tambah Ekstrakurikuler</h5>
            <form action="{{ route($routePrefix . 'ekstrakurikuler.submit') }}" method="POST" id="ekstra-form" enctype="multipart/form-data">
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
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Nama Ekskul</label>
                    <input type="text" name="name" id="input-name" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: Pramuka, OSIS, Paskibra...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Pembina / Mentor Koordinator</label>
                    <input type="text" name="mentor" id="input-mentor" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: Drs. M. Taufik, M.Pd...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Deskripsi Kegiatan</label>
                    <textarea name="description" id="input-description" required rows="4" class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Jelaskan jenis kegiatan ekskul ini..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Foto / Logo Ekskul</label>
                    <input type="file" name="image_file" id="input-image" class="form-control rounded-3" style="font-size: 0.85rem;">
                    <small class="text-muted block mt-1 d-block" style="font-size: 0.7rem;">Maksimal 2 MB (Format: JPG, PNG, WEBP)</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 rounded-3 w-100 font-semibold" style="font-size: 0.85rem;">Simpan Ekskul</button>
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
                <h5 class="font-bold m-0" style="font-weight: 700;">Daftar Ekskul</h5>
                
                <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2 text-xs">
                    @if(request('school_id'))
                        <input type="hidden" name="school_id" value="{{ request('school_id') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama ekskul/pembina..." class="form-control form-control-sm px-3 rounded-lg border-slate-200" style="width: 200px;">
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
                            <th>Logo</th>
                            <th>Nama Kegiatan</th>
                            <th>Pembina / Mentor</th>
                            <th>Deskripsi Ringkas</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ekstras as $ekstra)
                            <tr>
                                @if(auth()->user()->role === 'superadmin')
                                    <td><span class="badge bg-light text-dark border">{{ $ekstra->school->name ?? 'Default' }}</span></td>
                                @endif
                                <td>
                                    <img src="{{ $ekstra->image ?? 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=100' }}" alt="logo" class="rounded-3 border object-cover" style="width: 48px; height: 36px;">
                                </td>
                                <td>
                                    <div class="font-bold text-dark">{{ $ekstra->name }}</div>
                                </td>
                                <td>{{ $ekstra->mentor }}</td>
                                <td class="text-muted text-wrap" style="max-width: 220px;">{{ Str::limit($ekstra->description, 80) }}</td>
                                <td class="text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <button class="btn btn-outline-primary btn-sm edit-btn px-2.5"
                                            data-id="{{ $ekstra->id }}"
                                            data-school-id="{{ $ekstra->school_id }}"
                                            data-name="{{ $ekstra->name }}"
                                            data-mentor="{{ $ekstra->mentor }}"
                                            data-description="{{ $ekstra->description }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route($routePrefix . 'ekstrakurikuler.delete', $ekstra->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus ekskul ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm px-2.5"><i class="fa-solid fa-trash-can"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'superadmin' ? '6' : '5' }}" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-people-group fs-2 block mb-2 text-white-50"></i><br>
                                    Belum ada data ekstrakurikuler.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $ekstras->links('pagination::bootstrap-5') }}
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
            var name = $(this).data('name');
            var mentor = $(this).data('mentor');
            var description = $(this).data('description');

            $('#input-id').val(id);
            $('#input-school-id').val(school_id);
            $('#input-name').val(name);
            $('#input-mentor').val(mentor);
            $('#input-description').val(description);

            $('#form-title').text('Edit Ekstrakurikuler');
            $('#btn-cancel').removeClass('d-none');
        });

        $('#btn-cancel').on('click', function() {
            $('#ekstra-form')[0].reset();
            $('#input-id').val('');
            $('#form-title').text('Tambah Ekstrakurikuler');
            $(this).addClass('d-none');
        });
    });
</script>
@endsection
