<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Admission;
use App\Models\Facility;
use App\Models\Extracurricular;
use App\Models\Achievement;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school1 = School::where('slug', 'smkn1')->first();
        $school2 = School::where('slug', 'man2tasik')->first();

        if (!$school1 || !$school2) {
            return;
        }

        // 1. Seed Students (Data Siswa)
        $students = [
            // SMKN 1
            [
                'nis' => '102030',
                'name' => 'Andi Wijaya',
                'class' => 'X RPL 1',
                'major' => 'RPL',
                'status' => 'aktif',
                'school_id' => $school1->id,
            ],
            [
                'nis' => '102031',
                'name' => 'Budi Raharjo',
                'class' => 'XI TKJ 2',
                'major' => 'TKJ',
                'status' => 'aktif',
                'school_id' => $school1->id,
            ],
            [
                'nis' => '102032',
                'name' => 'Citra Lestari',
                'class' => 'XII MM 1',
                'major' => 'Multimedia',
                'status' => 'aktif',
                'school_id' => $school1->id,
            ],
            // MAN 2
            [
                'nis' => '203040',
                'name' => 'Dina Safitri',
                'class' => 'X Keagamaan 2',
                'major' => 'Keagamaan',
                'status' => 'aktif',
                'school_id' => $school2->id,
            ],
            [
                'nis' => '203041',
                'name' => 'Eko Prasetyo',
                'class' => 'XI IPS 1',
                'major' => 'IPS',
                'status' => 'aktif',
                'school_id' => $school2->id,
            ],
            [
                'nis' => '203042',
                'name' => 'Fajar Ramadhan',
                'class' => 'XII IPA 1',
                'major' => 'IPA',
                'status' => 'lulus',
                'school_id' => $school2->id,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        // 2. Seed Teachers (Data Guru)
        $teachers = [
            // SMKN 1
            [
                'nip' => '198001012010011001',
                'name' => 'Drs. M. Taufik, M.Pd.',
                'subject' => 'Kepala Sekolah',
                'role' => 'Kepala Sekolah',
                'foto' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=400',
                'school_id' => $school1->id,
            ],
            [
                'nip' => '198502022015022002',
                'name' => 'Sri Wahyuni, S.Pd.',
                'subject' => 'Bahasa Indonesia',
                'role' => 'Guru Utama / Wali Kelas XI',
                'foto' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400',
                'school_id' => $school1->id,
            ],
            // MAN 2
            [
                'nip' => '198203032012031003',
                'name' => 'Drs. H. Ahmad Fauzi, M.Ag.',
                'subject' => 'Kepala Madrasah',
                'role' => 'Kepala Sekolah',
                'foto' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=400',
                'school_id' => $school2->id,
            ],
            [
                'nip' => '199004042021042004',
                'name' => 'Dewi Kartika, S.Pd.',
                'subject' => 'Fiqih & Ushul Fiqih',
                'role' => 'Guru Pembimbing Kajian Keagamaan',
                'foto' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400',
                'school_id' => $school2->id,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        // 3. Seed PPDB Admissions (PPDB Online)
        $admissions = [
            // SMKN 1
            [
                'registration_number' => 'PPDB-2026-0001',
                'name' => 'Gilang Permana',
                'email' => 'gilang@gmail.com',
                'phone' => '081234567890',
                'previous_school' => 'SMPN 1 Kota',
                'major_choice' => 'RPL',
                'status' => 'approved',
                'school_id' => $school1->id,
            ],
            [
                'registration_number' => 'PPDB-2026-0002',
                'name' => 'Hani Amalia',
                'email' => 'hani@gmail.com',
                'phone' => '082345678901',
                'previous_school' => 'SMPN 3 Kota',
                'major_choice' => 'Multimedia',
                'status' => 'pending',
                'school_id' => $school1->id,
            ],
            // MAN 2
            [
                'registration_number' => 'PPDB-2026-0003',
                'name' => 'Indra Gunawan',
                'email' => 'indra@gmail.com',
                'phone' => '083456789012',
                'previous_school' => 'MTs Negeri 1 Tasikmalaya',
                'major_choice' => 'IPA',
                'status' => 'approved',
                'school_id' => $school2->id,
            ],
        ];

        foreach ($admissions as $admission) {
            Admission::create($admission);
        }

        // 4. Seed Facilities (Fasilitas Sekolah)
        $facilities = [
            // SMKN 1
            [
                'name' => 'Laboratorium Komputer & Jaringan',
                'description' => 'Laboratorium komputer berspesifikasi tinggi (high-end PC) dengan koneksi internet fiber optic 100 Mbps, router Cisco, dan server lokal untuk mendukung praktikum pemrograman, perakitan PC, dan administrasi server jaringan.',
                'image' => 'https://images.unsplash.com/photo-1562774053-701939374585?w=800',
                'school_id' => $school1->id,
            ],
            [
                'name' => 'Perpustakaan Digital Modern',
                'description' => 'Perpustakaan yang memadukan ribuan koleksi buku fisik dengan katalog digital (e-library). Dilengkapi ruangan ber-AC yang tenang, komputer akses internet, area baca santai, dan ruang diskusi kelompok.',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800',
                'school_id' => $school1->id,
            ],
            // MAN 2
            [
                'name' => 'Laboratorium Keagamaan & Bahasa',
                'description' => 'Laboratorium bahasa modern terintegrasi dengan multimedia headset dan sistem monitoring ujian mandiri keagamaan.',
                'image' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800',
                'school_id' => $school2->id,
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }

        // 5. Seed Extracurriculars (Ekstrakurikuler)
        $extracurriculars = [
            // SMKN 1
            [
                'name' => 'IT Club & Robotik',
                'description' => 'Wadah bagi siswa untuk mengasah kemampuan pemrograman, IoT, perakitan robot, serta bersiap mengikuti ajang kompetisi robotik tingkat nasional.',
                'mentor' => 'Eko Yulianto, S.Kom.',
                'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800',
                'school_id' => $school1->id,
            ],
            [
                'name' => 'Pramuka Wira Kartika',
                'description' => 'Mengembangkan kedisiplinan, kepemimpinan, kepedulian sosial, serta keterampilan kepramukaan untuk membentuk karakter siswa yang tangguh dan mandiri.',
                'mentor' => 'Sri Wahyuni, S.Pd.',
                'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800',
                'school_id' => $school1->id,
            ],
            // MAN 2
            [
                'name' => 'Hadroh & Syiar Islami',
                'description' => 'Ekstrakurikuler hadroh, seni musik banjari, dan kajian syiar Islam untuk syiar dakwah kreatif.',
                'mentor' => 'Drs. H. Ahmad Fauzi, M.Ag.',
                'image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=800',
                'school_id' => $school2->id,
            ],
        ];

        foreach ($extracurriculars as $extracurricular) {
            Extracurricular::create($extracurricular);
        }

        // 6. Seed Achievements (Prestasi)
        $achievements = [
            // SMKN 1
            [
                'title' => 'Juara 1 Lomba Kompetensi Siswa (LKS) Tingkat Nasional',
                'year' => 2025,
                'category' => 'akademik',
                'description' => 'Siswa SMKN 1 berhasil meraih medali emas pada LKS Tingkat Nasional ke-33 dalam bidang lomba Web Technologies.',
                'image' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800',
                'school_id' => $school1->id,
            ],
            [
                'title' => 'Juara 2 Turnamen Futsal Piala Walikota',
                'year' => 2025,
                'category' => 'non-akademik',
                'description' => 'Tim futsal sekolah meraih posisi runner-up pada kejuaraan futsal antar pelajar se-kota setelah melalui drama adu penalti di final.',
                'image' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?w=800',
                'school_id' => $school1->id,
            ],
            // MAN 2
            [
                'title' => 'Medali Emas Olimpiade Bahasa Arab Nasional',
                'year' => 2025,
                'category' => 'akademik',
                'description' => 'Siswa MAN 2 KOTA TASIKMALAYA menyabet medali emas di ajang kompetisi sains madrasah tingkat nasional.',
                'image' => 'https://images.unsplash.com/photo-1546410531-bb4caa6b424d?w=800',
                'school_id' => $school2->id,
            ],
        ];

        foreach ($achievements as $achievement) {
            Achievement::create($achievement);
        }
    }
}
