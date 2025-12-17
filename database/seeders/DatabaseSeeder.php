<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\SubRole;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $password = Hash::make('password');

        $this->command->info('Memulai Seeding Database Manual (Tanpa Random)...');

        // ==========================================
        // PHASE 1: MASTER DATA
        // ==========================================

        // 1. Organizations
        DB::table('student_organizations')->insert([
            ['student_organization_id' => 1, 'organization_name' => 'Himpunan Mahasiswa Informatika'],
            ['student_organization_id' => 2, 'organization_name' => 'Badan Eksekutif Mahasiswa (BEM)'],
            ['student_organization_id' => 3, 'organization_name' => 'Unit Kegiatan Olahraga'],
            ['student_organization_id' => 4, 'organization_name' => 'UKM Seni & Musik'],
        ]);

        // 2. Departments
        DB::table('academic_departments')->insert([
            ['department_id' => 1, 'department_name' => 'Informatika'],
            ['department_id' => 2, 'department_name' => 'DKV'],
            ['department_id' => 3, 'department_name' => 'Sistem Informasi'],
            ['department_id' => 4, 'department_name' => 'Teknik Sipil'],
        ]);

        // 3. Roles
        DB::table('student_roles')->insert([
            ['student_role_id' => 1, 'role_code' => 'LEAD', 'role_name' => 'Ketua'],      
            ['student_role_id' => 2, 'role_code' => 'NOTE', 'role_name' => 'Sekretaris'], 
            ['student_role_id' => 3, 'role_code' => 'MEBR', 'role_name' => 'Anggota'],      
            ['student_role_id' => 4, 'role_code' => 'COOR', 'role_name' => 'Koordinator'], 
        ]);

        // 4. Master Sub Roles (Divisi)
        $masterSubRoles = [
            ['code' => 'SR01', 'name' => 'BPH', 'en' => 'Main Board'],
            ['code' => 'SR02', 'name' => 'Divisi Acara', 'en' => 'Event'],
            ['code' => 'SR03', 'name' => 'Divisi Media', 'en' => 'Media'],
            ['code' => 'SR04', 'name' => 'Divisi Logistik', 'en' => 'Logistics'],
            ['code' => 'SR05', 'name' => 'Divisi Humas', 'en' => 'Public Relations'],
            ['code' => 'SR06', 'name' => 'Divisi Konsumsi', 'en' => 'Consumption'],
            ['code' => 'SR07', 'name' => 'Divisi Keamanan', 'en' => 'Security'],
            ['code' => 'SR08', 'name' => 'Divisi Sponsorship', 'en' => 'Sponsorship'],
            ['code' => 'SR09', 'name' => 'Divisi Dekdok', 'en' => 'Decoration & Doc'],
            ['code' => 'SR10', 'name' => 'Divisi Medis', 'en' => 'Medical'],
        ];

        foreach ($masterSubRoles as $role) {
            SubRole::firstOrCreate(
                ['sub_role_code' => $role['code']],
                [
                    'sub_role_name' => $role['name'],
                    'sub_role_name_en' => $role['en'],
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            );
        }
        $bphId = SubRole::where('sub_role_code', 'SR01')->value('sub_role_id');


        // ==========================================
        // PHASE 2: USERS (50 Students, 20 Lecturers)
        // ==========================================

        // --- Data Mahasiswa (50 Nama Manual) ---
        $studentNames = [
            "Andi Saputra", "Budi Santoso", "Citra Lestari", "Dewi Sartika", "Eko Kurniawan", 
            "Fajar Nugraha", "Gita Pertiwi", "Hendra Wijaya", "Indah Sari", "Joko Anwar", 
            "Kartika Putri", "Lukman Hakim", "Maya Angelina", "Nanda Pratama", "Oki Setiana", 
            "Putri Ayu", "Qori Sandioriva", "Rina Nose", "Sandi Uno", "Taufik Hidayat", 
            "Utami Dewi", "Vina Panduwinata", "Wahyu Hidayat", "Xena Warrior", "Yuni Shara", 
            "Zainal Abidin", "Adit Sopo", "Jarwo Kuat", "Sule Prikitiw", "Andre Taulany", 
            "Nunung Srimulat", "Parto Patrio", "Azis Gagap", "Raffi Ahmad", "Nagita Slavina", 
            "Atta Halilintar", "Aurel Hermansyah", "Rizky Billar", "Lesti Kejora", "Deddy Corbuzier", 
            "Ivan Gunawan", "Ruben Onsu", "Sarwendah Tan", "Betrand Peto", "Thalia Onsu", 
            "Thania Onsu", "Rafathar Malik", "Rayyanza Malik", "Gempi Nora", "Arsy Hermansyah"
        ];

        for ($i = 0; $i < 50; $i++) {
            $id = $i + 1;
            $nrp = '24100' . str_pad($id, 4, '0', STR_PAD_LEFT);
            $name = $studentNames[$i];
            
            DB::table('students')->insert([
                'student_id' => $id,
                'student_number' => $nrp,
                'full_name' => $name,
                'points_balance' => 100, // Nilai default statis
                'class_group' => ($i % 2 == 0) ? 'A' : 'B', // Bergantian A dan B
                'department_id' => ($i % 4) + 1, // Bergantian 1-4
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('users')->insert([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '', $name)) . '@student.com',
                'password' => $password,
                'student_number' => $nrp,
                'lecturer_code' => null,
                'role' => 'student',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // --- Data Dosen (20 Nama Manual) ---
        $lecturerNames = [
            "Prof. Dr. Budiman, M.Kom", "Dr. Siti Aminah, S.T., M.T.", "Ir. Joko Susilo, M.Sc", "Dr. Rahmat Hidayat, Ph.D", "Prof. Endang Suhartini", 
            "Dr. Asep Saepudin", "Dr. Budi Darmawan", "Ir. Ratna Sari", "Dr. Hendra Gunawan", "Prof. Agus Salim", 
            "Dr. Dewi Kartika", "Dr. Bambang Setyoso", "Ir. Cahya Purnama", "Dr. Dedi Mulyadi", "Prof. Eka Prasetya", 
            "Dr. Feri Irawan", "Dr. Galih Ginanjar", "Ir. Hadi Sutrisno", "Dr. Indah Permatasari", "Prof. Johan Sebastian"
        ];

        for ($i = 0; $i < 20; $i++) {
            $id = $i + 1;
            $code = 'L' . str_pad($id, 3, '0', STR_PAD_LEFT);
            $name = $lecturerNames[$i];
            
            DB::table('lecturers')->insert([
                'lecturer_id' => $id,
                'lecturer_code' => $code,
                'lecturer_name' => $name,
                'employee_nip' => 'NIP' . (199000 + $i),
                'nidn' => 'NIDN' . (202000 + $i),
                'employment_status' => 'active',
                'start_date' => '2015-01-01',
                'end_date' => '2040-12-31',
                'is_certified' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            DB::table('users')->insert([
                'name' => $name,
                'email' => strtolower($code) . '@staff.com',
                'password' => $password,
                'student_number' => null,
                'lecturer_code' => $code,
                'role' => ($i == 0) ? 'admin' : 'lecturer', // Dosen pertama jadi admin
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }


        // ==========================================
        // PHASE 3 & 4: ACTIVITIES & STRUCTURES & RECRUITMENT
        // ==========================================

        // Bank Soal Manual
        $generalQ = ["Apa motivasi terbesar kamu mendaftar di acara ini?", "Bagaimana cara kamu membagi waktu dengan kuliah?", "Apakah bersedia berkontribusi dana jika diperlukan?"];
        $specificQ = [
            'SR01' => "Apakah kamu teliti dalam mengelola administrasi?",
            'SR02' => "Sebutkan satu ide kreatif untuk konsep acara ini!",
            'SR03' => "Aplikasi desain/editing apa yang kamu kuasai?",
            'SR04' => "Apakah kamu memiliki kendaraan pribadi untuk operasional?"
        ];

        // Daftar 40 Nama Acara Manual (30 Awal + 10 Baru Finished)
        $events = [
            ["Seminar Nasional AI", "Seminar membahas masa depan Artificial Intelligence.", 1],
            ["Workshop Web Development", "Pelatihan membuat website untuk pemula.", 1],
            ["Lomba Coding Competitive", "Kompetisi algoritma tingkat mahasiswa.", 1],
            ["Malam Keakraban Informatika", "Acara makrab untuk mahasiswa baru.", 1],
            ["Futsal Cup 2025", "Turnamen futsal antar jurusan.", 3],
            ["Basket League", "Liga basket tahunan kampus.", 3],
            ["Pameran Seni Rupa", "Pameran karya mahasiswa DKV.", 4],
            ["Konser Musik Kampus", "Konser amal dengan bintang tamu lokal.", 4],
            ["Bakti Sosial Desa Binaan", "Pengabdian masyarakat di desa terpencil.", 2],
            ["Donor Darah Rutin", "Kegiatan sosial donor darah.", 2],
            ["Pelatihan Desain Grafis", "Tutorial Adobe Illustrator dan Photoshop.", 1],
            ["Seminar Entrepreneurship", "Membangun mindset wirausaha muda.", 2],
            ["Study Excursion ke Bali", "Kunjungan industri ke perusahaan IT.", 1],
            ["Hackathon 24 Jam", "Lomba membuat aplikasi dalam 24 jam.", 1],
            ["Lomba Mobile Legends", "Turnamen E-Sport MLBB.", 1],
            ["PUBG Mobile Tournament", "Turnamen E-Sport Battle Royale.", 1],
            ["Webinar Cyber Security", "Keamanan data di era digital.", 1],
            ["Pelatihan Public Speaking", "Meningkatkan kemampuan bicara di depan umum.", 2],
            ["Kampanye Go Green", "Aksi tanam pohon dan kebersihan kampus.", 2],
            ["Festival Kuliner Nusantara", "Bazaar makanan tradisional.", 2],
            ["Lomba Fotografi", "Tema: Keindahan Kampus.", 4],
            ["Pameran Robotika", "Demo robot karya mahasiswa.", 1],
            ["Seminar Big Data", "Analisis data untuk bisnis.", 1],
            ["Workshop UI/UX Design", "Membuat desain aplikasi yang user-friendly.", 2],
            ["Lomba Catur Antar Jurusan", "Asah otak strategi catur.", 3],
            ["Badminton Open", "Kejuaraan bulutangkis ganda putra.", 3],
            ["Tenis Meja Championship", "Lomba pingpong perorangan.", 3],
            ["Tari Tradisional Show", "Pagelaran seni tari daerah.", 4],
            ["Teater Kampus: Romeo Juliet", "Pentas drama klasik.", 4],
            ["Wisuda Akbar Periode I", "Panitia pendukung acara wisuda.", 2],
            ["Seminar Teknologi Blockchain", "Membahas implementasi blockchain di industri.", 1],
            ["Lomba Video Kreatif", "Kompetisi videografi tema pendidikan.", 4],
            ["Turnamen Voli Pantai", "Lomba voli di lapangan pasir kampus.", 3],
            ["Workshop Robotik Anak", "Mengajar robotik dasar ke anak SD.", 1],
            ["Festival Budaya Jepang", "Bunkasai tahunan kampus.", 4],
            ["Seminar Kesehatan Mental", "Pentingnya menjaga kesehatan mental mahasiswa.", 2],
            ["Lomba Essay Nasional", "Kompetisi menulis tingkat nasional.", 2],
            ["Pelatihan Microsoft Office", "Sertifikasi keahlian office.", 1],
            ["Kompetisi Renang Kampus", "Lomba renang antar fakultas.", 3],
            ["Malam Amal Kemanusiaan", "Penggalangan dana untuk bencana alam.", 2]
        ];

        // Status yang akan dirotasi
        $statuses = ['active', 'preparation', 'open_recruitment', 'interview', 'grading_1', 'grading_2', 'finished'];

        // Daftar review manual untuk anggota
        $reviewPool = [
            "Kinerja sangat baik dan proaktif.",
            "Tugas diselesaikan tepat waktu.",
            "Komunikasi lancar dengan tim.",
            "Sedikit pasif, perlu ditingkatkan.",
            "Sangat membantu saat hari H.",
            "Ide-idenya kreatif dan solutif.",
            "Bertanggung jawab atas jobdesk.",
            "Kerjasama tim yang solid.",
            "Perlu lebih teliti lagi.",
            "Kontribusi sangat memuaskan."
        ];

        for ($i = 0; $i < 40; $i++) {
            $evt = $events[$i];
            $title = $evt[0];
            $desc = $evt[1];
            $orgId = $evt[2];

            // Tentukan Status:
            if ($i >= 30) {
                $status = 'finished';
            } else {
                $status = $statuses[$i % count($statuses)];
            }

            // Tentukan tanggal
            $startDate = $now->copy();
            if ($status == 'finished') {
                $startDate = $now->copy()->subMonths(rand(3, 6));
            } elseif ($status == 'preparation' || $status == 'open_recruitment') {
                $startDate = $now->copy()->addMonths(2);
            }
            $endDate = $startDate->copy()->addDays(2);
            $interviewDate = $startDate->copy()->subWeeks(2);

            // Pilih Ketua
            $leaderId = ($i % 30) + 1; 

            // 1. Insert Proposal
            $propId = DB::table('proposals')->insertGetId([
                'student_id' => $leaderId,
                'title' => $title,
                'description' => $desc,
                'status' => 'accepted',
                'created_at' => $now,
                'updated_at' => $now,
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'student_organization_id' => $orgId
            ]);

            // 2. Insert Activity
            $actCode = 'ACT' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            $actId = DB::table('student_activities')->insertGetId([
                'proposal_id' => $propId,
                'activity_code' => $actCode,
                'activity_catalog_code' => 'EVT',
                'student_organization_id' => $orgId,
                'activity_name' => $title,
                'activity_description' => $desc,
                'start_datetime' => $startDate,
                'end_datetime' => $endDate,
                'interview_date' => $interviewDate,
                'interview_location' => 'Ruang Sidang ' . ($i + 1),
                'status' => $status,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            if ($status == 'finished') {
                $this->command->info("-> Event Finished Created: $actCode ($title)");
            }

            // 3. Insert Activity Sub Roles & QUESTIONS
            $divCodes = ['SR01', 'SR02', 'SR03', 'SR04']; 
            
            // Insert 1 General Question
            $qGenId = DB::table('recruitment_questions')->insertGetId([
                'student_activity_id' => $actId,
                'sub_role_id' => null, // General
                'question' => $generalQ[rand(0, 2)],
                'created_at' => $now,
                'updated_at' => $now
            ]);

            $mapDivToQ = []; // Map sub_role_id -> question_id

            foreach ($divCodes as $dc) {
                $sid = SubRole::where('sub_role_code', $dc)->value('sub_role_id');
                DB::table('activity_sub_roles')->insert([
                    'student_activity_id' => $actId,
                    'sub_role_id' => $sid,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // Insert Specific Question for this Division
                if(isset($specificQ[$dc])){
                    $qId = DB::table('recruitment_questions')->insertGetId([
                        'student_activity_id' => $actId,
                        'sub_role_id' => $sid,
                        'question' => $specificQ[$dc],
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                    $mapDivToQ[$sid] = $qId;
                }
            }

            // Variable untuk menampung ID anggota panitia yang akan dinilai
            $activityMemberIds = [];

            // 4. Insert Activity Structures (Anggota Panitia)
            
            // Siapkan Review Ketua jika Finished
            $leadReview = null;
            $leadPoints = null;
            if ($status == 'finished') {
                $leadReview = "Kepemimpinan yang sangat baik, acara berjalan sukses.";
                $leadPoints = 100;
            }

            // a. Ketua (BPH)
            DB::table('activity_structures')->insert([
                'student_activity_id' => $actId,
                'student_id' => $leaderId,
                'student_role_id' => 1, // LEAD
                'sub_role_id' => $bphId,
                'structure_name' => 'Project Manager',
                'structure_points' => 100,
                'final_point_percentage' => $leadPoints, 
                'final_review' => $leadReview,           
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $activityMemberIds[] = $leaderId; 

            // b. Anggota Lain (5 orang) & REKRUTMEN ACCEPTED
            for ($m = 1; $m <= 5; $m++) {
                $memberId = (($leaderId + $m) % 50) + 1; // Rotasi ID mahasiswa 1-50
                
                // Tentukan peran
                $roleId = 3; // Anggota
                $roleName = 'Staff';
                $divCode = 'SR04'; // Default Logistik

                if ($m == 1) { 
                    $roleId = 2; $divCode = 'SR01'; $roleName = 'Sekretaris'; 
                } elseif ($m == 2) {
                    $roleId = 4; $divCode = 'SR02'; $roleName = 'Koordinator Acara'; 
                } elseif ($m == 3) {
                    $divCode = 'SR03'; $roleName = 'Staff Media'; 
                }

                $subId = SubRole::where('sub_role_code', $divCode)->value('sub_role_id');

                // Siapkan Review Anggota jika Finished
                $memReview = null;
                $memPoints = null;
                if ($status == 'finished') {
                    $memReview = $reviewPool[($memberId + $i) % count($reviewPool)];
                    $memPoints = rand(75, 95); 
                }

                // Insert Structure
                DB::table('activity_structures')->insert([
                    'student_activity_id' => $actId,
                    'student_id' => $memberId,
                    'student_role_id' => $roleId,
                    'sub_role_id' => $subId,
                    'structure_name' => $roleName,
                    'structure_points' => 50,
                    'final_point_percentage' => $memPoints,
                    'final_review' => $memReview,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $activityMemberIds[] = $memberId;

                // Insert Registration (Status: Accepted)
                $regId = DB::table('recruitment_registrations')->insertGetId([
                    'student_activity_id' => $actId,
                    'student_id' => $memberId,
                    'choice_1_sub_role_id' => $subId,
                    'reason_1' => "Saya ingin berkontribusi.",
                    'choice_2_sub_role_id' => ($subId == $sid ? SubRole::where('sub_role_code', 'SR02')->value('sub_role_id') : $sid),
                    'reason_2' => "Sebagai opsi kedua.",
                    'status' => 'accepted',
                    'decision_reason' => "Diterima sebagai anggota.",
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                // Insert Answers (General + Specific)
                DB::table('recruitment_answers')->insert([
                    'recruitment_registration_id' => $regId,
                    'question_id' => $qGenId,
                    'answer_text' => "Motivasi saya sangat tinggi.",
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
                if(isset($mapDivToQ[$subId])){
                    DB::table('recruitment_answers')->insert([
                        'recruitment_registration_id' => $regId,
                        'question_id' => $mapDivToQ[$subId],
                        'answer_text' => "Saya memiliki skill yang relevan.",
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }

                // Insert Decision (Accepted)
                DB::table('recruitment_decisions')->insert([
                    'recruitment_registration_id' => $regId,
                    'judge_student_id' => $leaderId,
                    'verdict' => 'accept',
                    'reason' => 'Sesuai kualifikasi.',
                    'created_at' => $now,
                    'updated_at' => $now
                ]);
            }

            // 5. Insert Registrations for Outsiders (Rejected/Pending/Interview)
            // Tambah 3 pendaftar yang tidak diterima
            for($x = 1; $x <= 3; $x++){
                // Cari ID yang bukan member
                $outsiderId = (($leaderId + 10 + $x) % 50) + 1; 
                
                // Tentukan status pendaftaran berdasarkan status acara
                $regStatus = 'pending';
                if(in_array($status, ['finished', 'active', 'grading_1', 'grading_2'])) {
                    $regStatus = 'rejected';
                } elseif ($status == 'interview') {
                    $regStatus = 'interview';
                }

                $randomDiv = SubRole::where('sub_role_code', $divCodes[rand(1,3)])->value('sub_role_id'); 

                $regId = DB::table('recruitment_registrations')->insertGetId([
                    'student_activity_id' => $actId,
                    'student_id' => $outsiderId,
                    'choice_1_sub_role_id' => $randomDiv,
                    'reason_1' => "Ingin mencoba pengalaman baru.",
                    'choice_2_sub_role_id' => null, 
                    'reason_2' => null,
                    'status' => $regStatus,
                    'decision_reason' => ($regStatus == 'rejected') ? "Maaf, kuota penuh." : null,
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                // Insert Answers
                DB::table('recruitment_answers')->insert([
                    'recruitment_registration_id' => $regId,
                    'question_id' => $qGenId,
                    'answer_text' => "Saya ingin belajar organisasi.",
                    'created_at' => $now,
                    'updated_at' => $now
                ]);

                // Insert Decision (Only if Rejected)
                if ($regStatus == 'rejected') {
                    DB::table('recruitment_decisions')->insert([
                        'recruitment_registration_id' => $regId,
                        'judge_student_id' => $leaderId,
                        'verdict' => 'reject',
                        'reason' => 'Skill belum memenuhi standar.',
                        'created_at' => $now,
                        'updated_at' => $now
                    ]);
                }
            }

            // 6. Mail Invites (Contoh Statis)
            $invitedStudent = DB::table('students')->where('student_id', 40)->first();
            if ($invitedStudent) {
                DB::table('mail_invites')->insert([
                    'student_number' => $invitedStudent->student_number,
                    'student_activity_id' => $actId,
                    'status' => 'pending',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            // 7. Student Ratings (Hanya untuk acara finished)
            if ($status == 'finished') {
                foreach ($activityMemberIds as $raterId) {
                    foreach ($activityMemberIds as $ratedId) {
                        // Jangan menilai diri sendiri
                        if ($raterId === $ratedId) continue;

                        DB::table('student_ratings')->insert([
                            'student_activity_id' => $actId,
                            'rater_student_id' => $raterId,
                            'rated_student_id' => $ratedId,
                            'stars' => rand(3, 5), 
                            'reason' => $reviewPool[rand(0, count($reviewPool) - 1)], // Fix variable name
                            'created_at' => $now,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Seeding Selesai: 40 Acara, 50 Mahasiswa, 20 Dosen, Divisi, Struktur, Rekrutmen & Penilaian.');
    }
}