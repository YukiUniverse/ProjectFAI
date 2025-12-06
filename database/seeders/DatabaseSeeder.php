<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\StudentActivity;
use App\Models\SubRole;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // PHASE 1: MASTER DATA
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

        // 2. Roles & Sub Roles
        DB::table('student_roles')->insert([
            ['student_role_id' => 1, 'role_code' => 'LEAD', 'role_name' => 'Team Lead'],   // Ketua
            ['student_role_id' => 2, 'role_code' => 'NOTE', 'role_name' => 'Secretary'],   // Sekretaris
            ['student_role_id' => 3, 'role_code' => 'MEBR', 'role_name' => 'Member'],      // Anggota
            ['student_role_id' => 4, 'role_code' => 'COOR', 'role_name' => 'Coordinator'], // Koordinator
        ]);



        // ==========================================
        // PHASE 2: USERS (10 Students, 5 Lecturers)
        // ==========================================

        $password = Hash::make('password');

        // --- STUDENTS (10) ---
        $students = [
            ['id' => 1, 'nrp' => '241000001', 'name' => 'Iris Kalani', 'dept' => 1], // The Leader
            ['id' => 2, 'nrp' => '241000002', 'name' => 'Mateo Lin', 'dept' => 2],
            ['id' => 3, 'nrp' => '241000003', 'name' => 'Sora Veld', 'dept' => 3],
            ['id' => 4, 'nrp' => '241000004', 'name' => 'Riku Tendo', 'dept' => 1],
            ['id' => 5, 'nrp' => '241000005', 'name' => 'Nina Zen', 'dept' => 2],
            ['id' => 6, 'nrp' => '241000006', 'name' => 'Arlo Puce', 'dept' => 3],
            ['id' => 7, 'nrp' => '241000007', 'name' => 'Lila Kross', 'dept' => 1],
            ['id' => 8, 'nrp' => '241000008', 'name' => 'Finn Balor', 'dept' => 2],
            ['id' => 9, 'nrp' => '241000009', 'name' => 'Gwen Stacy', 'dept' => 3],
            ['id' => 10, 'nrp' => '241000010', 'name' => 'Miles Mo', 'dept' => 1],
        ];

        foreach ($students as $s) {
            // Insert Student Data
            DB::table('students')->insert([
                'student_id' => $s['id'],
                'student_number' => $s['nrp'],
                'full_name' => $s['name'],
                'points_balance' => rand(0, 100),
                'class_group' => 'A',
                'department_id' => $s['dept'],
            ]);

            // Insert Login Data
            DB::table('users')->insert([
                'name' => $s['name'],
                'email' => strtolower(str_replace(' ', '', $s['name'])) . '@student.com',
                'password' => $password,
                'student_number' => $s['nrp'],
                'lecturer_code' => null,
                'role' => 'student'
            ]);
        }

        // --- LECTURERS (5) ---
        $lecturers = [
            ['id' => 1, 'code' => 'L001', 'name' => 'Prof. Admin', 'role' => 'admin'], // The Admin
            ['id' => 2, 'code' => 'L002', 'name' => 'Dr. Strange', 'role' => 'lecturer'],
            ['id' => 3, 'code' => 'L003', 'name' => 'Ir. Stark', 'role' => 'lecturer'],
            ['id' => 4, 'code' => 'L004', 'name' => 'Dr. Banner', 'role' => 'lecturer'],
            ['id' => 5, 'code' => 'L005', 'name' => 'Prof. X', 'role' => 'lecturer'],
        ];

        foreach ($lecturers as $l) {
            DB::table('lecturers')->insert([
                'lecturer_id' => $l['id'],
                'lecturer_code' => $l['code'],
                'lecturer_name' => $l['name'],
                'employee_nip' => 'NIP' . $l['code'],
                'nidn' => 'NIDN' . $l['code'],
                'employment_status' => 'active',
                'start_date' => '2020-01-01',
                'end_date' => '2099-12-31',
                'is_certified' => 1,
                'created_at' => now(),
            ]);

            DB::table('users')->insert([
                'name' => $l['name'],
                'email' => strtolower(str_replace([' ', '.'], '', $l['name'])) . '@staff.com',
                'password' => $password,
                'student_number' => null,
                'lecturer_code' => $l['code'],
                'role' => $l['role']
            ]);
        }

        // ==========================================
        // PHASE 3: PROPOSALS (4 Accepted, 3 Rejected)
        // ==========================================

        // Accepted Proposals (IDs 1-4)
        $prop1 = DB::table('proposals')->insertGetId(['student_id' => 1, 'title' => 'Tech Summit 2024', 'description' => 'Proposal Accepted 1', 'status' => 'accepted', 'created_at' => now()]);
        $prop2 = DB::table('proposals')->insertGetId(['student_id' => 1, 'title' => 'Art Gala Night', 'description' => 'Proposal Accepted 2', 'status' => 'accepted', 'created_at' => now()->subMonths(3)]);
        $prop3 = DB::table('proposals')->insertGetId(['student_id' => 4, 'title' => 'Esports Cup', 'description' => 'Proposal Accepted 3', 'status' => 'accepted', 'created_at' => now()]);
        $prop4 = DB::table('proposals')->insertGetId(['student_id' => 10, 'title' => 'Music Festival', 'description' => 'Proposal Accepted 4', 'status' => 'accepted', 'created_at' => now()]);

        // Rejected Proposals (IDs 5-7)
        DB::table('proposals')->insert([
            ['student_id' => 2, 'title' => 'Bad Idea 1', 'description' => 'Rejected Reason A', 'status' => 'rejected', 'created_at' => now()],
            ['student_id' => 3, 'title' => 'Bad Idea 2', 'description' => 'Rejected Reason B', 'status' => 'rejected', 'created_at' => now()],
            ['student_id' => 5, 'title' => 'Bad Idea 3', 'description' => 'Rejected Reason C', 'status' => 'rejected', 'created_at' => now()],
        ]);

        // ==========================================
        // PHASE 4: ACTIVITIES, SUB-ROLES & STRUCTURES
        // ==========================================

        // ------------------------------------------
        // ACTIVITY 1: TECH SUMMIT (Active)
        // ------------------------------------------

        $act1 = DB::table('student_activities')->insertGetId([
            'proposal_id' => $prop1,
            'activity_code' => 'ACT001',
            'activity_catalog_code' => 'EVT',
            'student_organization_id' => 1,
            'activity_name' => 'Tech Summit 2024',
            'activity_description' => 'An active event currently running.',
            'start_datetime' => Carbon::now()->subDays(2),
            'end_datetime' => Carbon::now()->addDays(5),
            'status' => 'active',
            'created_at' => now(),
        ]);

        // Sub Roles for ACT001 (IDs 1-4)
        // DB::table('sub_roles')->insert([
        //     ['sub_role_id' => 1, 'student_activity_id' => $act1, 'sub_role_code' => 'SR01', 'sub_role_name' => 'BPH', 'sub_role_name_en' => 'Main Board'],
        //     ['sub_role_id' => 2, 'student_activity_id' => $act1, 'sub_role_code' => 'SR02', 'sub_role_name' => 'Acara', 'sub_role_name_en' => 'Event'],
        //     ['sub_role_id' => 3, 'student_activity_id' => $act1, 'sub_role_code' => 'SR03', 'sub_role_name' => 'Media', 'sub_role_name_en' => 'Media'],
        //     ['sub_role_id' => 4, 'student_activity_id' => $act1, 'sub_role_code' => 'SR04', 'sub_role_name' => 'Logistik', 'sub_role_name_en' => 'Logistics'],
        // ]);

        // Structure for ACT001 (Using SubRole IDs 1-4)
        // DB::table('activity_structures')->insert([
        //     ['student_activity_id' => $act1, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => 1, 'structure_name' => 'Project Manager', 'structure_points' => 0, 'created_at' => now()],
        //     ['student_activity_id' => $act1, 'student_id' => 5, 'student_role_id' => 2, 'sub_role_id' => 1, 'structure_name' => 'Main Secretary', 'structure_points' => 0, 'created_at' => now()],
        //     ['student_activity_id' => $act1, 'student_id' => 2, 'student_role_id' => 4, 'sub_role_id' => 2, 'structure_name' => 'Head of Event', 'structure_points' => 0, 'created_at' => now()],
        //     ['student_activity_id' => $act1, 'student_id' => 3, 'student_role_id' => 4, 'sub_role_id' => 3, 'structure_name' => 'Head of Media', 'structure_points' => 0, 'created_at' => now()],
        //     ['student_activity_id' => $act1, 'student_id' => 6, 'student_role_id' => 3, 'sub_role_id' => 4, 'structure_name' => 'Logistics Staff', 'structure_points' => 0, 'created_at' => now()],
        // ]);


        // ------------------------------------------
        // ACTIVITY 2: ART GALA (Finished)
        // ------------------------------------------

        $act2 = DB::table('student_activities')->insertGetId([
            'proposal_id' => $prop2,
            'activity_code' => 'ACT002',
            'activity_catalog_code' => 'ART',
            'student_organization_id' => 2,
            'activity_name' => 'Art Gala Night',
            'activity_description' => 'A finished successful event.',
            'start_datetime' => Carbon::now()->subMonths(2),
            'end_datetime' => Carbon::now()->subMonths(2)->addDays(2),
            'status' => 'finished',
            'created_at' => now()->subMonths(3),
        ]);

        // Sub Roles for ACT002 (IDs 5-8)
        // DB::table('sub_roles')->insert([
        //     ['sub_role_id' => 5, 'student_activity_id' => $act2, 'sub_role_code' => 'SR01', 'sub_role_name' => 'BPH', 'sub_role_name_en' => 'Main Board'],
        //     ['sub_role_id' => 6, 'student_activity_id' => $act2, 'sub_role_code' => 'SR02', 'sub_role_name' => 'Acara', 'sub_role_name_en' => 'Event'],
        //     ['sub_role_id' => 7, 'student_activity_id' => $act2, 'sub_role_code' => 'SR03', 'sub_role_name' => 'Publikasi', 'sub_role_name_en' => 'Publication'], // Different name for variety
        //     ['sub_role_id' => 8, 'student_activity_id' => $act2, 'sub_role_code' => 'SR04', 'sub_role_name' => 'Logistik', 'sub_role_name_en' => 'Logistics'],
        // ]);

        // Structure for ACT002 (Using SubRole IDs 5-8)
        // DB::table('activity_structures')->insert([
        //     ['student_activity_id' => $act2, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => 5, 'structure_name' => 'Director', 'structure_points' => 200, 'final_point_percentage' => 100, 'final_review' => 'Perfect', 'created_at' => now()],
        //     ['student_activity_id' => $act2, 'student_id' => 8, 'student_role_id' => 4, 'sub_role_id' => 6, 'structure_name' => 'Event Coor', 'structure_points' => 150, 'final_point_percentage' => 80, 'final_review' => 'Good', 'created_at' => now()],
        //     ['student_activity_id' => $act2, 'student_id' => 9, 'student_role_id' => 3, 'sub_role_id' => 8, 'structure_name' => 'Staff', 'structure_points' => 100, 'final_point_percentage' => 50, 'final_review' => 'Absent', 'created_at' => now()],
        // ]);

        // Ratings for Act 2
        DB::table('student_ratings')->insert([
            ['student_activity_id' => $act2, 'rater_student_id' => 8, 'rated_student_id' => 1, 'stars' => 4, 'reason' => 'Great leader', 'created_at' => now()],
            ['student_activity_id' => $act2, 'rater_student_id' => 1, 'rated_student_id' => 8, 'stars' => 4, 'reason' => 'Good work', 'created_at' => now()],
        ]);


        // ------------------------------------------
        // ACTIVITY 3: ESPORTS CUP (Preparation)
        // ------------------------------------------

        $act3 = DB::table('student_activities')->insertGetId([
            'proposal_id' => $prop3,
            'activity_code' => 'ACT003',
            'activity_catalog_code' => 'CMP',
            'student_organization_id' => 1,
            'activity_name' => 'Esports Cup',
            'activity_description' => 'Just starting, blank slate.',
            'start_datetime' => Carbon::now()->addMonths(2),
            'end_datetime' => Carbon::now()->addMonths(2)->addDays(3),
            'status' => 'preparation',
            'created_at' => now(),
        ]);

        // Sub Roles for ACT003 (IDs 9-10) - Smaller structure
        // DB::table('sub_roles')->insert([
        //     ['sub_role_id' => 9, 'student_activity_id' => $act3, 'sub_role_code' => 'SR01', 'sub_role_name' => 'BPH', 'sub_role_name_en' => 'Main Board'],
        //     ['sub_role_id' => 10, 'student_activity_id' => $act3, 'sub_role_code' => 'SR02', 'sub_role_name' => 'Kompetisi', 'sub_role_name_en' => 'Competition'],
        // ]);

        // Structure for ACT003 (Using SubRole IDs 9-10)
        // DB::table('activity_structures')->insert([
        //     ['student_activity_id' => $act3, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => 9, 'structure_name' => 'Chief', 'structure_points' => 0, 'created_at' => now()],
        //     ['student_activity_id' => $act3, 'student_id' => 7, 'student_role_id' => 4, 'sub_role_id' => 10, 'structure_name' => 'Game Master', 'structure_points' => 0, 'created_at' => now()],
        // ]);


        // ------------------------------------------
        // ACTIVITY 4: MUSIC FEST (Open Recruitment)
        // ------------------------------------------

        $act4 = DB::table('student_activities')->insertGetId([
            'proposal_id' => $prop4,
            'activity_code' => 'ACT004',
            'activity_catalog_code' => 'FST',
            'student_organization_id' => 2,
            'activity_name' => 'Music Festival',
            'activity_description' => 'We are looking for committees!',
            'start_datetime' => Carbon::now()->addMonths(3),
            'end_datetime' => Carbon::now()->addMonths(3)->addDays(1),
            'status' => 'open_recruitment',
            'created_at' => now(),
        ]);

        // Sub Roles for ACT004 (IDs 11-13)
        // DB::table('sub_roles')->insert([
        //     ['sub_role_id' => 11, 'student_activity_id' => $act4, 'sub_role_code' => 'SR01', 'sub_role_name' => 'BPH', 'sub_role_name_en' => 'Main Board'],
        //     ['sub_role_id' => 12, 'student_activity_id' => $act4, 'sub_role_code' => 'SR02', 'sub_role_name' => 'Artis', 'sub_role_name_en' => 'Artist Liaison'],
        //     ['sub_role_id' => 13, 'student_activity_id' => $act4, 'sub_role_code' => 'SR03', 'sub_role_name' => 'Produksi', 'sub_role_name_en' => 'Production'],
        // ]);

        // Structure (Only Leader exists in BPH - ID 11)
        // DB::table('activity_structures')->insert([
        //     ['student_activity_id' => $act4, 'student_id' => 10, 'student_role_id' => 1, 'sub_role_id' => 11, 'structure_name' => 'Project Lead', 'structure_points' => 0, 'created_at' => now()],
        // ]);

        // Questions linked to specific sub_roles (IDs 12 & 13)
        // DB::table('recruitment_questions')->insert([
        //     ['student_activity_id' => $act4, 'sub_role_id' => 12, 'question' => 'Why do you like music?'],
        //     ['student_activity_id' => $act4, 'sub_role_id' => 13, 'question' => 'Can you edit videos?'],
        // ]);

        DB::table('mail_invites')->insert([
            'student_number' => '241000007', // Lila
            'student_activity_id' => 4, // Music Festival
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Accepted Invite:
        // Invite 'Finn Balor' (241000008) to 'Tech Summit' (Activity 1)
        // Assume he accepted but hasn't been processed into structure yet
        DB::table('mail_invites')->insert([
            'student_number' => '241000008', // Finn
            'student_activity_id' => 1, // Tech Summit
            'status' => 'accept',
            'created_at' => now()->subDays(1),
            'updated_at' => now(),
        ]);

        // 3. Declined Invite:
        // Invite 'Gwen Stacy' (241000009) to 'Esports Cup' (Activity 3)
        DB::table('mail_invites')->insert([
            'student_number' => '241000009', // Gwen
            'student_activity_id' => 3, // Esports Cup
            'status' => 'decline',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        // NO registrations inserted for Act 4.


        // Mengambil 4 aktivitas yang sudah ada (Updated limit to 4)
        $activities = StudentActivity::limit(4)->get();

        if ($activities->count() < 4) {
            $this->command->warn('Harap jalankan StudentActivitySeeder terlebih dahulu. Butuh minimal 4 activity.');
            return;
        }

        // Variabel yang sudah ada (tinggal dipakai)
        $act1 = $activities[0];
        $act2 = $activities[1];
        $act3 = $activities[2];
        $act4 = $activities[3]; // Added Act 4

        $now = Carbon::now();

        // Mapping Data Sesuai Request
        $assignments = [
            // Activity 1: BPH, Acara, Media, Logistik
            $act1->student_activity_id => [
                ['code' => 'SR01', 'name' => 'BPH', 'en' => 'Main Board'],
                ['code' => 'SR02', 'name' => 'Divisi Acara', 'en' => 'Event'],
                ['code' => 'SR03', 'name' => 'Divisi Media', 'en' => 'Media'],
                ['code' => 'SR04', 'name' => 'Divisi Logistik', 'en' => 'Logistics'],
            ],
            // Activity 2: BPH, Acara, Publikasi, Logistik
            $act2->student_activity_id => [
                ['code' => 'SR01', 'name' => 'BPH', 'en' => 'Main Board'],      // Reuse
                ['code' => 'SR02', 'name' => 'Divisi Acara', 'en' => 'Event'],          // Reuse
                ['code' => 'SR05', 'name' => 'Divisi Publikasi', 'en' => 'Publication'],// New Code (SR03 used by Media)
                ['code' => 'SR04', 'name' => 'Divisi Logistik', 'en' => 'Logistics'],   // Reuse
            ],
            // Activity 3: BPH, Kompetisi
            $act3->student_activity_id => [
                ['code' => 'SR01', 'name' => 'BPH', 'en' => 'Main Board'],        // Reuse
                ['code' => 'SR06', 'name' => 'Divisi Kompetisi', 'en' => 'Competition'], // New Code (SR02 used by Acara)
            ],
            // Activity 4: BPH, Artis, Produksi (Added)
            $act4->student_activity_id => [
                ['code' => 'SR01', 'name' => 'BPH', 'en' => 'Main Board'],        // Reuse
                ['code' => 'SR07', 'name' => 'Divisi Artis', 'en' => 'Artist Liaison'],   // New Code (SR02 used by Acara)
                ['code' => 'SR08', 'name' => 'Divisi Produksi', 'en' => 'Production'],    // New Code (SR03 used by Media)
            ],
        ];

        // Eksekusi Insert
        foreach ($assignments as $activityId => $roles) {
            foreach ($roles as $roleData) {
                
                // 1. Pastikan Master Role ada (Cek by Code)
                $subRole = SubRole::firstOrCreate(
                    ['sub_role_code' => $roleData['code']], 
                    [
                        'sub_role_name'    => $roleData['name'],
                        'sub_role_name_en' => $roleData['en'],
                        'created_at'       => $now,
                        'updated_at'       => $now,
                    ]
                );

                // 2. Hubungkan ke Activity (Insert Pivot)
                // Cek agar tidak duplicate entry di pivot table
                $exists = DB::table('activity_sub_roles')
                    ->where('student_activity_id', $activityId)
                    ->where('sub_role_id', $subRole->sub_role_id)
                    ->exists();

                if (!$exists) {
                    DB::table('activity_sub_roles')->insert([
                        'student_activity_id' => $activityId,
                        'sub_role_id'         => $subRole->sub_role_id,
                        'created_at'          => $now,
                        'updated_at'          => $now,
                    ]);
                }
            }
        }
        // ---------------------------------------------------------
        // 2. SEED ACTIVITY STRUCTURES (PANITIA) - SESUAI REQUEST
        // ---------------------------------------------------------
        
        // Ambil ID Dinamis berdasarkan Kode (Mapping dari request Anda)
        $idBPH       = SubRole::where('sub_role_code', 'SR01')->value('sub_role_id'); // BPH
        $idAcara     = SubRole::where('sub_role_code', 'SR02')->value('sub_role_id'); // Acara
        $idMedia     = SubRole::where('sub_role_code', 'SR03')->value('sub_role_id'); // Media
        $idLogistik  = SubRole::where('sub_role_code', 'SR04')->value('sub_role_id'); // Logistik
        $idKompetisi = SubRole::where('sub_role_code', 'SR06')->value('sub_role_id'); // Kompetisi

        // Ambil ID Activity (Integer)
        $act1Id = $act1->student_activity_id;
        $act2Id = $act2->student_activity_id;
        $act3Id = $act3->student_activity_id;
        $act4Id = $act4->student_activity_id;

        // ===== Activity 1 =====
        DB::table('activity_structures')->insert([
            ['student_activity_id' => $act1Id, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => $idBPH,      'structure_name' => 'Project Manager', 'structure_points' => 0, 'created_at' => $now],
            ['student_activity_id' => $act1Id, 'student_id' => 5, 'student_role_id' => 2, 'sub_role_id' => $idBPH,      'structure_name' => 'Main Secretary',  'structure_points' => 0, 'created_at' => $now],
            ['student_activity_id' => $act1Id, 'student_id' => 2, 'student_role_id' => 4, 'sub_role_id' => $idAcara,    'structure_name' => 'Head of Event',   'structure_points' => 0, 'created_at' => $now],
            ['student_activity_id' => $act1Id, 'student_id' => 3, 'student_role_id' => 4, 'sub_role_id' => $idMedia,    'structure_name' => 'Head of Media',   'structure_points' => 0, 'created_at' => $now],
            ['student_activity_id' => $act1Id, 'student_id' => 6, 'student_role_id' => 3, 'sub_role_id' => $idLogistik, 'structure_name' => 'Logistics Staff', 'structure_points' => 0, 'created_at' => $now],
        ]);

        // ===== Activity 2 (Dengan Nilai & Review) =====
        // Note: Mapping ID lama 5 -> SR01(BPH), 6 -> SR02(Acara), 8 -> SR04(Logistik)
        DB::table('activity_structures')->insert([
            [
                'student_activity_id' => $act2Id, 
                'student_id' => 1, 
                'student_role_id' => 1, 
                'sub_role_id' => $idBPH, // ID 5 (BPH)
                'structure_name' => 'Director', 
                'structure_points' => 200, 
                'final_point_percentage' => 100, 
                'final_review' => 'Perfect', 
                'created_at' => $now
            ],
            [
                'student_activity_id' => $act2Id, 
                'student_id' => 8, 
                'student_role_id' => 4, 
                'sub_role_id' => $idAcara, // ID 6 (Acara)
                'structure_name' => 'Event Coor', 
                'structure_points' => 150, 
                'final_point_percentage' => 80, 
                'final_review' => 'Good', 
                'created_at' => $now
            ],
            [
                'student_activity_id' => $act2Id, 
                'student_id' => 9, 
                'student_role_id' => 3, 
                'sub_role_id' => $idLogistik, // ID 8 (Logistik)
                'structure_name' => 'Staff', 
                'structure_points' => 100, 
                'final_point_percentage' => 50, 
                'final_review' => 'Absent', 
                'created_at' => $now
            ],
        ]);

        // ===== Activity 3 =====
        // Note: Mapping ID lama 9 -> SR01(BPH), 10 -> SR06(Kompetisi)
        DB::table('activity_structures')->insert([
            ['student_activity_id' => $act3Id, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => $idBPH,       'structure_name' => 'Chief',       'structure_points' => 0, 'created_at' => $now],
            ['student_activity_id' => $act3Id, 'student_id' => 7, 'student_role_id' => 4, 'sub_role_id' => $idKompetisi, 'structure_name' => 'Game Master', 'structure_points' => 0, 'created_at' => $now],
        ]);

        // ===== Activity 4 =====
        // Note: Mapping ID lama 11 -> SR01(BPH)
        DB::table('activity_structures')->insert([
            ['student_activity_id' => $act4Id, 'student_id' => 10, 'student_role_id' => 1, 'sub_role_id' => $idBPH, 'structure_name' => 'Project Lead', 'structure_points' => 0, 'created_at' => $now],
        ]);
    }
}