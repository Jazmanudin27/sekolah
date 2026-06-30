@extends('layouts.admin')

@section('title', 'Kelola Data Guru - Admin Console')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

<div class="row g-4">
    <!-- Header Title -->
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-bold" style="font-weight: 700;">Kelola Data Guru</h1>
            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Tambah, edit, atau hapus data pendidik dan staf sekolah.</p>
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
            <h5 class="font-bold mb-3" id="form-title" style="font-weight: 700;">Tambah Guru Baru</h5>
            <form action="{{ route($routePrefix . 'guru.submit') }}" method="POST" id="guru-form" enctype="multipart/form-data">
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
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" id="input-nip" class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Boleh kosong jika GTT / staf...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Nama Lengkap (Gelar)</label>
                    <input type="text" name="name" id="input-name" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: Drs. Hendra, M.Kom.">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Mata Pelajaran Utama</label>
                    <input type="text" name="subject" id="input-subject" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: Matematika, Pemrograman Web...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Jabatan / Peran</label>
                    <input type="text" name="role" id="input-role" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: Guru Utama, Wali Kelas X, Staf TU...">
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Foto Profil</label>
                    <input type="file" name="foto_file" id="input-foto" class="form-control rounded-3" style="font-size: 0.85rem;">
                    <small class="text-muted block mt-1 d-block" style="font-size: 0.7rem;">Maksimal 2 MB (Format: JPG, PNG, WEBP)</small>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 rounded-3 w-100 font-semibold" style="font-size: 0.85rem;">Simpan Guru</button>
                    <button type="button" id="btn-cancel" class="btn btn-light px-3 rounded-3 d-none font-semibold text-secondary" style="font-size: 0.85rem;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section (Col 8) -->
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-bold m-0" style="font-weight: 700;">Daftar Pendidik & Staf</h5>
                
                <!-- Search bar -->
                <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2 text-xs">
                    @if(request('school_id'))
                        <input type="hidden" name="school_id" value="{{ request('school_id') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIP..." class="form-control form-control-sm px-3 rounded-lg border-slate-200" style="width: 200px;">
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
                            <th>NIP / Kode</th>
                            <th>Nama Lengkap</th>
                            <th>Mata Pelajaran</th>
                            <th>Jabatan</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($teachers as $teacher)
                            <tr>
                                @if(auth()->user()->role === 'superadmin')
                                    <td><span class="badge bg-light text-dark border">{{ $teacher->school->name ?? 'Default' }}</span></td>
                                @endif
                                <td>
                                    <img src="{{ $teacher->foto ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=100' }}" alt="guru" class="rounded-circle object-cover border" style="width: 36px; height: 36px;">
                                </td>
                                <td class="font-semibold text-dark">{{ $teacher->nip ?? '-' }}</td>
                                <td>
                                    <div class="font-bold text-dark">{{ $teacher->name }}</div>
                                </td>
                                <td>{{ $teacher->subject }}</td>
                                <td><span class="badge bg-indigo-50 text-indigo-700 px-2.5 py-1.5 rounded-2">{{ $teacher->role }}</span></td>
                                <td class="text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <button class="btn btn-outline-primary btn-sm edit-btn px-2.5"
                                            data-id="{{ $teacher->id }}"
                                            data-school-id="{{ $teacher->school_id }}"
                                            data-nip="{{ $teacher->nip }}"
                                            data-name="{{ $teacher->name }}"
                                            data-subject="{{ $teacher->subject }}"
                                            data-role="{{ $teacher->role }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route($routePrefix . 'guru.delete', $teacher->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pendidik ini?')">
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
                                    <i class="fa-solid fa-chalkboard-user fs-2 block mb-2 text-white-50"></i><br>
                                    Belum ada data guru yang cocok.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $teachers->links('pagination::bootstrap-5') }}
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
            var nip = $(this).data('nip');
            var name = $(this).data('name');
            var subject = $(this).data('subject');
            var role = $(this).data('role');

            $('#input-id').val(id);
            $('#input-school-id').val(school_id);
            $('#input-nip').val(nip);
            $('#input-name').val(name);
            $('#input-subject').val(subject);
            $('#input-role').val(role);

            $('#form-title').text('Edit Data Guru');
            $('#btn-cancel').removeClass('d-none');
        });

        $('#btn-cancel').on('click', function() {
            $('#guru-form')[0].reset();
            $('#input-id').val('');
            $('#form-title').text('Tambah Guru Baru');
            $(this).addClass('d-none');
        });
    });
</script>
@endsection
