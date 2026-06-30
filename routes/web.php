<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\AdminSchoolController;
use App\Http\Controllers\SuperAdminController;

// 1. Central Portal Landing Directory (No Tenant Scope)
Route::get('/', [PublicController::class, 'portalHome'])->name('portal.home');

// 2. Tenant-Specific Routes (Grouped under /s/{school_slug})
Route::middleware(['school'])->prefix('s/{school_slug}')->group(function () {
    
    // Authentication Routes (School-specific)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Public Tenant Homepages
    Route::get('/', [SchoolController::class, 'index'])->name('home');
    Route::get('/alumni-portal', [PublicController::class, 'index'])->name('alumni.home');
    
    // Public Tenant Academic pages
    Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
    Route::get('/ikatan-alumni', [PublicController::class, 'ikatanAlumni'])->name('ikatan-alumni');
    Route::get('/siswa', [SchoolController::class, 'siswa'])->name('siswa');
    Route::get('/guru', [SchoolController::class, 'guru'])->name('guru');
    Route::get('/ppdb', [SchoolController::class, 'ppdb'])->name('ppdb');
    Route::post('/ppdb/daftar', [SchoolController::class, 'daftar'])->name('ppdb.daftar');
    Route::get('/ppdb/status', [SchoolController::class, 'status'])->name('ppdb.status');
    Route::get('/fasilitas', [SchoolController::class, 'fasilitas'])->name('fasilitas');
    Route::get('/ekstrakurikuler', [SchoolController::class, 'ekstrakurikuler'])->name('ekstrakurikuler');
    Route::get('/prestasi', [SchoolController::class, 'prestasi'])->name('prestasi');
    Route::get('/kontak', [PublicController::class, 'kontak'])->name('kontak');
    Route::post('/kontak/submit', [PublicController::class, 'submitKontak'])->name('kontak.submit');
    
    // Public Tenant Alumni Pages
    Route::get('/alumni', [PublicController::class, 'alumni'])->name('alumni');
    Route::get('/alumni/{id}', [PublicController::class, 'alumniDetail'])->name('alumni.detail');
    Route::get('/berita', [PublicController::class, 'berita'])->name('berita');
    Route::get('/berita/{slug}', [PublicController::class, 'beritaDetail'])->name('berita.show');
    Route::get('/agenda', [PublicController::class, 'agenda'])->name('agenda');
    Route::get('/agenda/{slug}', [PublicController::class, 'agendaDetail'])->name('agenda.show');
    Route::post('/agenda/{id}/rsvp', [PublicController::class, 'rsvpEvent'])->name('agenda.rsvp');
    Route::get('/donasi', [PublicController::class, 'donasi'])->name('donasi');
    Route::get('/donasi/{slug}', [PublicController::class, 'donasiDetail'])->name('donasi.show');
    Route::post('/donasi/{id}/submit', [PublicController::class, 'submitDonasi'])->name('donasi.submit');
    Route::get('/karir-bisnis', [PublicController::class, 'karirBisnis'])->name('karir-bisnis');
    Route::post('/karir-bisnis/karir', [PublicController::class, 'submissionKarir'])->name('karir-bisnis.karir.submit');
    Route::post('/karir-bisnis/bisnis', [PublicController::class, 'submissionBisnis'])->name('karir-bisnis.bisnis.submit');
    Route::get('/galeri', [PublicController::class, 'galeri'])->name('galeri');
    Route::get('/forum', [PublicController::class, 'forum'])->name('forum');
    Route::get('/forum/{id}', [PublicController::class, 'forumDetail'])->name('forum.show');
    Route::post('/forum/topic', [PublicController::class, 'submitForumTopic'])->name('forum.topic.submit');
    Route::post('/forum/{id}/reply', [PublicController::class, 'submitForumReply'])->name('forum.reply.submit');

    // Tenant Protected Member Dashboard (Alumni)
    Route::middleware(['auth', 'verified_alumni'])->prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/profil', [DashboardController::class, 'showProfile'])->name('dashboard.profil');
        Route::post('/profil', [DashboardController::class, 'updateProfile'])->name('dashboard.profil.update');
        Route::get('/kartu', [DashboardController::class, 'digitalCard'])->name('dashboard.kartu');
        Route::get('/event', [DashboardController::class, 'events'])->name('dashboard.event');
        Route::get('/donasi', [DashboardController::class, 'donations'])->name('dashboard.donasi');
    });

    // Tenant Protected School/Alumni Admin Dashboard
    Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        
        // Alumni management
        Route::get('/alumni', [AdminController::class, 'alumni'])->name('admin.alumni');
        Route::post('/alumni/{id}/verify', [AdminController::class, 'verifyAlumni'])->name('admin.alumni.verify');
        Route::delete('/alumni/{id}', [AdminController::class, 'deleteAlumni'])->name('admin.alumni.delete');
        
        // News management
        Route::get('/berita', [AdminController::class, 'berita'])->name('admin.berita');
        Route::post('/berita', [AdminController::class, 'submitBerita'])->name('admin.berita.submit');
        Route::delete('/berita/{id}', [AdminController::class, 'deleteBerita'])->name('admin.berita.delete');
        
        // Events management
        Route::get('/event', [AdminController::class, 'event'])->name('admin.event');
        Route::post('/event', [AdminController::class, 'submitEvent'])->name('admin.event.submit');
        Route::delete('/event/{id}', [AdminController::class, 'deleteEvent'])->name('admin.event.delete');
        
        // Donations management
        Route::get('/donasi', [AdminController::class, 'donasi'])->name('admin.donasi');
        Route::post('/donasi', [AdminController::class, 'submitDonasi'])->name('admin.donasi.submit');
        Route::delete('/donasi/{id}', [AdminController::class, 'deleteDonasi'])->name('admin.donasi.delete');
        
        // Gallery management
        Route::get('/galeri', [AdminController::class, 'galeri'])->name('admin.galeri');
        Route::post('/galeri', [AdminController::class, 'submitGaleri'])->name('admin.galeri.submit');
        Route::delete('/galeri/{id}', [AdminController::class, 'deleteGaleri'])->name('admin.galeri.delete');

        // School Admin Management
        Route::get('/siswa', [AdminSchoolController::class, 'siswa'])->name('admin.siswa');
        Route::post('/siswa', [AdminSchoolController::class, 'submitSiswa'])->name('admin.siswa.submit');
        Route::delete('/siswa/{id}', [AdminSchoolController::class, 'deleteSiswa'])->name('admin.siswa.delete');

        Route::get('/guru', [AdminSchoolController::class, 'guru'])->name('admin.guru');
        Route::post('/guru', [AdminSchoolController::class, 'submitGuru'])->name('admin.guru.submit');
        Route::delete('/guru/{id}', [AdminSchoolController::class, 'deleteGuru'])->name('admin.guru.delete');

        Route::get('/ppdb', [AdminSchoolController::class, 'ppdb'])->name('admin.ppdb');
        Route::post('/ppdb/{id}/status', [AdminSchoolController::class, 'verifyPPDB'])->name('admin.ppdb.verify');
        Route::delete('/ppdb/{id}', [AdminSchoolController::class, 'deletePPDB'])->name('admin.ppdb.delete');

        Route::get('/fasilitas', [AdminSchoolController::class, 'fasilitas'])->name('admin.fasilitas');
        Route::post('/fasilitas', [AdminSchoolController::class, 'submitFasilitas'])->name('admin.fasilitas.submit');
        Route::delete('/fasilitas/{id}', [AdminSchoolController::class, 'deleteFasilitas'])->name('admin.fasilitas.delete');

        Route::get('/ekstrakurikuler', [AdminSchoolController::class, 'ekstrakurikuler'])->name('admin.ekstrakurikuler');
        Route::post('/ekstrakurikuler', [AdminSchoolController::class, 'submitEkstrakurikuler'])->name('admin.ekstrakurikuler.submit');
        Route::delete('/ekstrakurikuler/{id}', [AdminSchoolController::class, 'deleteEkstrakurikuler'])->name('admin.ekstrakurikuler.delete');

        Route::get('/prestasi', [AdminSchoolController::class, 'prestasi'])->name('admin.prestasi');
        Route::post('/prestasi', [AdminSchoolController::class, 'submitPrestasi'])->name('admin.prestasi.submit');
        Route::delete('/prestasi/{id}', [AdminSchoolController::class, 'deletePrestasi'])->name('admin.prestasi.delete');
    });

});

