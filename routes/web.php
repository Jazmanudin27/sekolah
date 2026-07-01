<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SuperAdminController;

// 1. Central Portal Landing Directory (Accessible via /portal)
Route::middleware(['school'])->get('/portal', [PublicController::class, 'portalHome'])->name('portal.home');

// 2. Tenant-Specific Routes (Domain-based resolution)
Route::middleware(['school'])->group(function () {
    
    // Authentication Routes
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Public Tenant Homepage
    Route::get('/', [PublicController::class, 'index'])->name('home');
    Route::get('/alumni-portal', function() {
        return redirect()->route('home');
    })->name('alumni.home');
    
    // Public Tenant Pages
    Route::get('/profil', [PublicController::class, 'profil'])->name('profil');
    Route::get('/ikatan-alumni', [PublicController::class, 'ikatanAlumni'])->name('ikatan-alumni');
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
    });

    // Central Superadmin Routes (Manage all school tenants)
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
    });
});
