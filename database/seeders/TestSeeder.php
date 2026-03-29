<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Page;
use App\Models\Teacher;
use App\Models\Album;
use App\Models\Gallery;
use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\GuestBook;
use App\Models\User;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Seeding test data...');

        // Get admin user for posts
        $adminUser = User::role('super-admin')->first();

        // 1. Settings
        $this->command->info('📌 Seeding Settings...');
        $settings = [
            // General Settings
            ['key' => 'site_name', 'value' => 'SMAN 1 Kepanjen', 'type' => 'text'],
            ['key' => 'site_tagline', 'value' => 'Unggul dalam Prestasi, Luhur dalam Budi Pekerti', 'type' => 'text'],
            
            // Contact Settings
            ['key' => 'contact_address', 'value' => 'Jl. Raya Kepanjen No. 123, Kabupaten Malang, Jawa Timur', 'type' => 'textarea'],
            ['key' => 'contact_phone', 'value' => '(0341) 123456', 'type' => 'text'],
            ['key' => 'contact_whatsapp', 'value' => '0812-3456-7890', 'type' => 'text'],
            ['key' => 'contact_email', 'value' => 'info@sman1kepanjen.sch.id', 'type' => 'email'],
            ['key' => 'website', 'value' => 'https://sman1kepanjen.sch.id', 'type' => 'url'],
            
            // Social Media Settings
            ['key' => 'social_facebook', 'value' => 'https://facebook.com/sman1kepanjen', 'type' => 'url'],
            ['key' => 'social_instagram', 'value' => 'https://instagram.com/sman1kepanjen', 'type' => 'url'],
            ['key' => 'social_youtube', 'value' => 'https://youtube.com/sman1kepanjen', 'type' => 'url'],
            ['key' => 'social_tiktok', 'value' => 'https://tiktok.com/sman1kepanjen', 'type' => 'url'],
            
            // Images
            ['key' => 'logo', 'value' => '', 'type' => 'image'],
            ['key' => 'header_image', 'value' => '', 'type' => 'image'],
            ['key' => 'who_we_are_image', 'value' => '', 'type' => 'image'],
            ['key' => 'favicon', 'value' => '', 'type' => 'image'],

            // Who We Are Settings
            ['key' => 'who_we_are_title', 'value' => 'Who We Are', 'type' => 'text'],
            ['key' => 'who_we_are_desc', 'value' => 'Membentuk Masa Depan Melalui Ilmu Pengetahuan & Penemuan', 'type' => 'text'],
            ['key' => 'who_we_are_paragraph', 'value' => 'SMANeka berkomitmen untuk menciptakan lingkungan pembelajaran yang inspiratif dan inovatif, di mana setiap siswa dapat mengembangkan potensi akademik dan karakter mereka secara optimal.', 'type' => 'textarea'],
            ['key' => 'who_we_are_mission_title', 'value' => 'Our Mission', 'type' => 'text'],
            ['key' => 'who_we_are_mission', 'value' => 'Menyelenggarakan pendidikan berkualitas dengan standar nasional dan internasional, mengembangkan potensi akademik dan non-akademik siswa secara optimal, serta menanamkan nilai-nilai karakter dan budi pekerti luhur.', 'type' => 'textarea'],
            ['key' => 'who_we_are_vision_title', 'value' => 'Our Vision', 'type' => 'text'],
            ['key' => 'who_we_are_vision', 'value' => 'Menjadi sekolah unggulan yang menghasilkan generasi cerdas, berkarakter, dan berdaya saing global berlandaskan iman dan taqwa.', 'type' => 'textarea'],

            // Hero Settings
            ['key' => 'hero_title', 'value' => 'Sekolah Unggulan Berprestasi', 'type' => 'text'],
            ['key' => 'hero_subtitle', 'value' => 'Mewujudkan Generasi Cerdas, Berkarakter, dan Berdaya Saing Global', 'type' => 'textarea'],
            ['key' => 'hero_button_text', 'value' => 'Daftar Sekarang', 'type' => 'text'],
            ['key' => 'hero_button_url', 'value' => '/admin', 'type' => 'url'],
            
            // Stats Settings
            ['key' => 'stat_1_label', 'value' => 'Kelulusan PTN', 'type' => 'text'],
            ['key' => 'stat_1_value', 'value' => '98%', 'type' => 'text'],
            ['key' => 'stat_2_label', 'value' => 'Prestasi/Tahun', 'type' => 'text'],
            ['key' => 'stat_2_value', 'value' => '50+', 'type' => 'text'],
            ['key' => 'stat_3_label', 'value' => 'Guru Bersertifikasi', 'type' => 'text'],
            ['key' => 'stat_3_value', 'value' => '100%', 'type' => 'text'],
            
            // Feature Cards Settings
            ['key' => 'feature_1_title', 'value' => 'Kurikulum Inovatif', 'type' => 'text'],
            ['key' => 'feature_1_desc', 'value' => 'Pembelajaran modern yang mengintegrasikan teknologi dan pendekatan student-centered untuk hasil optimal.', 'type' => 'textarea'],
            ['key' => 'feature_2_title', 'value' => 'Fasilitas Modern', 'type' => 'text'],
            ['key' => 'feature_2_desc', 'value' => 'Laboratorium komputer, IPA, dan fasilitas pembelajaran lengkap dengan teknologi terkini.', 'type' => 'textarea'],
            ['key' => 'feature_3_title', 'value' => 'Guru Berkualitas', 'type' => 'text'],
            ['key' => 'feature_3_desc', 'value' => 'Tenaga pendidik profesional dan berpengalaman yang siap membimbing setiap siswa meraih potensi terbaik.', 'type' => 'textarea'],
        ];
        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }

        // 2. Menus
        $this->command->info('📌 Seeding Menus...');
        $menus = [
            ['name' => 'Beranda', 'url' => '/', 'order' => 1, 'parent_id' => null, 'is_active' => true],
            ['name' => 'Profil', 'url' => '#', 'order' => 2, 'parent_id' => null, 'is_active' => true],
            ['name' => 'Sejarah', 'url' => '/profil/sejarah', 'order' => 1, 'parent_id' => 2, 'is_active' => true],
            ['name' => 'Visi Misi', 'url' => '/profil/visi-misi', 'order' => 2, 'parent_id' => 2, 'is_active' => true],
            ['name' => 'Guru & Staff', 'url' => '/guru', 'order' => 3, 'parent_id' => null, 'is_active' => true],
            ['name' => 'Berita', 'url' => '/berita', 'order' => 4, 'parent_id' => null, 'is_active' => true],
            ['name' => 'Prestasi', 'url' => '/prestasi', 'order' => 5, 'parent_id' => null, 'is_active' => true],
            ['name' => 'Ekstrakurikuler', 'url' => '/ekstrakurikuler', 'order' => 6, 'parent_id' => null, 'is_active' => true],
            ['name' => 'Galeri', 'url' => '/galeri', 'order' => 7, 'parent_id' => null, 'is_active' => true],
            ['name' => 'Kontak', 'url' => '/kontak', 'order' => 8, 'parent_id' => null, 'is_active' => true],
        ];
        foreach ($menus as $menu) {
            Menu::create($menu);
        }

        // 3. Categories
        $this->command->info('📌 Seeding Categories...');
        $categories = [
            ['name' => 'Berita Sekolah', 'slug' => 'berita-sekolah', 'description' => 'Berita terkini seputar kegiatan sekolah'],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Prestasi siswa dan guru'],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'description' => 'Kegiatan siswa dan pembelajaran'],
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman resmi dari sekolah'],
            ['name' => 'Akademik', 'slug' => 'akademik', 'description' => 'Informasi akademik dan kurikulum'],
        ];
        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }

        // 4. Tags
        $this->command->info('📌 Seeding Tags...');
        $tags = [
            ['name' => 'OSIS', 'slug' => 'osis'],
            ['name' => 'Pramuka', 'slug' => 'pramuka'],
            ['name' => 'Olahraga', 'slug' => 'olahraga'],
            ['name' => 'Seni', 'slug' => 'seni'],
            ['name' => 'Ilmiah', 'slug' => 'ilmiah'],
            ['name' => 'Keagamaan', 'slug' => 'keagamaan'],
            ['name' => 'Ujian', 'slug' => 'ujian'],
            ['name' => 'PPDB', 'slug' => 'ppdb'],
        ];
        foreach ($tags as $tag) {
            Tag::firstOrCreate(['slug' => $tag['slug']], $tag);
        }

        // 5. Pages
        $this->command->info('📌 Seeding Pages...');
        $pages = [
            [
                'title' => 'Sejarah Sekolah',
                'slug' => 'sejarah',
                'content' => '<p>SMAN 1 Kepanjen didirikan pada tahun 1985 dan telah menjadi salah satu sekolah menengah atas terbaik di Kabupaten Malang. Dengan pengalaman lebih dari 35 tahun, kami berkomitmen untuk memberikan pendidikan berkualitas tinggi.</p><p>Seiring berjalannya waktu, SMAN 1 Kepanjen terus berkembang dan berinovasi dalam metode pembelajaran untuk mempersiapkan generasi muda yang unggul dalam prestasi dan luhur dalam budi pekerti.</p>',
                'is_active' => true,
            ],
            [
                'title' => 'Visi dan Misi',
                'slug' => 'visi-misi',
                'content' => '<h2>Visi</h2><p>Menjadi sekolah menengah atas yang unggul dalam prestasi akademik dan non-akademik, serta berakhlak mulia berdasarkan iman dan taqwa.</p><h2>Misi</h2><ul><li>Menyelenggarakan pendidikan berkualitas dengan kurikulum yang relevan</li><li>Mengembangkan potensi siswa secara optimal</li><li>Menumbuhkan semangat kompetitif yang sehat</li><li>Menanamkan nilai-nilai karakter dan budi pekerti luhur</li><li>Menciptakan lingkungan sekolah yang kondusif dan inovatif</li></ul>',
                'is_active' => true,
            ],
            [
                'title' => 'Sambutan Kepala Sekolah',
                'slug' => 'sambutan-kepala-sekolah',
                'content' => '<p>Assalamualaikum Warahmatullahi Wabarakatuh</p><p>Selamat datang di website resmi SMAN 1 Kepanjen. Website ini hadir sebagai media informasi dan komunikasi antara sekolah dengan siswa, orang tua, dan masyarakat.</p><p>Kami berharap website ini dapat memberikan manfaat dan informasi yang dibutuhkan bagi semua pihak yang tertarik dengan perkembangan pendidikan di SMAN 1 Kepanjen.</p><p>Wassalamualaikum Warahmatullahi Wabarakatuh</p>',
                'is_active' => true,
            ],
        ];
        foreach ($pages as $page) {
            Page::firstOrCreate(['slug' => $page['slug']], $page);
        }

        // 6. Teachers
        $this->command->info('📌 Seeding Teachers...');
        $teachers = [
            ['name' => 'Drs. Ahmad Hidayat, M.Pd', 'position' => 'Kepala Sekolah', 'subject' => 'Manajemen Pendidikan', 'bio' => 'Berpengalaman lebih dari 20 tahun dalam dunia pendidikan'],
            ['name' => 'Dra. Siti Aminah, M.Pd', 'position' => 'Waka Kurikulum', 'subject' => 'Matematika', 'bio' => 'Lulusan S2 Pendidikan Matematika UGM'],
            ['name' => 'Budi Santoso, S.Pd', 'position' => 'Waka Kesiswaan', 'subject' => 'Bahasa Indonesia', 'bio' => 'Aktif dalam pembinaan OSIS dan ekstrakurikuler'],
            ['name' => 'Rina Wijayanti, S.Pd', 'position' => 'Waka Sarpras', 'subject' => 'Fisika', 'bio' => 'Fokus pada pengembangan sarana pembelajaran'],
            ['name' => 'Mohammad Yusuf, S.Pd', 'position' => 'Guru Bahasa Inggris', 'subject' => 'Bahasa Inggris', 'bio' => 'Lulusan Sastra Inggris Universitas Brawijaya'],
            ['name' => 'Dewi Lestari, S.Pd', 'position' => 'Guru Biologi', 'subject' => 'Biologi', 'bio' => 'Spesialis dalam bidang biologi molekuler'],
            ['name' => 'Andi Pratama, S.Pd', 'position' => 'Guru Olahraga', 'subject' => 'Pendidikan Jasmani', 'bio' => 'Pelatih tim basket sekolah'],
            ['name' => 'Nurul Hidayah, S.Pd', 'position' => 'Guru Agama Islam', 'subject' => 'Pendidikan Agama Islam', 'bio' => 'Aktif dalam kegiatan keagamaan sekolah'],
            ['name' => 'Joko Susilo, S.Pd', 'position' => 'Guru Sejarah', 'subject' => 'Sejarah Indonesia', 'bio' => 'Peneliti sejarah lokal Malang'],
            ['name' => 'Fitri Handayani, S.Pd', 'position' => 'Guru Kimia', 'subject' => 'Kimia', 'bio' => 'Lulusan S2 Kimia ITB'],
        ];
        foreach ($teachers as $teacher) {
            Teacher::firstOrCreate(['name' => $teacher['name']], $teacher);
        }

        // 7. Posts
        $this->command->info('📌 Seeding Posts...');
        $posts = [
            [
                'title' => 'SMAN 1 Kepanjen Raih Juara 1 Olimpiade Matematika Tingkat Provinsi',
                'slug' => 'sman-1-kepanjen-raih-juara-1-olimpiade-matematika',
                'content' => '<p>Siswa SMAN 1 Kepanjen kembali menorehkan prestasi gemilang. Dalam Olimpiade Matematika Tingkat Provinsi Jawa Timur yang dilaksanakan pada tanggal 10 Maret 2024, siswa kami berhasil meraih Juara 1.</p><p>Prestasi ini merupakan hasil dari kerja keras dan bimbingan intensif dari para guru pembimbing. Kami berharap prestasi ini dapat memotivasi siswa lainnya untuk terus berprestasi.</p>',
                'category_id' => 1,
                'user_id' => $adminUser->id,
                'status' => 'published',
                'published_at' => now(),
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2024/2025',
                'slug' => 'ppdb-tahun-ajaran-2024-2025',
                'content' => '<p>SMAN 1 Kepanjen membuka pendaftaran peserta didik baru untuk tahun ajaran 2024/2025. Pendaftaran dapat dilakukan secara online melalui website resmi sekolah.</p><p>Adapun kuota yang tersedia adalah 360 siswa yang terbagi dalam 12 kelas. Untuk informasi lebih lanjut, silakan hubungi panitia PPDB.</p>',
                'category_id' => 4,
                'user_id' => $adminUser->id,
                'status' => 'published',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Kegiatan Pramuka Wajib bagi Kelas X',
                'slug' => 'kegiatan-pramuka-wajib-kelas-x',
                'content' => '<p>Sesuai dengan program sekolah, kegiatan Pramuka merupakan kegiatan wajib bagi semua siswa kelas X. Kegiatan ini bertujuan untuk membentuk karakter dan jiwa kepemimpinan siswa.</p><p>Kegiatan dilaksanakan setiap hari Sabtu pukul 07.00 - 12.00 WIB di lapangan sekolah.</p>',
                'category_id' => 3,
                'user_id' => $adminUser->id,
                'status' => 'published',
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'Jadwal Ujian Tengah Semester Genap 2024',
                'slug' => 'jadwal-uts-genap-2024',
                'content' => '<p>Ujian Tengah Semester (UTS) Genap akan dilaksanakan pada tanggal 20-27 Maret 2024. Siswa diharapkan mempersiapkan diri dengan baik.</p><p>Jadwal lengkap dapat diunduh melalui menu akademik atau menghubungi wali kelas masing-masing.</p>',
                'category_id' => 5,
                'user_id' => $adminUser->id,
                'status' => 'published',
                'published_at' => now()->subDays(15),
            ],
            [
                'title' => 'Kunjungan Studi Banding dari SMAN 2 Malang',
                'slug' => 'kunjungan-studi-banding-sman-2-malang',
                'content' => '<p>SMAN 1 Kepanjen menerima kunjungan studi banding dari SMAN 2 Malang pada tanggal 5 Maret 2024. Kunjungan ini bertujuan untuk berbagi pengalaman dalam pengelolaan sekolah dan peningkatan mutu pendidikan.</p>',
                'category_id' => 1,
                'user_id' => $adminUser->id,
                'status' => 'published',
                'published_at' => now()->subDays(20),
            ],
        ];
        foreach ($posts as $postData) {
            $post = Post::firstOrCreate(['slug' => $postData['slug']], $postData);
            // Attach tags
            $post->tags()->sync([1, 2]);
        }

        // 8. Extracurriculars
        $this->command->info('📌 Seeding Extracurriculars...');
        $extracurriculars = [
            ['name' => 'Pramuka', 'description' => 'Pramuka Wajib untuk kelas X, melatih kedisiplinan dan kepemimpinan', 'image' => ''],
            ['name' => 'OSIS', 'description' => 'Organisasi Siswa Intra Sekolah, wadah pengembangan kepemimpinan siswa', 'image' => ''],
            ['name' => 'Basket', 'description' => 'Ekstrakurikuler basket untuk mengembangkan bakat olahraga', 'image' => ''],
            ['name' => 'Futsal', 'description' => 'Tim futsal sekolah untuk kompetisi antar sekolah', 'image' => ''],
            ['name' => 'Paduan Suara', 'description' => 'Mengembangkan bakat seni musik vokal', 'image' => ''],
            ['name' => 'Teater', 'description' => 'Ekstrakurikuler seni peran dan drama', 'image' => ''],
            ['name' => 'KIR (Karya Ilmiah Remaja)', 'description' => 'Wadah pengembangan penelitian ilmiah siswa', 'image' => ''],
            ['name' => 'Rohis', 'description' => 'Rohani Islam, pembinaan keagamaan Islam', 'image' => ''],
            ['name' => 'PMR', 'description' => 'Palang Merah Remaja, pelatihan pertolongan pertama', 'image' => ''],
            ['name' => 'English Club', 'description' => 'Klub bahasa Inggris untuk meningkatkan kemampuan berbahasa', 'image' => ''],
            ['name' => 'Jurnalistik', 'description' => 'Pelatihan jurnalistik dan pengelolaan media sekolah', 'image' => ''],
            ['name' => 'Fotografi', 'description' => 'Ekstrakurikuler fotografi untuk mengembangkan hobby fotografi', 'image' => ''],
        ];
        foreach ($extracurriculars as $ekskul) {
            Extracurricular::firstOrCreate(['name' => $ekskul['name']], $ekskul);
        }

        // 9. Achievements
        $this->command->info('📌 Seeding Achievements...');
        $achievements = [
            ['title' => 'Juara 1 Olimpiade Matematika Tingkat Provinsi', 'description' => 'Diraih oleh Ahmad Rizki dari kelas XI MIPA 1', 'year' => 2024, 'image' => ''],
            ['title' => 'Juara 2 Lomba Debat Bahasa Inggris Tingkat Nasional', 'description' => 'Diraih oleh tim debat SMAN 1 Kepanjen', 'year' => 2024, 'image' => ''],
            ['title' => 'Juara 1 Lomba Karya Ilmiah Remaja Tingkat Kabupaten', 'description' => 'Penelitian tentang pemanfaatan limbah plastik', 'year' => 2023, 'image' => ''],
            ['title' => 'Juara 3 Festival Band Pelajar Tingkat Provinsi', 'description' => 'Diraih oleh band sekolah "Gema Remaja"', 'year' => 2023, 'image' => ''],
            ['title' => 'Juara 1 Futsal Cup Antar SMA Se-Kabupaten Malang', 'description' => 'Tim futsal SMAN 1 Kepanjen', 'year' => 2023, 'image' => ''],
            ['title' => 'Juara 2 Lomba Cerdas Cermat IPA Tingkat Provinsi', 'description' => 'Diraih oleh tim IPA kelas X', 'year' => 2023, 'image' => ''],
        ];
        foreach ($achievements as $achievement) {
            Achievement::firstOrCreate(['title' => $achievement['title'], 'year' => $achievement['year']], $achievement);
        }

        // 10. Albums & Galleries
        $this->command->info('📌 Seeding Albums & Galleries...');
        $albums = [
            ['name' => 'Kegiatan MPLS 2024', 'description' => 'Masa Pengenalan Lingkungan Sekolah tahun 2024', 'thumbnail' => ''],
            ['name' => 'Upacara Bendera', 'description' => 'Kegiatan upacara bendera setiap hari Senin', 'thumbnail' => ''],
            ['name' => 'Pentas Seni 2023', 'description' => 'Pentas Seni tahunan SMAN 1 Kepanjen', 'thumbnail' => ''],
            ['name' => 'Classmeeting', 'description' => 'Kegiatan classmeeting antar kelas', 'thumbnail' => ''],
            ['name' => 'Wisuda Angkatan 2023', 'description' => 'Wisuda siswa kelas XII angkatan 2023', 'thumbnail' => ''],
        ];
        foreach ($albums as $albumData) {
            $album = Album::firstOrCreate(['name' => $albumData['name']], $albumData);
            // Add some sample galleries
            Gallery::create([
                'album_id' => $album->id,
                'image_path' => '',
                'caption' => 'Dokumentasi kegiatan ' . $albumData['name'],
            ]);
        }

        // 11. Guest Books
        $this->command->info('📌 Seeding Guest Books...');
        $guestBooks = [
            ['day_date' => now()->subDays(1), 'name' => 'John Doe', 'position' => 'Orang Tua Siswa', 'address' => 'Jl. Raya Kepanjen No. 1', 'purpose' => 'Silaturahmi dan konsultasi perkembangan siswa'],
            ['day_date' => now()->subDays(3), 'name' => 'Dr. Siti Maryam', 'position' => 'Dosen Universitas Brawijaya', 'address' => 'Malang', 'purpose' => 'Kerjasama penelitian dengan sekolah'],
            ['day_date' => now()->subDays(5), 'name' => 'Bapak Kapolsek Kepanjen', 'position' => 'Kepala Polsek Kepanjen', 'address' => 'Kepanjen', 'purpose' => 'Sosialisasi kenakalan remaja'],
            ['day_date' => now()->subDays(7), 'name' => 'Tim Akreditasi', 'position' => 'Badan Akreditasi Nasional', 'address' => 'Surabaya', 'purpose' => 'Visitasi akreditasi sekolah'],
            ['day_date' => now()->subDays(10), 'name' => 'Representative SMAN 2 Malang', 'position' => 'Guru', 'address' => 'Malang', 'purpose' => 'Studi banding'],
        ];
        foreach ($guestBooks as $guestBook) {
            GuestBook::create($guestBook);
        }

        $this->command->info('✅ Test data seeding completed!');
        $this->command->info('');
        $this->command->info('📊 Summary:');
        $this->command->info('  - Settings: ' . Setting::count() . ' items');
        $this->command->info('  - Menus: ' . Menu::count() . ' items');
        $this->command->info('  - Categories: ' . Category::count() . ' items');
        $this->command->info('  - Tags: ' . Tag::count() . ' items');
        $this->command->info('  - Posts: ' . Post::count() . ' items');
        $this->command->info('  - Pages: ' . Page::count() . ' items');
        $this->command->info('  - Teachers: ' . Teacher::count() . ' items');
        $this->command->info('  - Extracurriculars: ' . Extracurricular::count() . ' items');
        $this->command->info('  - Achievements: ' . Achievement::count() . ' items');
        $this->command->info('  - Albums: ' . Album::count() . ' items');
        $this->command->info('  - Galleries: ' . Gallery::count() . ' items');
        $this->command->info('  - Guest Books: ' . GuestBook::count() . ' items');
    }
}
