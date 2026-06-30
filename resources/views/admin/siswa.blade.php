@extends('layouts.admin')

@section('title', 'Kelola Data Siswa - Admin Console')

@section('content')
@php
    $isSuperRoute = request()->routeIs('superadmin.*');
    $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
@endphp

<div class="row g-4">
    <!-- Header Title -->
    <div class="col-12 d-flex justify-content-between align-items-center">
        <div>
            <h1 class="h3 mb-0 text-gray-800 font-bold" style="font-weight: 700;">Kelola Data Siswa</h1>
            <p class="mb-0 text-muted" style="font-size: 0.85rem;">Tambah, edit, atau hapus data siswa aktif sekolah.</p>
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
            <h5 class="font-bold mb-3" id="form-title" style="font-weight: 700;">Tambah Siswa Baru</h5>
            <form action="{{ route($routePrefix . 'siswa.submit') }}" method="POST" id="siswa-form">
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
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" id="input-nis" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: 102030">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Nama Lengkap</label>
                    <input type="text" name="name" id="input-name" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Nama siswa sesuai ijazah...">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Kelas</label>
                    <input type="text" name="class" id="input-class" required class="form-control rounded-3" style="font-size: 0.85rem;" placeholder="Contoh: X RPL 1, XII TKJ 2">
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Jurusan / Program Keahlian</label>
                    <select name="major" id="input-major" required class="form-select rounded-3" style="font-size: 0.85rem;">
                        <option value="">Pilih Jurusan...</option>
                        <option value="RPL">Rekayasa Perangkat Lunak (RPL)</option>
                        <option value="TKJ">Teknik Komputer Jaringan (TKJ)</option>
                        <option value="Multimedia">Multimedia / DKV</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted small uppercase font-bold" style="font-weight: 600; font-size: 0.75rem;">Status Keaktifan</label>
                    <select name="status" id="input-status" required class="form-select rounded-3" style="font-size: 0.85rem;">
                        <option value="aktif">Aktif</option>
                        <option value="lulus">Lulus</option>
                    </select>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary px-4 rounded-3 w-100 font-semibold" style="font-size: 0.85rem;">Simpan Data</button>
                    <button type="button" id="btn-cancel" class="btn btn-light px-3 rounded-3 d-none font-semibold text-secondary" style="font-size: 0.85rem;">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section (Col 8) -->
    <div class="col-lg-8">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="font-bold m-0" style="font-weight: 700;">Daftar Siswa</h5>
                
                <!-- Search bar -->
                <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2 text-xs">
                    @if(request('school_id'))
                        <input type="hidden" name="school_id" value="{{ request('school_id') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIS..." class="form-control form-control-sm px-3 rounded-lg border-slate-200" style="width: 200px;">
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
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($students as $student)
                            <tr>
                                @if(auth()->user()->role === 'superadmin')
                                    <td><span class="badge bg-light text-dark border">{{ $student->school->name ?? 'Default' }}</span></td>
                                @endif
                                <td class="font-semibold text-dark">{{ $student->nis }}</td>
                                <td>
                                    <div class="font-bold text-dark">{{ $student->name }}</div>
                                </td>
                                <td>{{ $student->class }}</td>
                                <td><span class="badge bg-blue-50 text-blue-700 px-2.5 py-1.5 rounded-2">{{ $student->major }}</span></td>
                                <td>
                                    @if ($student->status === 'aktif')
                                        <span class="badge bg-success-subtle text-success px-2 py-1"><i class="fa-solid fa-circle text-success me-1" style="font-size: 6px;"></i> Aktif</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1"><i class="fa-solid fa-graduation-cap text-secondary me-1" style="font-size: 10px;"></i> Lulus</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex align-items-center justify-content-end gap-2">
                                        <button class="btn btn-outline-primary btn-sm edit-btn px-2.5"
                                            data-id="{{ $student->id }}"
                                            data-school-id="{{ $student->school_id }}"
                                            data-nis="{{ $student->nis }}"
                                            data-name="{{ $student->name }}"
                                            data-class="{{ $student->class }}"
                                            data-major="{{ $student->major }}"
                                            data-status="{{ $student->status }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route($routePrefix . 'siswa.delete', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini?')">
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
                                    <i class="fa-solid fa-users-slash fs-2 block mb-2 text-white-50"></i><br>
                                    Belum ada data siswa yang cocok.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $students->links('pagination::bootstrap-5') }}
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
            var nis = $(this).data('nis');
            var name = $(this).data('name');
            var class_name = $(this).data('class');
            var major = $(this).data('major');
            var status = $(this).data('status');

            $('#input-id').val(id);
            $('#input-school-id').val(school_id);
            $('#input-nis').val(nis);
            $('#input-name').val(name);
            $('#input-class').val(class_name);
            $('#input-major').val(major);
            $('#input-status').val(status);

            $('#form-title').text('Edit Data Siswa');
            $('#btn-cancel').removeClass('d-none');
        });

        $('#btn-cancel').on('click', function() {
            $('#siswa-form')[0].reset();
            $('#input-id').val('');
            $('#form-title').text('Tambah Siswa Baru');
            $(this).addClass('d-none');
        });
    });
</script>
@endsection
