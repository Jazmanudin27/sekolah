@extends('layouts.admin')

@section('title', 'Super Admin ERP - Kelola Sekolah')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="font-weight-bold text-dark m-0" style="font-weight: 800;">Kelola Tenant Sekolah</h4>
            <p class="text-xs text-secondary m-0">Daftarkan dan konfigurasikan sekolah/tenant baru dalam sistem ERP.</p>
        </div>
        <span class="badge bg-primary px-3 py-2 rounded-3" style="font-size: 0.8rem;">
            Total: {{ $schools->count() }} Sekolah
        </span>
    </div>

    <div class="row g-4">
        <!-- Schools List -->
        <div class="col-lg-8">
            <div class="card card-custom border-0 p-4">
                <h5 class="font-weight-bold text-dark mb-3" style="font-weight: 700;">Sekolah Terdaftar</h5>
                <div class="table-responsive">
                    <table class="table table-custom align-middle text-xs">
                        <thead>
                            <tr class="text-secondary font-semibold" style="font-size: 0.75rem;">
                                <th>Nama Sekolah</th>
                                <th>Branding Warna</th>
                                <th>Jumlah Data</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($schools as $school)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="d-flex align-items-center justify-content-center bg-light border rounded-3 text-secondary" style="width: 40px; height: 40px;">
                                                <i class="fa-solid fa-school fs-5"></i>
                                            </span>
                                            <div>
                                                <h6 class="font-weight-bold text-dark m-0" style="font-weight: 700;">{{ $school->name }}</h6>
                                                <small class="text-slate-400">Slug: <code class="bg-light px-1.5 py-0.5 rounded text-dark">{{ $school->slug }}</code></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="d-inline-block rounded-circle border" style="width: 14px; height: 14px; background-color: {{ $school->primary_color }}" title="Warna Utama"></span>
                                            <span class="d-inline-block rounded-circle border" style="width: 14px; height: 14px; background-color: {{ $school->secondary_color }}" title="Warna Kedua"></span>
                                            <span class="text-secondary text-[11px]">{{ $school->primary_color }} / {{ $school->secondary_color }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-2">
                                            <span class="badge bg-light text-dark border px-2 py-1"><i class="fa-solid fa-user-graduate text-secondary me-1"></i> {{ $school->users_count }} Alumni</span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            @php
                                                $baseHost = request()->getHost();
                                                foreach(\App\Models\School::all() as $s) {
                                                    if (str_starts_with($baseHost, $s->slug . '.')) {
                                                        $baseHost = substr($baseHost, strlen($s->slug . '.'));
                                                        break;
                                                    }
                                                }
                                                $schoolUrl = '//' . $school->slug . '.' . $baseHost . (request()->getPort() ? ':' . request()->getPort() : '');
                                            @endphp
                                            <a href="{{ $schoolUrl }}" target="_blank" class="btn btn-light btn-sm text-secondary border px-2.5 rounded-3 d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Kunjungi
                                            </a>
                                            <form action="{{ route('superadmin.school.delete', $school->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sekolah ini? Seluruh data relasi terkait akan terhapus permanen.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm border-0 px-2.5 rounded-3 d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Create School Form -->
        <div class="col-lg-4">
            <div class="card card-custom border-0 p-4">
                <h5 class="font-weight-bold text-dark mb-3" style="font-weight: 700;">Tambah Sekolah</h5>
                
                <form action="{{ route('superadmin.school.submit') }}" method="POST" class="row g-3 text-xs">
                    @csrf
                    <div class="col-12">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Nama Sekolah</label>
                        <input type="text" name="name" required class="form-control text-xs px-3 py-2.5 border rounded-lg" placeholder="Contoh: SMK Negeri 1">
                    </div>

                    <div class="col-12">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Slug URL</label>
                        <input type="text" name="slug" required class="form-control text-xs px-3 py-2.5 border rounded-lg" placeholder="Contoh: smkn1">
                    </div>

                    <div class="col-6">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Warna Utama</label>
                        <div class="d-flex gap-2">
                            <input type="color" id="primary-picker" class="form-control form-control-color border" value="#1e3a8a" style="width: 42px; height: 38px;">
                            <input type="text" name="primary_color" id="primary-color" required class="form-control text-xs px-2 border" value="#1e3a8a">
                        </div>
                    </div>
                    
                    <div class="col-6">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Warna Kedua</label>
                        <div class="d-flex gap-2">
                            <input type="color" id="secondary-picker" class="form-control form-control-color border" value="#3b82f6" style="width: 42px; height: 38px;">
                            <input type="text" name="secondary_color" id="secondary-color" required class="form-control text-xs px-2 border" value="#3b82f6">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Sambutan Kepsek (Opsional)</label>
                        <textarea name="welcome_headmaster" rows="3" class="form-control text-xs px-3 py-2 border rounded-lg" placeholder="Kalimat sambutan di beranda sekolah"></textarea>
                    </div>

                    <div class="col-12">
                        <label class="font-bold text-slate-400 uppercase tracking-wider text-[9px]">Alamat (Opsional)</label>
                        <input type="text" name="address" class="form-control text-xs px-3 py-2.5 border rounded-lg" placeholder="Alamat fisik sekolah">
                    </div>

                    <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-primary w-full py-2.5 rounded-lg text-xs font-semibold shadow-sm">
                            Daftarkan Tenant <i class="fa-solid fa-paper-plane ml-1"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const pPicker = document.getElementById('primary-picker');
        const pInput = document.getElementById('primary-color');
        if (pPicker && pInput) {
            pPicker.addEventListener('input', () => { pInput.value = pPicker.value; });
            pInput.addEventListener('input', () => { pPicker.value = pInput.value; });
        }

        const sPicker = document.getElementById('secondary-picker');
        const sInput = document.getElementById('secondary-color');
        if (sPicker && sInput) {
            sPicker.addEventListener('input', () => { sInput.value = sPicker.value; });
            sInput.addEventListener('input', () => { sPicker.value = sInput.value; });
        }
    });
</script>
@endsection
