@extends('layouts.admin')

@section('title', 'Kelola Galeri - Panel Admin')

@section('content')
    @php
        $isSuperRoute = request()->routeIs('superadmin.*');
        $routePrefix = $isSuperRoute ? 'superadmin.' : 'admin.';
    @endphp

    <div class="row g-4">

        <!-- Left Column: Add Gallery Item Form -->
        <div class="col-12 col-xl-4">
            <div class="card card-custom p-4">
                <h5 class="font-weight-bold text-dark border-bottom pb-3 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-photo-film text-primary"></i> Unggah Item Galeri
                </h5>

                @if ($errors->any())
                    <div class="alert alert-danger p-3 rounded-3 mb-3 text-start" style="font-size: 0.8rem; line-height: 1.4;">
                        <span class="font-weight-bold d-block mb-1 text-danger"><i class="fa-solid fa-triangle-exclamation"></i> Terjadi Kesalahan:</span>
                        <ul class="mb-0 ps-3 text-danger-emphasis">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route($routePrefix . 'galeri.submit') }}" method="POST" enctype="multipart/form-data" style="font-size: 0.8rem;">
                    @csrf
                    <div class="d-flex flex-column gap-3">
                        @if (auth()->user()->role === 'superadmin')
                            <div>
                                <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1"
                                    style="font-size: 0.65rem; font-weight: 700;">Sekolah Tenant</label>
                                <select name="school_id" required class="form-select form-select-sm rounded-3 py-2">
                                    <option value="">Pilih Sekolah...</option>
                                    @foreach ($allSchools as $s)
                                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                        <div>
                            <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1"
                                style="font-size: 0.65rem; font-weight: 700;">Judul Item Dokumentasi</label>
                            <input type="text" name="title" required placeholder="Contoh: Keseruan Futsal"
                                class="form-control form-control-sm rounded-3 py-2" value="{{ old('title') }}">
                        </div>
                        <div>
                            <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1"
                                style="font-size: 0.65rem; font-weight: 700;">Kategori Galeri</label>
                            <select name="category" class="form-select form-select-sm rounded-3 py-2">
                                <option value="reuni" {{ old('category') == 'reuni' ? 'selected' : '' }}>Kegiatan Reuni</option>
                                <option value="sosial" {{ old('category') == 'sosial' ? 'selected' : '' }}>Bakti Sosial</option>
                                <option value="seminar" {{ old('category') == 'seminar' ? 'selected' : '' }}>Seminar / Webinar</option>
                                <option value="sekolah" {{ old('category') == 'sekolah' ? 'selected' : '' }}>Kegiatan Sekolah</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1"
                                style="font-size: 0.65rem; font-weight: 700;">Tipe Media</label>
                            <select name="type" id="type-select" class="form-select form-select-sm rounded-3 py-2">
                                <option value="foto" {{ old('type') == 'foto' ? 'selected' : '' }}>Foto</option>
                                <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                            </select>
                        </div>
                        <div id="file-upload-container">
                            <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1"
                                style="font-size: 0.65rem; font-weight: 700;">Unggah File Foto (Bisa pilih banyak)</label>
                            <input type="file" name="images[]" id="images-input" multiple accept="image/*"
                                class="form-control form-control-sm rounded-3 py-2">
                            <div class="form-text text-muted mt-1" style="font-size: 0.65rem;">Anda dapat memilih lebih dari satu foto. Format: JPEG, PNG, JPG, GIF, WebP. Maks 10MB per file.</div>
                        </div>
                        <div id="url-container">
                            <label class="form-label text-secondary text-uppercase font-semibold tracking-wider mb-1" id="url-label"
                                style="font-size: 0.65rem; font-weight: 700;">Link / URL Sumber Foto atau Video</label>
                            <input type="url" name="url" id="url-input" placeholder="https://images.unsplash.com/... atau youtube link"
                                class="form-control form-control-sm rounded-3 py-2" value="{{ old('url') }}">
                        </div>
                        <div class="pt-2">
                            <button type="submit"
                                class="btn btn-primary btn-sm w-100 py-2.5 font-weight-bold shadow-sm d-flex align-items-center justify-content-center gap-2"
                                style="font-weight: 700;">
                                Simpan Item <i class="fa-solid fa-save"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Column: Existing Gallery Table -->
        <div class="col-12 col-xl-8">
            <div class="card card-custom p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 border-bottom pb-3 mb-4">
                    <h5 class="font-weight-bold text-dark m-0">Daftar Dokumentasi Terunggah</h5>

                    @if (auth()->user()->role === 'superadmin')
                        <form method="GET" class="d-flex align-items-center gap-2 bg-white p-2 rounded-3 border">
                            <label class="small text-muted font-bold text-nowrap m-0 uppercase tracking-wider"
                                style="font-size: 10px; font-weight: 700;">Filter Sekolah:</label>
                            <select name="school_id" onchange="this.form.submit()"
                                class="form-select form-select-sm rounded-3" style="font-size: 0.8rem; width: 200px;">
                                <option value="">-- Semua Sekolah --</option>
                                @foreach ($allSchools as $s)
                                    <option value="{{ $s->id }}"
                                        {{ request('school_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle table-custom" style="font-size: 0.8rem;">
                        <thead class="table-light text-secondary uppercase font-semibold" style="font-size: 0.75rem;">
                            <tr>
                                @if (auth()->user()->role === 'superadmin')
                                    <th scope="col" class="border-0">Sekolah</th>
                                @endif
                                <th scope="col" class="border-0">Item Dokumentasi</th>
                                <th scope="col" class="border-0">Tipe</th>
                                <th scope="col" class="border-0">Kategori</th>
                                <th scope="col" class="text-end border-0">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($galleries as $galleryItem)
                                <tr>
                                    @if (auth()->user()->role === 'superadmin')
                                        <td><span
                                                class="badge bg-light text-dark border">{{ $galleryItem->school->name ?? 'Default' }}</span>
                                        </td>
                                    @endif
                                    <td>
                                        <div class="d-flex align-items-center gap-2.5">
                                            @if ($galleryItem->type == 'foto')
                                                <img src="{{ $galleryItem->url }}" alt="thumb"
                                                    class="rounded object-cover flex-shrink-0"
                                                    style="width: 42px; height: 42px; border: 1px solid rgba(0,0,0,0.06);">
                                            @else
                                                <div class="d-flex align-items-center justify-content-center bg-dark text-white rounded flex-shrink-0"
                                                    style="width: 42px; height: 42px;">
                                                    <i class="fa-solid fa-play" style="font-size: 0.8rem;"></i>
                                                </div>
                                            @endif
                                            <div class="font-weight-bold text-dark text-truncate"
                                                style="max-width: 250px; font-weight: 700;">
                                                {{ $galleryItem->title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-secondary-subtle text-secondary border border-secondary-subtle text-uppercase"
                                            style="font-size: 0.65rem; font-weight: 700;">
                                            {{ $galleryItem->type }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-primary-subtle text-primary border border-primary-subtle text-uppercase"
                                            style="font-size: 0.65rem; font-weight: 700;">
                                            {{ $galleryItem->category }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <form action="{{ route($routePrefix . 'galeri.delete', $galleryItem->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus item galeri ini?')"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger p-1.5 d-flex align-items-center justify-content-center ms-auto"
                                                style="border-radius: 6px;">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->user()->role === 'superadmin' ? '5' : '4' }}"
                                        class="text-center text-secondary py-5">Belum ada item dokumentasi terunggah.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($galleries->hasPages())
                    <div class="pt-3 border-top mt-3 d-flex justify-content-center">
                        {{ $galleries->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type-select');
            const fileUploadContainer = document.getElementById('file-upload-container');
            const urlLabel = document.getElementById('url-label');
            const urlInput = document.getElementById('url-input');
            const imagesInput = document.getElementById('images-input');

            function toggleFields() {
                if (typeSelect.value === 'foto') {
                    fileUploadContainer.style.display = 'block';
                    urlLabel.innerHTML = 'Atau gunakan URL Foto (Opsional jika upload file)';
                    urlInput.placeholder = 'https://images.unsplash.com/... (Opsional)';
                    urlInput.removeAttribute('required');
                } else if (typeSelect.value === 'video') {
                    fileUploadContainer.style.display = 'none';
                    imagesInput.value = ''; // Reset files
                    urlLabel.innerHTML = 'Link / URL Video <span class="text-danger">*</span>';
                    urlInput.placeholder = 'https://www.youtube.com/watch?v=... (Wajib)';
                    urlInput.setAttribute('required', 'required');
                }
            }

            typeSelect.addEventListener('change', toggleFields);
            // Run once on load
            toggleFields();
        });
    </script>
@endsection