// 3. Global Auth Redirects (If accessing /login, /register, or /alumni-portal directly, redirect to Portal directory to choose school)
Route::get('/login', function() {
    return redirect()->route('portal.home')->with('info', 'Silakan pilih sekolah terlebih dahulu untuk masuk.');
});
Route::get('/register', function() {
    return redirect()->route('portal.home')->with('info', 'Silakan pilih sekolah terlebih dahulu untuk mendaftar.');
});
Route::get('/alumni-portal', function() {
    if (auth()->check() && auth()->user()->school) {
        return redirect()->route('alumni.home', ['school_slug' => auth()->user()->school->slug]);
    }
    return redirect()->route('portal.home')->with('info', 'Silakan pilih sekolah terlebih dahulu untuk mengakses Portal Alumni.');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('global.logout');

// 4. Central Superadmin Routes (Manage all school tenants)
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('superadmin.dashboard');
    Route::get('/schools', [SuperAdminController::class, 'index'])->name('superadmin.schools');
    Route::post('/schools', [SuperAdminController::class, 'submitSchool'])->name('superadmin.school.submit');
    Route::delete('/schools/{id}', [SuperAdminController::class, 'deleteSchool'])->name('superadmin.school.delete');

    // Superadmin Tenant Data Management
    Route::get('/alumni', [AdminController::class, 'alumni'])->name('superadmin.alumni');
    Route::post('/alumni/{id}/verify', [AdminController::class, 'verifyAlumni'])->name('superadmin.alumni.verify');
    Route::delete('/alumni/{id}', [AdminController::class, 'deleteAlumni'])->name('superadmin.alumni.delete');

    Route::get('/berita', [AdminController::class, 'berita'])->name('superadmin.berita');
    Route::post('/berita', [AdminController::class, 'submitBerita'])->name('superadmin.berita.submit');
    Route::delete('/berita/{id}', [AdminController::class, 'deleteBerita'])->name('superadmin.berita.delete');

    Route::get('/event', [AdminController::class, 'event'])->name('superadmin.event');
    Route::post('/event', [AdminController::class, 'submitEvent'])->name('superadmin.event.submit');
    Route::delete('/event/{id}', [AdminController::class, 'deleteEvent'])->name('superadmin.event.delete');

    Route::get('/donasi', [AdminController::class, 'donasi'])->name('superadmin.donasi');
    Route::post('/donasi', [AdminController::class, 'submitDonasi'])->name('superadmin.donasi.submit');
    Route::delete('/donasi/{id}', [AdminController::class, 'deleteDonasi'])->name('superadmin.donasi.delete');

    Route::get('/galeri', [AdminController::class, 'galeri'])->name('superadmin.galeri');
    Route::post('/galeri', [AdminController::class, 'submitGaleri'])->name('superadmin.galeri.submit');
    Route::delete('/galeri/{id}', [AdminController::class, 'deleteGaleri'])->name('superadmin.galeri.delete');

    Route::get('/siswa', [AdminSchoolController::class, 'siswa'])->name('superadmin.siswa');
    Route::post('/siswa', [AdminSchoolController::class, 'submitSiswa'])->name('superadmin.siswa.submit');
    Route::delete('/siswa/{id}', [AdminSchoolController::class, 'deleteSiswa'])->name('superadmin.siswa.delete');

    Route::get('/guru', [AdminSchoolController::class, 'guru'])->name('superadmin.guru');
    Route::post('/guru', [AdminSchoolController::class, 'submitGuru'])->name('superadmin.guru.submit');
    Route::delete('/guru/{id}', [AdminSchoolController::class, 'deleteGuru'])->name('superadmin.guru.delete');

    Route::get('/ppdb', [AdminSchoolController::class, 'ppdb'])->name('superadmin.ppdb');
    Route::post('/ppdb/{id}/status', [AdminSchoolController::class, 'verifyPPDB'])->name('superadmin.ppdb.verify');
    Route::delete('/ppdb/{id}', [AdminSchoolController::class, 'deletePPDB'])->name('superadmin.ppdb.delete');

    Route::get('/fasilitas', [AdminSchoolController::class, 'fasilitas'])->name('superadmin.fasilitas');
    Route::post('/fasilitas', [AdminSchoolController::class, 'submitFasilitas'])->name('superadmin.fasilitas.submit');
    Route::delete('/fasilitas/{id}', [AdminSchoolController::class, 'deleteFasilitas'])->name('superadmin.fasilitas.delete');

    Route::get('/ekstrakurikuler', [AdminSchoolController::class, 'ekstrakurikuler'])->name('superadmin.ekstrakurikuler');
    Route::post('/ekstrakurikuler', [AdminSchoolController::class, 'submitEkstrakurikuler'])->name('superadmin.ekstrakurikuler.submit');
    Route::delete('/ekstrakurikuler/{id}', [AdminSchoolController::class, 'deleteEkstrakurikuler'])->name('superadmin.ekstrakurikuler.delete');

    Route::get('/prestasi', [AdminSchoolController::class, 'prestasi'])->name('superadmin.prestasi');
    Route::post('/prestasi', [AdminSchoolController::class, 'submitPrestasi'])->name('superadmin.prestasi.submit');
    Route::delete('/prestasi/{id}', [AdminSchoolController::class, 'deletePrestasi'])->name('superadmin.prestasi.delete');
});
