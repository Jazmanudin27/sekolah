<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use App\Models\Post;
use App\Models\Event;
use App\Models\EventRsvp;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\Career;
use App\Models\Business;
use App\Models\ForumTopic;
use App\Models\ForumReply;
use App\Models\Gallery;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Schools (Tenants)
        $school1 = School::create([
            'name' => 'SMK Negeri 1',
            'slug' => 'smkn1',
            'logo' => null,
            'primary_color' => '#1e3a8a', // Blue
            'secondary_color' => '#3b82f6', // Light Blue
            'welcome_headmaster' => 'Selamat datang di SMK Negeri 1. Kami mendidik generasi vokasi yang unggul, berkarakter, berwawasan wirausaha, dan siap bersaing di kancah global.',
            'welcome_alumni' => 'Selamat datang di Portal Ikatan Alumni SMK Negeri 1. Mari berkolaborasi, mempererat silaturahmi, dan berkontribusi nyata bagi almamater tercinta.',
            'history' => 'SMK Negeri 1 didirikan pada tahun 1978 sebagai sekolah menengah kejuruan perintis di wilayah ini. Sejak awal pendirian, kami telah mencetak puluhan ribu lulusan yang berkiprah di dunia usaha maupun industri nasional.',
            'vision' => 'Menjadi pusat pendidikan kejuruan yang unggul menghasilkan lulusan profesional berkarakter mulia.',
            'mission' => "1. Menyelenggarakan pembelajaran berkualitas berbasis kompetensi industri.\n2. Menjalin kerja sama erat dengan dunia usaha dan dunia industri (DUDI).\n3. Menanamkan disiplin, etika profesi, dan nilai ketakwaan.",
            'address' => 'Jl. Pendidikan No. 45, Raya Pusat, Kota Madya',
            'phone' => '+62 812-3456-7890',
            'email' => 'info@smkn1raya.sch.id',
            'google_maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8354890695026!2d107.61860611477292!3d-6.910103995007055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e63a1a1f33f3%3A0x28ad42e472be3a52!2sGedung%20Sate!5e0!3m2!1sid!2sid!4v1656467000000!5m2!1sid!2sid" class="w-full h-full rounded-2xl border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ]);

        $school2 = School::create([
            'name' => 'MAN 2 KOTA TASIKMALAYA',
            'slug' => 'man2tasik',
            'logo' => null,
            'primary_color' => '#047857', // Emerald Green
            'secondary_color' => '#10b981', // Light Emerald
            'welcome_headmaster' => 'Selamat datang di MAN 2 KOTA TASIKMALAYA. Kami berkomitmen menyelenggarakan pendidikan madrasah aliyah negeri terbaik yang mengasah kecerdasan intelektual, emosional, spiritual, dan berakhlaqul karimah.',
            'welcome_alumni' => 'Selamat datang di Portal Alumni MAN 2 KOTA TASIKMALAYA. Mari jalin persaudaraan, sinergi karir, dan wadah donasi sosial bagi perkembangan almamater.',
            'history' => 'MAN 2 KOTA TASIKMALAYA didirikan untuk memenuhi kebutuhan pendidikan menengah keagamaan dan umum berkualitas tinggi di wilayah Tasikmalaya. Kini kami dikenal dengan raihan prestasi akademis dan keagamaan bergengsi.',
            'vision' => 'Mewujudkan madrasah yang unggul dalam prestasi, berakhlak mulia, dan berwawasan lingkungan.',
            'mission' => "1. Menerapkan kurikulum terintegrasi yang menantang kreativitas berpikir.\n2. Membina bakat keagamaan dan kepemimpinan siswa melalui ekskul dan kegiatan madrasah.\n3. Membudayakan peduli lingkungan bersih dan pelestarian alam.",
            'address' => 'Jl. RE. Martadinata No. 77, Tasikmalaya',
            'phone' => '+62 822-1111-2222',
            'email' => 'info@man2tasik.sch.id',
            'google_maps' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.8354890695026!2d107.61860611477292!3d-6.910103995007055!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e63a1a1f33f3%3A0x28ad42e472be3a52!2sGedung%20Sate!5e0!3m2!1sid!2sid!4v1656467000000!5m2!1sid!2sid" class="w-full h-full rounded-2xl border-0" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        ]);

        // 2. Create Users
        $superadmin = User::create([
            'name' => 'Super Admin ERP',
            'email' => 'admin@alumni.com',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'status_verifikasi' => true,
            'school_id' => null, // Superadmin controls all
        ]);

        // Admin for SMKN 1
        $adminSmkn1 = User::create([
            'name' => 'Budi (Admin SMKN 1)',
            'email' => 'admin_smkn1@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin_alumni',
            'status_verifikasi' => true,
            'school_id' => $school1->id,
        ]);

        // Admin for MAN 2
        $adminMan2 = User::create([
            'name' => 'Joko (Admin MAN 2)',
            'email' => 'admin_man2@school.com',
            'password' => Hash::make('password'),
            'role' => 'admin_alumni',
            'status_verifikasi' => true,
            'school_id' => $school2->id,
        ]);

        // Alumni SMKN 1
        $alumni1 = User::create([
            'name' => 'Rian Kurniawan',
            'email' => 'rian@alumni.com',
            'password' => Hash::make('password'),
            'role' => 'alumni',
            'angkatan' => 2015,
            'jurusan' => 'RPL',
            'tahun_lulus' => 2018,
            'domisili' => 'Surabaya',
            'pekerjaan' => 'Software Engineer',
            'bio' => 'Full-stack developer passionate about Laravel and Vue.js.',
            'kontak_whatsapp' => '6281234567890',
            'pendidikan_terakhir' => 'S1 Teknik Informatika',
            'media_sosial' => ['linkedin' => 'linkedin.com/in/rian', 'github' => 'github.com/rian'],
            'status_verifikasi' => true,
            'school_id' => $school1->id,
        ]);

        $alumni2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@alumni.com',
            'password' => Hash::make('password'),
            'role' => 'alumni',
            'angkatan' => 2018,
            'jurusan' => 'Multimedia',
            'tahun_lulus' => 2021,
            'domisili' => 'Yogyakarta',
            'pekerjaan' => 'UI/UX Designer',
            'bio' => 'Creative designer focused on clean web layout and illustrations.',
            'kontak_whatsapp' => '628987654321',
            'pendidikan_terakhir' => 'D3 Desain Komunikasi Visual',
            'media_sosial' => ['instagram' => 'instagram.com/siti'],
            'status_verifikasi' => true,
            'school_id' => $school1->id,
        ]);

        // Alumni MAN 2
        $alumni3 = User::create([
            'name' => 'Ahmad Fauzi',
            'email' => 'ahmad@alumni.com',
            'password' => Hash::make('password'),
            'role' => 'alumni',
            'angkatan' => 2020,
            'jurusan' => 'IPA',
            'tahun_lulus' => 2023,
            'domisili' => 'Semarang',
            'pekerjaan' => 'Mobile Developer',
            'bio' => 'Fresh graduate looking for new opportunities in Flutter app development.',
            'status_verifikasi' => true,
            'school_id' => $school2->id,
        ]);

        // 3. Posts (News & Articles)
        Post::create([
            'title' => 'Reuni Emas 50 Tahun SMK Negeri 1',
            'slug' => 'reuni-emas-50-tahun-smkn1',
            'content' => 'Sekolah kita akan merayakan hari jadinya yang ke-50 tahun ini. Berbagai rangkaian acara reuni akbar sedang dipersiapkan oleh panitia gabungan alumni.',
            'category' => 'sekolah',
            'image' => 'https://images.unsplash.com/photo-1511632765486-a01980e01a18?w=800',
            'user_id' => $adminSmkn1->id,
            'school_id' => $school1->id,
        ]);

        Post::create([
            'title' => 'Program Mentorship Karir Ikatan Alumni SMKN 1',
            'slug' => 'program-mentorship-karir-smkn1',
            'content' => 'Ikatan alumni resmi meluncurkan program mentorship karir bagi alumni muda dan lulusan baru.',
            'category' => 'alumni',
            'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800',
            'user_id' => $adminSmkn1->id,
            'school_id' => $school1->id,
        ]);

        Post::create([
            'title' => 'Prestasi Juara Karya Tulis Ilmiah MAN 2',
            'slug' => 'prestasi-karya-tulis-man2',
            'content' => 'Siswa-siswi MAN 2 KOTA TASIKMALAYA sukses menyabet juara pertama dalam Lomba Karya Tulis Ilmiah Nasional bidang sains terapan.',
            'category' => 'sekolah',
            'image' => 'https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?w=800',
            'user_id' => $adminMan2->id,
            'school_id' => $school2->id,
        ]);

        // 4. Events (Agenda)
        $event1 = Event::create([
            'title' => 'Reuni Lintas Angkatan SMKN 1',
            'slug' => 'reuni-lintas-angkatan-smkn1',
            'description' => 'Ajang silaturahmi akbar mempertemukan seluruh alumni SMKN 1 dari angkatan pertama hingga kelulusan terbaru.',
            'date' => now()->addDays(30)->setTime(9, 0),
            'location' => 'Aula Utama & Lapangan SMKN 1',
            'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=800',
            'school_id' => $school1->id,
        ]);

        $event2 = Event::create([
            'title' => 'Silaturahmi Akbar Alumni MAN 2',
            'slug' => 'silaturahmi-alumni-man2',
            'description' => 'Silaturahmi agung mempererat relasi bisnis dan pengabdian alumni MAN 2 KOTA TASIKMALAYA.',
            'date' => now()->addDays(40)->setTime(10, 0),
            'location' => 'Convention Hall MAN 2',
            'image' => 'https://images.unsplash.com/photo-1505232458627-539c97b588d2?w=800',
            'school_id' => $school2->id,
        ]);

        // RSVPs
        EventRsvp::create([
            'user_id' => $alumni1->id,
            'event_id' => $event1->id,
            'status' => 'hadir',
        ]);
        EventRsvp::create([
            'user_id' => $alumni3->id,
            'event_id' => $event2->id,
            'status' => 'hadir',
        ]);

        // 5. Donations
        $donasi1 = Donation::create([
            'title' => 'Donasi Fasilitas Masjid SMKN 1',
            'slug' => 'donasi-masjid-smkn1',
            'description' => 'Penggalangan dana untuk renovasi tempat ibadah di lingkungan SMKN 1 agar lebih luas dan nyaman bagi warga sekolah.',
            'target_amount' => 50000000.00,
            'raised_amount' => 15000000.00,
            'type' => 'pembangunan',
            'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=800',
            'school_id' => $school1->id,
        ]);

        $donasi2 = Donation::create([
            'title' => 'Beasiswa Peduli Alumni MAN 2',
            'slug' => 'beasiswa-peduli-man2',
            'description' => 'Bantuan beasiswa bagi putra-putri siswa MAN 2 KOTA TASIKMALAYA yang berprestasi namun menghadapi kendala ekonomi keluarga.',
            'target_amount' => 30000000.00,
            'raised_amount' => 5000000.00,
            'type' => 'beasiswa',
            'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800',
            'school_id' => $school2->id,
        ]);

        // Donation Transactions
        DonationTransaction::create([
            'donation_id' => $donasi1->id,
            'user_id' => $alumni1->id,
            'amount' => 5000000.00,
            'donor_name' => $alumni1->name,
            'status' => 'completed',
            'payment_method' => 'transfer_bank',
            'message' => 'Semoga berkah untuk pembangunan masjid almamater SMKN 1.',
        ]);

        DonationTransaction::create([
            'donation_id' => $donasi2->id,
            'user_id' => $alumni3->id,
            'amount' => 2000000.00,
            'donor_name' => $alumni3->name,
            'status' => 'completed',
            'payment_method' => 'transfer_bank',
            'message' => 'Semoga membantu adik-adik berprestasi di MAN 2 KOTA TASIKMALAYA.',
        ]);

        // 6. Careers
        $career1 = Career::create([
            'title' => 'Junior Web Developer',
            'company' => 'PT Graha Digital Nusantara',
            'description' => 'Dibutuhkan segera Web Developer junior menguasai PHP, Laravel, HTML/CSS. Terbuka bagi lulusan baru.',
            'type' => 'fulltime',
            'location' => 'Jakarta Barat',
            'contact' => 'hrd@grahadigital.co.id',
            'user_id' => $alumni1->id,
            'school_id' => $school1->id,
        ]);

        Career::create([
            'title' => 'Creative Copywriter',
            'company' => 'Sinar Merdeka Agency',
            'description' => 'Mampu membuat naskah promosi kreatif untuk sosial media. Mahir berbahasa Indonesia dan Inggris.',
            'type' => 'fulltime',
            'location' => 'Bandung Kota',
            'contact' => 'career@sinarmerdeka.id',
            'user_id' => $alumni3->id,
            'school_id' => $school2->id,
        ]);

        // 7. Businesses
        Business::create([
            'name' => 'Warkop Tech & Co-Working',
            'category' => 'Kuliner & Jasa',
            'description' => 'Tempat nongkrong asyik dilengkapi Wi-Fi super cepat, kopi nusantara berkualitas, dan ruang meeting mini.',
            'product_image' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800',
            'contact' => '0812-4455-6677',
            'user_id' => $alumni2->id,
            'school_id' => $school1->id,
        ]);

        Business::create([
            'name' => 'Griya Sehat Herbal',
            'category' => 'Kesehatan',
            'description' => 'Menyediakan berbagai macam jamu herbal premium alami berkualitas tinggi tanpa bahan pengawet.',
            'product_image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?w=800',
            'contact' => '0877-9988-7766',
            'user_id' => $alumni3->id,
            'school_id' => $school2->id,
        ]);

        // 8. Forum Topics
        $topic1 = ForumTopic::create([
            'title' => 'Rekomendasi Kursus IT Laravel Terbaik untuk Lulusan Vokasi',
            'content' => 'Halo rekan-rekan alumni SMKN 1, ada rekomendasi tempat belajar Laravel yang memiliki kurikulum setara industri saat ini?',
            'user_id' => $alumni1->id,
            'school_id' => $school1->id,
        ]);

        $topic2 = ForumTopic::create([
            'title' => 'Info Reuni Akbar Lintas Angkatan MAN 2',
            'content' => 'Apakah panitia reuni akbar MAN 2 KOTA TASIKMALAYA sudah merilis daftar sponsor dan kontributor acara?',
            'user_id' => $alumni3->id,
            'school_id' => $school2->id,
        ]);

        // Forum Replies
        ForumReply::create([
            'content' => 'Bisa coba kursus online di Laracasts atau kanal YouTube resmi Laravel. Kurikulumnya sangat lengkap dari tingkat dasar hingga mahir.',
            'forum_topic_id' => $topic1->id,
            'user_id' => $alumni2->id,
        ]);

        ForumReply::create([
            'content' => 'Sudah diposting di menu Agenda MAN 2 KOTA TASIKMALAYA mas, silakan langsung dicek detail acaranya.',
            'forum_topic_id' => $topic2->id,
            'user_id' => $alumni3->id,
        ]);

        // 9. Galleries
        Gallery::create([
            'title' => 'Pemberian Donasi Buku Perpustakaan oleh Alumni SMKN 1',
            'type' => 'foto',
            'url' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=800',
            'category' => 'sosial',
            'school_id' => $school1->id,
        ]);

        Gallery::create([
            'title' => 'Seminar Tech Talk Bersama Alumni IT SMKN 1',
            'type' => 'foto',
            'url' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800',
            'category' => 'seminar',
            'school_id' => $school1->id,
        ]);

        Gallery::create([
            'title' => 'Piala Juara Umum Lomba Sains Nasional MAN 2',
            'type' => 'foto',
            'url' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=800',
            'category' => 'sekolah',
            'school_id' => $school2->id,
        ]);

        $this->call(SchoolSeeder::class);
    }
}
