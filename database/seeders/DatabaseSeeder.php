<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // ==========================================
        // PHASE 1: MASTER DATA (PATEN)
        // ==========================================

        // 1. Organizations & Departments
        DB::table('student_organizations')->insert([
            ['student_organization_id' => 1, 'organization_name' => 'Himpunan Mahasiswa Informatika'],
            ['student_organization_id' => 2, 'organization_name' => 'Badan Eksekutif Mahasiswa'],
        ]);

        DB::table('academic_departments')->insert([
            ['department_id' => 1, 'department_name' => 'Informatika'],
            ['department_id' => 2, 'department_name' => 'DKV'],
            ['department_id' => 3, 'department_name' => 'Sistem Informasi'],
        ]);

        // 2. Students (Actors)
        // Iris (Ketua), Mateo (BPH), Sora (Pendaftar Diterima), Riku (Pendaftar Ditolak)
        DB::table('students')->insert([
            ['student_id' => 1, 'student_number' => '241000001', 'full_name' => 'Iris Kalani', 'points_balance' => 50, 'class_group' => 'A', 'department_id' => 1],
            ['student_id' => 2, 'student_number' => '241000452', 'full_name' => 'Mateo Lin', 'points_balance' => 30, 'class_group' => 'B', 'department_id' => 2],
            ['student_id' => 3, 'student_number' => '251000233', 'full_name' => 'Sora Veld', 'points_balance' => 0, 'class_group' => 'C', 'department_id' => 3],
            ['student_id' => 4, 'student_number' => '251000999', 'full_name' => 'Riku Tendo', 'points_balance' => 0, 'class_group' => 'A', 'department_id' => 1],
        ]);

        // 3. Lecturers
        DB::table('lecturers')->insert([
            [
                'lecturer_id' => 1,
                'lecturer_code' => 'L001',
                'lecturer_name' => 'Prof. Sylvie Tan',
                'employee_nip' => 'EMP90001',
                'nidn' => '998877',
                'employment_status' => 'active',
                'start_date' => '2015-08-01',
                'end_date' => '2099-12-31',
                'is_certified' => 1,
                'created_at' => now(),
            ],
            [
                'lecturer_id' => 2,
                'lecturer_code' => 'L014',
                'lecturer_name' => 'Dr. Kenji Rao',
                'employee_nip' => 'EMP90014',
                'nidn' => '887766',
                'employment_status' => 'active',
                'start_date' => '2018-01-15',
                'end_date' => '2099-12-31',
                'is_certified' => 0,
                'created_at' => now(),
            ],
            [
                'lecturer_id' => 3,
                'lecturer_code' => 'L022',
                'lecturer_name' => 'Ir. Paula Este',
                'employee_nip' => 'EMP90022',
                'nidn' => '776655',
                'employment_status' => 'active',
                'start_date' => '2012-06-10',
                'end_date' => '2099-12-31',
                'is_certified' => 1,
                'created_at' => now(),
            ]
        ]);

        // 4. Roles & Sub Roles
        DB::table('student_roles')->insert([
            ['student_role_id' => 1, 'role_code' => 'LEAD', 'role_name' => 'Team Lead'],
            ['student_role_id' => 2, 'role_code' => 'NOTE', 'role_name' => 'Secretary'],
            ['student_role_id' => 3, 'role_code' => 'MEBR', 'role_name' => 'Member'],
            ['student_role_id' => 4, 'role_code' => 'COOR', 'role_name' => 'Coordinator'],
        ]);

        DB::table('sub_roles')->insert([
            ['sub_role_id' => 1, 'sub_role_code' => 'SR01', 'sub_role_name' => 'BPH', 'sub_role_name_en' => 'Main'],
            ['sub_role_id' => 2, 'sub_role_code' => 'SR02', 'sub_role_name' => 'Acara', 'sub_role_name_en' => 'Event'],
            ['sub_role_id' => 3, 'sub_role_code' => 'SR03', 'sub_role_name' => 'Media', 'sub_role_name_en' => 'Media'],
            ['sub_role_id' => 4, 'sub_role_code' => 'SR04', 'sub_role_name' => 'Logistik', 'sub_role_name_en' => 'Logistics'],
        ]);

        // 5. Users (Login)
        DB::table('users')->insert([
            [
                'name' => 'Iris',
                'email' => 'user1@mail.com',
                'password' => Hash::make('password'),
                'student_number' => '241000001',
                'lecturer_code' => null, // <--- Must exist!
                'role' => 'student'
            ],
            [
                'name' => 'Mateo',
                'email' => 'user2@mail.com',
                'password' => Hash::make('password'),
                'student_number' => '241000452',
                'lecturer_code' => null, // <--- Must exist!
                'role' => 'student'
            ],
            [
                'name' => 'Sora',
                'email' => 'user3@mail.com',
                'password' => Hash::make('password'),
                'student_number' => '251000233',
                'lecturer_code' => null,
                'role' => 'student'
            ], // Sora
            [
                'name' => 'Riku',
                'email' => 'user4@mail.com',
                'password' => Hash::make('password'),
                'student_number' => '251000999',
                'lecturer_code' => null,
                'role' => 'student'
            ], // Riku
            [
                'name' => 'Prof. Sylvie Tan',
                'email' => 'user5@mail.com',
                'password' => Hash::make('password'),
                'student_number' => null,   // <--- Explicitly null
                'lecturer_code' => 'L001',  // <--- Now this will get saved
                'role' => 'lecturer'
            ],
            [
                'name' => 'Ir. Paula Este',
                'email' => 'admin@mail.com',
                'password' => Hash::make('password'),
                'student_number' => null,   // <--- Explicitly null
                'lecturer_code' => 'L022',  // <--- Now this will get saved
                'role' => 'admin'
            ],
        ]);

        // ==========================================
        // PHASE 2: PROPOSAL & ACTIVITY (PREPARATION)
        // ==========================================

        // --- SCENARIO 1: INNOVATION HACKDAY (Status: Open Recruitment) ---
        // Ini skenario utama untuk tes alur pendaftaran

        // 6.1. Proposal Hackday
        $propHackday = DB::table('proposals')->insertGetId([
            'student_id' => 1, // Iris (Ketua)
            'title' => 'Innovation Hackday 2024',
            'description' => 'Proposal kegiatan kompetisi pengembangan perangkat lunak tingkat universitas.',
            'status' => 'accepted',
            'created_at' => now(),
        ]);

        // 7.1. Activity Hackday
        $activityId = DB::table('student_activities')->insertGetId([
            'proposal_id' => $propHackday,
            'activity_code' => 'ACT1001',
            'activity_catalog_code' => 'EVT', // Event
            'student_organization_id' => 1, // HIMA IF
            'activity_name' => 'Innovation Hackday 2024',
            // Deskripsi lebih menarik
            'activity_description' => 'Bergabunglah dalam maraton koding 24 jam di mana inovasi bertemu dengan eksekusi! Tantang dirimu untuk menyelesaikan masalah nyata menggunakan teknologi terkini (AI, IoT, Blockchain) dan menangkan total hadiah puluhan juta rupiah. Siapkan tim terbaikmu!',
            'start_datetime' => Carbon::parse('2024-11-10 09:00:00'),
            'end_datetime' => Carbon::parse('2024-11-11 15:00:00'),
            'status' => 'open_recruitment', // Sedang buka pendaftaran panitia
            'created_at' => now(),
        ]);

        // 8.1. Structure Hackday (BPH Inti)
        DB::table('activity_structures')->insert([
            [
                'student_activity_id' => $activityId,
                'student_id' => 1, // Iris
                'student_role_id' => 1, // Team Lead
                'sub_role_id' => 2, // Acara
                'structure_name' => 'Project Manager',
                'structure_points' => 200,
                'created_at' => now(),
            ],
            [
                'student_activity_id' => $activityId,
                'student_id' => 2, // Mateo
                'student_role_id' => 4, // Coordinator
                'sub_role_id' => 3, // Media
                'structure_name' => 'Head of Creative & Media',
                'structure_points' => 150,
                'created_at' => now(),
            ]
        ]);


        // --- SCENARIO 2: VISUAL ART EXHIBITION (Status: Active/Berjalan) ---
        // Skenario untuk tes jadwal (schedule) dan grading nanti

        // 6.2. Proposal Art
        $propArt = DB::table('proposals')->insertGetId([
            'student_id' => 2, // Mateo (Ketua)
            'title' => 'Chromatic: Visual Art Exhibition',
            'description' => 'Pameran karya seni mahasiswa DKV.',
            'status' => 'accepted',
            'created_at' => now()->subMonth(),
        ]);

        // 7.2. Activity Art
        $actArt = DB::table('student_activities')->insertGetId([
            'proposal_id' => $propArt,
            'activity_code' => 'ACT2005',
            'activity_catalog_code' => 'EXH', // Exhibition
            'student_organization_id' => 2, // BEM
            'activity_name' => 'Chromatic Exhibition 2024',
            'activity_description' => 'Selami dunia penuh warna di Chromatic 2024! Pameran seni visual interaktif yang menggabungkan seni tradisional dan digital projection mapping. Saksikan karya terbaik dari mahasiswa berbakat yang akan memanjakan matamu.',
            'start_datetime' => Carbon::now()->addDays(5), // Acara 5 hari lagi
            'end_datetime' => Carbon::now()->addDays(7),
            'status' => 'active', // Panitia sudah lengkap, sedang persiapan teknis
            'created_at' => now()->subMonth(),
        ]);

        // 8.2. Structure Art (Sudah lengkap panitianya)
        DB::table('activity_structures')->insert([
            [
                'student_activity_id' => $actArt,
                'student_id' => 2, // Mateo
                'student_role_id' => 1, // Lead
                'sub_role_id' => 2, // Media (Anak DKV pegang media & acara)
                'structure_name' => 'Exhibition Director',
                'structure_points' => 250,
                'created_at' => now()->subMonth(),
            ],
            [
                'student_activity_id' => $actArt,
                'student_id' => 3, // Sora
                'student_role_id' => 2, // Secretary
                'sub_role_id' => 1, // Acara
                'structure_name' => 'Main Secretary',
                'structure_points' => 180,
                'created_at' => now()->subMonth(),
            ],
            [
                'student_activity_id' => $actArt,
                'student_id' => 1, // Iris (Jadi anggota biasa disini)
                'student_role_id' => 3, // Member
                'sub_role_id' => 3, // Logistik
                'structure_name' => 'Logistics Staff',
                'structure_points' => 100,
                'created_at' => now()->subMonth(),
            ]
        ]);


        // --- SCENARIO 3: ESPORTS VALORANT CUP (Status: Preparation/Baru dibuat) ---
        // Skenario untuk tes ketua baru appoint BPH (Flow awal banget)

        // 6.3. Proposal Esports
        $propSport = DB::table('proposals')->insertGetId([
            'student_id' => 4, // Riku (Ketua)
            'title' => 'Campus Valorant Championship',
            'description' => 'Turnamen Valorant antar fakultas.',
            'status' => 'accepted',
            'created_at' => now()->subDays(2),
        ]);

        // 7.3. Activity Esports
        $actSport = DB::table('student_activities')->insertGetId([
            'proposal_id' => $propSport,
            'activity_code' => 'ACT3099',
            'activity_catalog_code' => 'CMP', // Competition
            'student_organization_id' => 1, // HIMA IF
            'activity_name' => 'Valorant Championship: Retake',
            'activity_description' => 'Buktikan skill aim-mu di turnamen Valorant terbesar se-kampus! Rebut prize pool total Rp 5.000.000 dan gelar juara bertahan. Dilengkapi dengan live stream caster profesional dan setup PC high-end di auditorium utama.',
            'start_datetime' => Carbon::parse('2024-12-20 10:00:00'),
            'end_datetime' => Carbon::parse('2024-12-22 20:00:00'),
            'status' => 'preparation', // Belum buka pendaftaran, Riku baru sendirian
            'created_at' => now(),
        ]);

        // 8.3. Structure Esports (Cuma Riku sendirian)
        DB::table('activity_structures')->insert([
            [
                'student_activity_id' => $actSport,
                'student_id' => 4, // Riku
                'student_role_id' => 1, // Lead
                'sub_role_id' => 1, // Acara
                'structure_name' => 'Head of Tournament',
                'structure_points' => 220,
                'created_at' => now(),
            ]
        ]);

        // ==========================================
        // PHASE 3: RECRUITMENT (STEP 1 & 2)
        // ==========================================

        // 9. Buat Pertanyaan
        DB::table('recruitment_questions')->insert([
            ['student_activity_id' => $activityId, 'sub_role_id' => 1, 'question' => 'Apa motivasi kamu?'],
            ['student_activity_id' => $activityId, 'sub_role_id' => 3, 'question' => 'Bisa pakai Adobe Illustrator?'], // Khusus Media
        ]);

        // 10. Registrasi Peserta
        // Sora daftar Media (Diterima nantinya)
        $regSora = DB::table('recruitment_registrations')->insertGetId([
            'student_activity_id' => $activityId,
            'student_id' => 3, // Sora
            'choice_1_sub_role_id' => 2, // Media
            'reason_1' => 'Saya suka desain',
            'choice_2_sub_role_id' => 3, // Logistik
            'reason_2' => 'Saya kuat angkat barang',
            'status' => 'accepted', // Final status
            'decision_reason' => 'Portofolio sangat memuaskan', // Alasan Final Ketua
            'created_at' => now(),
        ]);

        // Riku daftar Media (Ditolak nantinya)
        $regRiku = DB::table('recruitment_registrations')->insertGetId([
            'student_activity_id' => $activityId,
            'student_id' => 4, // Riku
            'choice_1_sub_role_id' => 2,
            'reason_1' => 'Iseng aja',
            'choice_2_sub_role_id' => null,
            'reason_2' => null,
            'status' => 'rejected', // Final status
            'decision_reason' => 'Tidak serius saat wawancara', // Alasan Final Ketua
            'created_at' => now(),
        ]);

        // 11. Jawaban Interview (Sora)
        DB::table('recruitment_answers')->insert([
            ['recruitment_registration_id' => $regSora, 'question_id' => 1, 'answer_text' => 'Ingin cari pengalaman', 'interviewer_note' => 'Semangat tinggi'],
            ['recruitment_registration_id' => $regSora, 'question_id' => 2, 'answer_text' => 'Bisa banget kak', 'interviewer_note' => 'Portofolio valid'],
        ]);

        // 12. Voting BPH (Mateo menilai Sora)
        DB::table('recruitment_decisions')->insert([
            'recruitment_registration_id' => $regSora,
            'judge_student_id' => 2, // Mateo
            'verdict' => 'accept',
            'reason' => 'Skill match dengan kebutuhan divisi',
            'created_at' => now(),
        ]);

        // 13. Karena Sora diterima, Sistem otomatis insert ke Activity Structure (Step 2 End)
        DB::table('activity_structures')->insert([
            'student_activity_id' => $activityId,
            'student_id' => 3, // Sora
            'student_role_id' => 3, // Member
            'sub_role_id' => 2, // Media
            'structure_name' => 'Graphic Designer',
            'structure_points' => 100,
            'created_at' => now(),
        ]);

        // ==========================================
        // PHASE 4: SCHEDULE & FINISH (STEP 3 & 4)
        // ==========================================

        // 14. Jadwal Rapat
        DB::table('activity_schedules')->insert([
            'student_activity_id' => $activityId,
            'title' => 'Technical Meeting',
            'start_time' => '2024-10-09 10:00:00',
            'end_time' => '2024-10-09 12:00:00',
            'location' => 'Zoom Meeting',
            'status' => 'completed', // <--- Tambahan status
            'created_at' => now(),
        ]);

        // 15. Update Status Acara ke Grading
        DB::table('student_activities')->where('student_activity_id', $activityId)->update(['status' => 'grading_1']);

        // 16. Rating (Sora menilai Mateo)
        DB::table('student_ratings')->insert([
            'student_activity_id' => $activityId,
            'rater_student_id' => 3, // Sora
            'rated_student_id' => 2, // Mateo
            'stars' => 4,
            'reason' => 'Koor paling asik dan membimbing',
            'created_at' => now(),
        ]);

        // 17. Ketua memberikan Final Point Percentage (Selesai Acara)
        DB::table('activity_structures')
            ->where('student_id', 2) // Mateo
            ->update([
                'final_point_percentage' => 100, // 100%
                'final_review' => 'Kerja bagus, rating dari anggota tinggi.'
            ]);

        // Selesai
    }
}
