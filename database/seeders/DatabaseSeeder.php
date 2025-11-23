<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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

        DB::table('sub_roles')->insert([
            ['sub_role_id' => 1, 'sub_role_code' => 'SR01', 'sub_role_name' => 'BPH', 'sub_role_name_en' => 'Main Board'],
            ['sub_role_id' => 2, 'sub_role_code' => 'SR02', 'sub_role_name' => 'Acara', 'sub_role_name_en' => 'Event'],
            ['sub_role_id' => 3, 'sub_role_code' => 'SR03', 'sub_role_name' => 'Media', 'sub_role_name_en' => 'Media'],
            ['sub_role_id' => 4, 'sub_role_code' => 'SR04', 'sub_role_name' => 'Logistik', 'sub_role_name_en' => 'Logistics'],
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
        // PHASE 4: ACTIVITIES & STRUCTURES
        // ==========================================

        // --- ACTIVITY 1: ACTIVE (Tech Summit) ---
        // Leader: Iris (1)
        // Status: Active
        // Members: 5 Total (Lead, Sec, Coor Acara, Coor Media, Member Logistik)

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

        DB::table('activity_structures')->insert([
            // 1. Leader (Iris - S1)
            ['student_activity_id' => $act1, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => 1, 'structure_name' => 'Project Manager', 'structure_points' => 0, 'created_at' => now()],
            // 2. Secretary (Nina - S5)
            ['student_activity_id' => $act1, 'student_id' => 5, 'student_role_id' => 2, 'sub_role_id' => 1, 'structure_name' => 'Main Secretary', 'structure_points' => 0, 'created_at' => now()],
            // 3. Coordinator Acara (Mateo - S2)
            ['student_activity_id' => $act1, 'student_id' => 2, 'student_role_id' => 4, 'sub_role_id' => 2, 'structure_name' => 'Head of Event', 'structure_points' => 0, 'created_at' => now()],
            // 4. Coordinator Media (Sora - S3)
            ['student_activity_id' => $act1, 'student_id' => 3, 'student_role_id' => 4, 'sub_role_id' => 3, 'structure_name' => 'Head of Media', 'structure_points' => 0, 'created_at' => now()],
            // 5. Member Logistik (Arlo - S6)
            ['student_activity_id' => $act1, 'student_id' => 6, 'student_role_id' => 3, 'sub_role_id' => 4, 'structure_name' => 'Logistics Staff', 'structure_points' => 0, 'created_at' => now()],
        ]);

        // --- ACTIVITY 2: FINISHED (Art Gala) ---
        // Leader: Iris (1) - SAME AS ABOVE
        // Status: Finished
        // Has Ratings & Final Points

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

        DB::table('activity_structures')->insert([
            // Leader Iris (100% Score)
            ['student_activity_id' => $act2, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => 1, 'structure_name' => 'Director', 'structure_points' => 200, 'final_point_percentage' => 100, 'final_review' => 'Perfect execution', 'created_at' => now()],
            // Coor Acara Finn (S8) (80% Score)
            ['student_activity_id' => $act2, 'student_id' => 8, 'student_role_id' => 4, 'sub_role_id' => 2, 'structure_name' => 'Event Coor', 'structure_points' => 150, 'final_point_percentage' => 80, 'final_review' => 'Good but late sometimes', 'created_at' => now()],
            // Member Gwen (S9) (50% Score)
            ['student_activity_id' => $act2, 'student_id' => 9, 'student_role_id' => 3, 'sub_role_id' => 4, 'structure_name' => 'Staff', 'structure_points' => 100, 'final_point_percentage' => 50, 'final_review' => 'Rarely attended', 'created_at' => now()],
        ]);

        // Add Ratings for Activity 2
        DB::table('student_ratings')->insert([
            ['student_activity_id' => $act2, 'rater_student_id' => 8, 'rated_student_id' => 1, 'stars' => 4, 'reason' => 'Great leader', 'created_at' => now()],
            ['student_activity_id' => $act2, 'rater_student_id' => 1, 'rated_student_id' => 8, 'stars' => 4, 'reason' => 'Good work', 'created_at' => now()],
        ]);

        // --- ACTIVITY 3: PREPARATION / BLANK (Esports Cup) ---
        // Leader: Riku (4)
        // Status: Preparation
        // 1 Leader, 1 Coordinator

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

        DB::table('activity_structures')->insert([
            // Leader Riku
            ['student_activity_id' => $act3, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => 1, 'structure_name' => 'Chief', 'structure_points' => 0, 'created_at' => now()],
            // Coor Lila (S7)
            ['student_activity_id' => $act3, 'student_id' => 7, 'student_role_id' => 4, 'sub_role_id' => 2, 'structure_name' => 'Game Master', 'structure_points' => 0, 'created_at' => now()],
        ]);

        // --- ACTIVITY 4: OPEN RECRUITMENT (Music Fest) ---
        // Leader: Miles (10)
        // Status: Open Recruitment
        // 0 Registrations

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

        // Structure: Only Leader exists so far
        DB::table('activity_structures')->insert([
            ['student_activity_id' => $act4, 'student_id' => 1, 'student_role_id' => 1, 'sub_role_id' => 1, 'structure_name' => 'Project Lead', 'structure_points' => 0, 'created_at' => now()],
        ]);

        // Questions for Open Recruitment (so it's functional)
        DB::table('recruitment_questions')->insert([
            ['student_activity_id' => $act4, 'sub_role_id' => 2, 'question' => 'Why do you like music?'],
            ['student_activity_id' => $act4, 'sub_role_id' => 3, 'question' => 'Can you edit videos?'],
        ]);

        // NO registrations inserted for Act 4.
    }
}