<?php

namespace App\Http\Controllers;

use App\Models\ActivityStructure;
use App\Models\ActivitySchedule;
use App\Models\RecruitmentAnswer;
use App\Models\Proposal;
use App\Models\RecruitmentDecision;
use App\Models\RecruitmentQuestion;
use App\Models\RecruitmentRegistration;
use App\Models\StudentActivity;
use App\Models\StudentRole;
use App\Models\StudentOrganization;
use App\Models\SubRole;
use App\Models\ActivitySubRole;
use App\Models\StudentRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PanitiaController extends Controller
{
    // Tahap siswa umum
    public function dashboard()
    {
        $studentId = Auth::user()->student->student_id;
        $jumAcara = StudentActivity::with('members')->whereHas('members', function ($query) use ($studentId) {
            $query->where('activity_structures.student_id', $studentId);
        })
            ->
            where('status', '!=', 'finished')->count();
        $registrationData = RecruitmentRegistration::where('student_id', Auth::user()->student->student_id)->get();
        $registrationData->transform(function ($registration) {
            if ($registration->status === 'accepted') {
                // Cek ke tabel activity_structure
                // Asumsi: Kamu punya Model 'ActivityStructure' dan foreign key yang relevan
                $isListed = ActivityStructure::where('student_id', $registration->student_id)
                    ->where('recruitment_registration_id', $registration->id) // Atau activity_id yang sesuai
                    ->exists();

                // JIKA status accepted TAPI tidak ada di structure, ubah jadi pending (hanya untuk tampilan ini)
                if (!$isListed) {
                    $registration->status = 'pending';
                }
            }

            return $registration;
        });
        $jumPendaftaran = $registrationData->where('status', 'pending')->count();
        $interviewList = StudentActivity::with('members')->whereHas('members', function ($query) use ($studentId) {
            $query->where('activity_structures.student_id', $studentId);
        })
            ->
            where('status', 'interview')->get();
        return view('siswa.dashboard', compact('jumAcara', 'jumPendaftaran', 'interviewList'));
    }
    public function profile()
    {
        return view('siswa.profile');
    }

    /**
     * Store: Menambahkan Divisi ke Acara (Insert ke tabel activity_sub_roles)
     */
    public function storeActivitySubRole(Request $request, $activityCode)
    {
        $request->validate([
            'sub_role_id' => 'required|exists:sub_roles,sub_role_id',
        ]);

        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        // Cek duplikasi (optional, karena sudah difilter di view, tapi bagus untuk security)
        $exists = ActivitySubRole::where('student_activity_id', $activity->student_activity_id)
            ->where('sub_role_id', $request->sub_role_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Divisi tersebut sudah ada di acara ini.');
        }

        // Simpan ke Pivot Table
        ActivitySubRole::create([
            'student_activity_id' => $activity->student_activity_id,
            'sub_role_id' => $request->sub_role_id
        ]);

        return back()->with('success', 'Divisi berhasil ditambahkan ke acara.');
    }

    public function daftarAcara()
    {
        $studentId = Auth::user()->student->student_id;

        $acara = StudentActivity::with('members', 'registrations') // Optional: Eager load members if you need to display them
            ->whereDoesntHave('members', function ($query) use ($studentId) {
                $query->where('activity_structures.student_id', $studentId);
            })
            ->whereDoesntHave('registrations', function ($query) use ($studentId) {
                $query
                    ->where('recruitment_registrations.student_id', $studentId);
            })
            ->where('status', 'open_recruitment')
            ->get();
        return view('siswa.daftar-acara', compact('acara'));
    }

    public function formPendaftaran($studentActivityId)
    {
        $activity = StudentActivity::findOrFail($studentActivityId);
        // $divisi = SubRole::whereNot('sub_role_name', 'BPH')->get();
        $divisi = SubRole::join('activity_sub_roles', 'sub_roles.sub_role_id', '=', 'activity_sub_roles.sub_role_id')
            ->where('activity_sub_roles.student_activity_id', $studentActivityId)
            ->whereNull('activity_sub_roles.deleted_at') // Cek soft delete pivot
            ->where('sub_roles.sub_role_name', '!=', 'BPH') // <--- Filter exclude BPH
            ->select('sub_roles.*')
            ->get();

        return view('siswa.form-pendaftaran', compact('activity', 'divisi'));
    }
    public function daftarKepanitiaan(Request $request, $studentActivityId)
    {
        $validated = $request->validate([
            "choice_1_sub_role_id" => 'required|exists:sub_roles,sub_role_id',
            "reason_1" => "required|string",
            "choice_2_sub_role_id" => 'nullable|integer',
            "reason_2" => 'nullable|string',
        ]);
        $validated["status"] = "pending";
        $validated["student_activity_id"] = $studentActivityId;
        $validated["student_id"] = Auth::user()->student->student_id;
        RecruitmentRegistration::firstOrCreate($validated);
        return redirect()->route('siswa.status-pendaftaran')->with("success", "Berhasil daftar!");
    }

    public function statusPendaftaran()
    {
        $data = RecruitmentRegistration::with('activityDetail', 'firstChoice', 'secondChoice')->where('student_id', Auth::user()->student->student_id)->get();
        $data->transform(function ($registration) {
            if ($registration->status === 'accepted') {
                // Cek ke tabel activity_structure
                // Asumsi: Kamu punya Model 'ActivityStructure' dan foreign key yang relevan
                $isListed = ActivityStructure::where('student_id', $registration->student_id)
                    ->where('recruitment_registration_id', $registration->id) // Atau activity_id yang sesuai
                    ->exists();

                // JIKA status accepted TAPI tidak ada di structure, ubah jadi pending (hanya untuk tampilan ini)
                if (!$isListed) {
                    $registration->status = 'pending';
                }
            }

            return $registration;
        });
        return view('siswa.status-pendaftaran', compact('data'));
    }

    public function statusProposal()
    {
        // 1. Ambil ID Student dari User yang login
        $studentId = Auth::user()->student->student_id;

        // 2. Ambil Proposal milik student tersebut
        // Menggunakan 'with' agar query efisien (Eager Loading organisasi)
        $proposals = Proposal::with('studentOrganization')
                        ->where('student_id', $studentId)
                        ->orderBy('created_at', 'desc') // Urutkan dari yang terbaru
                        ->get();
        return view('siswa.status-proposal', compact('proposals'));
    }

    public function proposalAjukan()
    {
        // Ambil semua data organisasi
        $organizations = StudentOrganization::all();

        return view('siswa.proposal-ajukan', compact('organizations'));
    }
    public function storeProposal(Request $request)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'student_organization_id' => 'required|exists:student_organizations,student_organization_id',
            // Tanggal wajib diisi sesuai schema database
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after_or_equal:start_datetime',
        ]);

        // 2. Tambahkan ID Mahasiswa yang sedang login
        // Asumsi: User yang login terhubung ke tabel students
        // Sesuaikan 'student' dengan nama relasi di model User Anda
        $validated['student_id'] = Auth::user()->student->student_id; 
        
        // Set status default
        $validated['status'] = 'pending';

        // 3. Simpan ke Database
        Proposal::create($validated);

        // 4. Redirect dengan pesan sukses
        return redirect()->route('siswa.proposal-ajukan')->with('success', 'Proposal berhasil diajukan dan menunggu persetujuan.');
    }

    // Panitia (umum)
    public function panitiaDashboard()
    {
        $studentId = Auth::user()->student->student_id;
        $acara = StudentActivity::with('members')->whereHas('members', function ($query) use ($studentId) {
            $query->where('activity_structures.student_id', $studentId);
        })
            ->
            where('status', '!=', 'finished')->get();
        return view('siswa.panitia-dashboard', compact('acara'));
    }
    public function panitiaDashboardInterview()
    {
        $studentId = Auth::user()->student->student_id;
        $acara = StudentActivity::with('members')->whereHas('members', function ($query) use ($studentId) {
            $query->where('activity_structures.student_id', $studentId);
        })
            ->
            where('status', 'interview')->get();
        return view('siswa.panitia-dashboard-interview', compact('acara'));
    }

    public function panitiaDetail($activityCode)
    {
        $studentId = Auth::user()->student->student_id;
        $activity = StudentActivity::where('activity_code', operator: $activityCode)->first();
        $panitia = ActivityStructure::with(['activity', 'student', 'role', 'subRole']) // Load both relationships
            ->whereHas('activity', function ($query) use ($activityCode) {
                $query->where('activity_code', $activityCode);
            })
            ->get();
        $existingRatings = StudentRating::where('student_activity_id', $activity->student_activity_id)
            ->where('rater_student_id', $studentId)
            ->get()
            ->keyBy('rated_student_id');

        $jadwal = ActivitySchedule::where('student_activity_id', $activity->student_activity_id)
            ->orderBy('start_time', 'asc')
            ->get();
        $listPendaftar = RecruitmentRegistration::with(['student', 'firstChoice', 'secondChoice', 'decisions'])->get();

        if ($activity->status == "preparation") {
            $listDivisi = SubRole::all();

            $panitiaList = ActivityStructure::with(['student', 'role', 'subRole'])
                ->where('student_activity_id', $activity->student_activity_id)
                ->get();

            $roles = StudentRole::all();

            $currentDivisions = ActivitySubRole::with('subRole')
                ->where('student_activity_id', $activity->student_activity_id)
                ->get();

            // B. Ambil ID divisi yang sudah terpakai
            $usedSubRoleIds = $currentDivisions->pluck('sub_role_id')->toArray();

            // C. Ambil Divisi Master yang BELUM dipakai (Untuk Dropdown)
            $availableSubRoles = SubRole::whereNotIn('sub_role_id', $usedSubRoleIds)->get();

            // Variabel $subRoles (untuk dropdown di tab Struktur) sebaiknya diambil dari yang sudah diassign
            // Kita map agar bentuknya collection SubRole, bukan ActivitySubRole
            $subRoles = $currentDivisions->map(function ($item) {
                return $item->subRole;
            });

            $user = Auth::user();
            $roleCode = ActivityStructure::where('student_activity_id', $activity->student_activity_id)
            ->where('student_id', $user->student->student_id)
            ->with('role')
            ->firstOrFail()
            ->role->role_code; // Mengakses langsung property dari relasi
            return view('siswa.preparation.dashboard', compact('activity', 'panitia', 'jadwal', 'existingRatings', 'listDivisi', 'panitiaList', 'roles', 'currentDivisions', 'availableSubRoles', 'subRoles','roleCode'));
        }
        $currUserInActivity = ActivityStructure::with(['activity', 'student', 'role', 'subRole']) // Load both relationships
            ->whereHas('activity', function ($query) use ($activityCode) {
                $query->where('activity_code', $activityCode);
            })
            ->where('student_id', $studentId)
            ->firstOrFail();
        return view('siswa.panitia-detail', compact('activity', 'panitia', 'jadwal', 'existingRatings', 'currUserInActivity'));
    }
    public function panitiaChat()
    {
        return view('siswa.chat');
    }


    public function updateInterviewDate(Request $request, $activityCode)
    {
        // 1. Validasi Input
        $request->validate([
            'interview_date'     => 'required|date',
            'interview_location' => 'nullable|string|max:255', // Validasi kolom baru
        ]);

        // 2. Cari Data berdasarkan Activity Code
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();
        
        // 3. Update Data
        $activity->interview_date = $request->interview_date;
        $activity->interview_location = $request->interview_location; // Simpan lokasi

        // 4. Logika Opsional Update Status
        if ($request->has('update_status') && $activity->status != 'interview') {
            $activity->status = 'interview';
        }

        $activity->save();

        return back()->with('success', 'Jadwal dan lokasi interview berhasil disimpan!');
    }
    public function panitiaPengurus($activityCode)
    {
        $dataPanitia = ActivityStructure::with(['activity', 'student', 'role', 'subRole']) // Load both relationships
            ->whereHas('activity', function ($query) use ($activityCode) {
                $query->where('activity_code', $activityCode);
            })
            ->get();
        $activity = StudentActivity::where('activity_code', $activityCode)->first();
        $listJabatan = StudentRole::all();
        // 1. Ambil Daftar Semua Panitia di acara ini
        $panitiaList = ActivityStructure::with(['student', 'role', 'subRole'])
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        // 2. Ambil Semua Rating di acara ini, lalu Grouping berdasarkan ID orang yang dinilai
        $allRatings = StudentRating::with('rater') // Load data penilai
            ->where('student_activity_id', $activity->student_activity_id)
            ->get()
            ->groupBy('rated_student_id'); // Kelompokkan per mahasiswa yang dinilai
        $listDivisi = SubRole::all();
        $roles = StudentRole::all();
        $studentActivityId = $activity->student_activity_id;
        // $listPertanyaanUntukDivisi = SubRole::with([
        //     'activityQuestions' => function ($query) use ($studentActivityId) {
        //         // This logic only affects the questions attached, not the SubRole itself
        //         $query->where('student_activity_id', $studentActivityId);
        //     }
        // ])->get();
        $listPertanyaanUntukDivisi = SubRole::join('activity_sub_roles', 'sub_roles.sub_role_id', '=', 'activity_sub_roles.sub_role_id')
            ->where('activity_sub_roles.student_activity_id', $studentActivityId)
            ->whereNull('activity_sub_roles.deleted_at') // Cek soft delete jika ada
            ->with([
                'activityQuestions' => function ($query) use ($studentActivityId) {
                    // Filter pertanyaan agar spesifik ke acara ini juga
                    $query->where('student_activity_id', $studentActivityId);
                }
            ])
            ->select('sub_roles.*') // PENTING: Agar hasil query tetap berupa model SubRole (menghindari tumpang tindih ID)
            ->get();
        $listPendaftar = RecruitmentRegistration::with(['student', 'firstChoice', 'secondChoice', 'decisions'])->get();

        // ==========================================
        // UPDATE LOGIKA DIVISI (SUB ROLE)
        // ==========================================

        // A. Ambil Divisi yang SUDAH ada di acara ini (dari tabel pivot)
        // Kita load relasi 'subRole' untuk mengambil nama divisinya
        $currentDivisions = ActivitySubRole::with('subRole')
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        // B. Ambil ID divisi yang sudah terpakai
        $usedSubRoleIds = $currentDivisions->pluck('sub_role_id')->toArray();

        // C. Ambil Divisi Master yang BELUM dipakai (Untuk Dropdown)
        $availableSubRoles = SubRole::whereNotIn('sub_role_id', $usedSubRoleIds)->get();

        // Variabel $subRoles (untuk dropdown di tab Struktur) sebaiknya diambil dari yang sudah diassign
        // Kita map agar bentuknya collection SubRole, bukan ActivitySubRole
        $subRoles = $currentDivisions->map(function ($item) {
            return $item->subRole;
        });

        $user = Auth::user();
        $roleCode = ActivityStructure::where('student_activity_id', $activity->student_activity_id)
        ->where('student_id', $user->student->student_id)
        ->with('role')
        ->firstOrFail()
        ->role->role_code; // Mengakses langsung property dari relasi
       

        return view('siswa.pengurus-inti', compact('activity', 'dataPanitia', 'listDivisi', 'listPertanyaanUntukDivisi', 'panitiaList', 'allRatings', 'roles', 'listPendaftar', 'currentDivisions', 'subRoles', 'availableSubRoles', 'roleCode'));
    }

    public function kickMember($structureId)
    {
        // Cari data di tabel struktur
        $member = ActivityStructure::with('role')->findOrFail($structureId);


        // Security Check: Jangan sampai Ketua dikeluarkan
        if ($member->role && $member->role->role_name === 'Team Lead') {
            return back()->with('error', 'Ketua Panitia tidak dapat dikeluarkan.');
        }

        // Hapus (Pastikan Model ActivityStructure menggunakan SoftDeletes)
        $member->delete();

        return back()->with('success', 'Anggota berhasil dikeluarkan dari kepanitiaan.');
    }

    public function updateStructure(Request $request, $activityCode)
    {
        // 1. Validasi Input
        $request->validate([
            'updates' => 'required|array',
        ]);

        DB::beginTransaction();
        try {
            // 2. Loop setiap data yang dikirim dari form
            foreach ($request->updates as $structureId => $data) {

                // Ambil Role ID (Jabatan)
                $roleId = $data['role_id'];

                // Ambil Sub Role ID (Divisi)
                // Jika value kosong (pilih "-- Non-Divisi --" atau input hidden kosong dari Ketua), 
                // simpan sebagai NULL di database.
                $subRoleId = !empty($data['sub_role_id']) ? $data['sub_role_id'] : null;

                // 3. Update Database
                ActivityStructure::where('activity_structure_id', $structureId)
                    ->update([
                        'student_role_id' => $roleId,
                        'sub_role_id' => $subRoleId
                    ]);
            }

            DB::commit();
            return back()->with('success', 'Struktur kepanitiaan (Divisi & Jabatan) berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui struktur: ' . $e->getMessage());
        }
    }



    /**
     * Delete: Menghapus Divisi dari Acara (Soft Delete Pivot)
     */
    public function deleteActivitySubRole($id)
    {
        DB::transaction(function () use ($id) {
            // 1. Cari data pivot (Divisi Acara) yang mau dihapus
            $pivotItem = ActivitySubRole::findOrFail($id);

            // 2. Cari anggota di activity tersebut yang memegang divisi ini, lalu set jadi NULL
            ActivityStructure::where('student_activity_id', $pivotItem->student_activity_id)
                ->where('sub_role_id', $pivotItem->sub_role_id)
                ->update(['sub_role_id' => null]);

            // 3. Hapus Divisi dari Acara (Soft Delete)
            $pivotItem->delete();
        });

        return back()->with('success', 'Divisi berhasil dihapus. Anggota yang sebelumnya di divisi tersebut kini menjadi tanpa divisi (Inti).');
    }

    public function updateStatus(Request $request, $activityCode)
    {
        // 1. Validasi Input
        $request->validate([
            'status' => 'required|in:preparation,open_recruitment,interview,active,grading_1,grading_2,finished',
        ]);

        // 2. Ambil Data Activity
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        $oldStatus = $activity->status;
        $newStatus = $request->status;
        if ($newStatus === 'active' && $oldStatus === 'interview') {
            DB::beginTransaction();
            try {
                // A. Get Accepted Students
                $acceptedRegistrations = RecruitmentRegistration::where('student_activity_id', $activity->student_activity_id)
                    ->where('status', 'accepted')
                    ->get();

                // B. Get Role ID for "Anggota" (Member)
                $memberRole = StudentRole::where('role_code', 'MEBR')->first();
                $memberRoleId = $memberRole ? $memberRole->student_role_id : 3;

                // C. Loop and Create Structure
                foreach ($acceptedRegistrations as $registration) {

                    $finalSubRoleId = $registration->choice_1_sub_role_id;

                    // Safe fallback for division name
                    $divName = $registration->firstChoice->sub_role_name ?? 'Staff';

                    // Try to create the structure
                    ActivityStructure::firstOrCreate(
                        [
                            'student_activity_id' => $activity->student_activity_id,
                            'student_id' => $registration->student_id,
                        ],
                        [
                            'student_role_id' => $memberRoleId,
                            'sub_role_id' => $finalSubRoleId,
                            'structure_name' => $divName,
                            'structure_points' => 0,
                        ]
                    );
                }

                // D. Update Status
                $activity->update(['status' => $newStatus]);

                // 2. Commit: If code reaches here without error, save everything
                DB::commit();

            } catch (\Exception $e) {
                // 3. Rollback: If ANY error happened above, undo changes
                DB::rollBack();

                // Optional: Log the exact error for debugging
                // Log::error("Failed to activate activity: " . $e->getMessage());

                // Return with error message
                return redirect()->back()->with('error', 'An error occurred while activating: ' . $e->getMessage());
            }
        }
        // 3. LOGIKA KHUSUS: Jika status yang dipilih adalah 'grading_2'
        // Maka jalankan Auto-Fill Rating sebelum update status
        else if ($request->status === 'grading_2') {

            DB::beginTransaction();
            try {
                // 1. Ambil semua ID mahasiswa yang jadi panitia di acara ini
                $memberIds = ActivityStructure::where('student_activity_id', $activity->student_activity_id)
                    ->pluck('student_id');

                // 2. AUTO-FILL RATING (Looping Ganda)
                // Setiap anggota harus menilai setiap anggota lain
                foreach ($memberIds as $raterId) {       // Si Penilai
                    foreach ($memberIds as $ratedId) {   // Yang Dinilai

                        // Skip jika orang yang sama (tidak menilai diri sendiri)
                        if ($raterId == $ratedId)
                            continue;

                        // Cek & Isi Otomatis dengan Default Bintang 4
                        StudentRating::firstOrCreate(
                            [
                                'student_activity_id' => $activity->student_activity_id,
                                'rater_student_id' => $raterId,
                                'rated_student_id' => $ratedId,
                            ],
                            [
                                'stars' => 4,
                                'reason' => 'No Comment (Auto-filled)',
                            ]
                        );
                    }
                }

                // 3. HITUNG & UPDATE NILAI AKHIR (Logic Baru)
                // Setelah auto-fill selesai, kita hitung rata-rata rating untuk setiap anggota
                foreach ($memberIds as $studentId) {

                    // Hitung rata-rata 'stars' yang diterima oleh student ini
                    // Contoh: Rata-rata 3.5 Bintang
                    $averageRating = StudentRating::where('student_activity_id', $activity->student_activity_id)
                        ->where('rated_student_id', $studentId)
                        ->avg('stars');

                    // Konversi ke Skala 100 (1 Bintang = 25 Poin)
                    // Rumus: Rata-rata * 25
                    // Contoh: 3.5 * 25 = 87.5 Poin
                    $finalScore = $averageRating ? round($averageRating * 25) : 0;

                    // Update tabel ActivityStructure
                    // Simpan rata-rata ke kolom final_point_percentage (sesuai schema migrasi tipe float)
                    ActivityStructure::where('student_activity_id', $activity->student_activity_id)
                        ->where('student_id', $studentId)
                        ->update([
                            'final_point_percentage' => $finalScore,
                            // Opsional: Jika ingin memberi catatan otomatis pada review ketua
                            // 'final_review' => 'Nilai dikalkulasi otomatis sistem.' 
                        ]);
                }

                // Update status aktivitas
                $activity->status = 'grading_2';
                $activity->save();

                DB::commit();

                return back()->with('success', 'Status berhasil diubah ke Final Grading. Nilai akhir anggota telah dikalkulasi.');

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'Gagal memproses Grading 2: ' . $e->getMessage());
            }
        }

        // 4. Update Status ke Database
        $activity->update([
            'status' => $request->status
        ]);

        $statusLabels = [
            'preparation' => 'Preparation',
            'open_recruitment' => 'Open Recruitment',
            'interview' => 'Interview',
            'active' => 'Active',
            'grading_1' => 'Start Grading',   // <--- Sesuai Request
            'grading_2' => 'Final Grading',   // <--- Sesuai Request
            'finished' => 'Finished',
        ];

        // Ambil label berdasarkan status yg dipilih (default ke teks asli jika tidak ada di list)
        $statusName = $statusLabels[$request->status] ?? ucfirst($request->status);

        $message = 'Status timeline berhasil diperbarui menjadi: ' . $statusName;

        // Tambahan pesan jika masuk ke Final Grading
        if ($request->status === 'grading_2') {
            $message .= '. Sistem otomatis mengisi rating kosong dengan nilai default.';
        }

        if ($request->status === 'preparation') {
            return redirect()->route('siswa.panitia-detail', $activityCode)->with('success', $message);
        }

        return back()->with('success', $message);
    }

    public function saveGrading(Request $request, $activityCode)
    {
        // Validasi input
        $request->validate([
            'grading' => 'required|array',
            'grading.*.percentage' => 'required|numeric|min:0|max:100',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->grading as $structureId => $data) {

                // 1. Ambil array alasan dari checkbox
                $selectedReasons = $data['reasons'] ?? [];

                // Jika ada review manual, tambahkan ke array
                if (!empty($data['manual_review'])) {
                    $selectedReasons[] = $data['manual_review'];
                }

                // 2. Gabungkan menjadi satu string dengan ENTER (\n) sebagai pemisah
                // Ini akan membuat setiap alasan berada di baris baru
                $finalReviewText = implode("\n", $selectedReasons);

                // 3. Update Database
                ActivityStructure::where('activity_structure_id', $structureId)->update([
                    'final_point_percentage' => $data['percentage'],
                    'final_review' => $finalReviewText
                ]);
            }

            DB::commit();
            return back()->with('success', 'Keputusan grading berhasil disimpan! Data telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat menyimpan: ' . $e->getMessage());
        }
    }

    public function tambahPertanyaan(Request $request, $activityCode)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'sub_role_id' => 'required',
            'student_activity_id' => 'required'
        ]);
        $newQuestion = RecruitmentQuestion::create($validated);

        return back()->with('success', 'Berhasil menambah pertanyaan');
    }



    public function panitiaJadwal()
    {
        return view('siswa.panitia-jadwal');
    }

    public function panitiaTask()
    {
        return view('siswa.panitia-task');
    }

    public function riwayatAcara()
    {
        // 1. Ambil ID Siswa Login
        $studentId = Auth::user()->student->student_id;

        // 2. Ambil Riwayat Kepanitiaan (HANYA YANG FINISHED)
        $histories = ActivityStructure::with(['activity', 'role', 'subRole'])
            ->where('student_id', $studentId)
            ->whereHas('activity', function ($q) {
                // vvv TAMBAHKAN FILTER INI vvv
                $q->where('status', 'finished')
                    ->orderBy('start_datetime', 'desc');
            })
            ->get();

        // 3. Hitung Nilai KPI (Rata-rata Bintang) per Acara
        foreach ($histories as $h) {
            $avgStars = StudentRating::where('student_activity_id', $h->student_activity_id)
                ->where('rated_student_id', $studentId)
                ->avg('stars');

            $h->kpi_score = $avgStars ? number_format($avgStars, 1) : 0;
        }

        // 4. Hitung Statistik Keseluruhan
        $scoredActivities = $histories->where('kpi_score', '>', 0);
        $overallKpi = $scoredActivities->count() > 0 ? number_format($scoredActivities->avg('kpi_score'), 1) : '0.0';
        $totalEvent = $histories->count();

        return view('siswa.riwayat-acara', compact('histories', 'overallKpi', 'totalEvent'));
    }

    public function saveEvaluasi(Request $request, $activityCode)
    {
        // 1. Validasi Input
        $request->validate([
            'evaluations' => 'required|array',
            'evaluations.*.stars' => 'required|integer|min:1|max:4',
            'evaluations.*.reason' => 'required|string|min:3',
        ]);

        // 2. Ambil Data Pendukung
        $user = Auth::user();

        // Pastikan user terhubung ke data student
        if (!$user->student) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        $raterId = $user->student->student_id;

        // Cari Activity ID berdasarkan Code
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        // 3. Proses Penyimpanan (Gunakan Transaction biar aman)
        DB::beginTransaction();
        try {
            foreach ($request->evaluations as $ratedStudentId => $data) {

                // Skip jika menilai diri sendiri (Double check backend side)
                if ($ratedStudentId == $raterId)
                    continue;

                StudentRating::updateOrCreate(
                    [
                        // Kunci pencarian (agar tidak duplikat)
                        'student_activity_id' => $activity->student_activity_id,
                        'rater_student_id' => $raterId,           // Penilai (Saya)
                        'rated_student_id' => $ratedStudentId,    // Yang Dinilai (Teman)
                    ],
                    [
                        // Data yang diupdate/insert
                        'stars' => $data['stars'],
                        'reason' => $data['reason'],
                    ]
                );
            }

            DB::commit();
            return back()->with('success', 'Terima kasih! Evaluasi rekan kerja berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showMembers($activityCode)
    {
        // 1. Ambil data Activity (Acara) itu sendiri
        // Tambahkan ->firstOrFail() untuk eksekusi query & throw 404 jika tidak ketemu
        $activity = StudentActivity::where("activity_code", $activityCode)->firstOrFail();

        $user = Auth::user();
        $roleCode = ActivityStructure::where('student_activity_id', $activity->student_activity_id)
        ->where('student_id', $user->student->student_id)
        ->with('role')
        ->firstOrFail()
        ->role->role_code; // Mengakses langsung property dari relasi

        // 2. Ambil daftar anggota dari tabel ActivityStructure
        $members = ActivityStructure::with(['student', 'role', 'subRole'])
            ->where('student_activity_id', $activity->student_activity_id)
            ->get();

        // 3. Kembalikan ke view
        return view('siswa.members', compact('activity', 'members', 'roleCode'));
    }

}