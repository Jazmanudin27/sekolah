<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Students (Data Siswa)
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('class'); // X, XI, XII
            $table->string('major'); // RPL, TKJ, MM, dll
            $table->string('status')->default('aktif'); // aktif, lulus
            $table->timestamps();
        });

        // 2. Teachers (Data Guru)
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->nullable()->unique();
            $table->string('name');
            $table->string('subject'); // Mata Pelajaran
            $table->string('role'); // Guru Utama, Wali Kelas, Kepala Sekolah, Staf
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // 3. Admissions (PPDB Online)
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('previous_school');
            $table->string('major_choice');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();
        });

        // 4. Facilities (Fasilitas Sekolah)
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // 5. Extracurriculars (Ekstrakurikuler)
        Schema::create('extracurriculars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('mentor');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        // 6. Achievements (Prestasi Sekolah)
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('year');
            $table->string('category'); // akademik, non-akademik
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('extracurriculars');
        Schema::dropIfExists('facilities');
        Schema::dropIfExists('admissions');
        Schema::dropIfExists('teachers');
        Schema::dropIfExists('students');
    }
};
