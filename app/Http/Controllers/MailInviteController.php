<?php

namespace App\Http\Controllers;

use App\Models\MailInvite;
use App\Models\ActivityStructure;
use App\Models\ActivitySchedule;
use App\Models\RecruitmentAnswer;
use App\Models\RecruitmentDecision;
use App\Models\RecruitmentQuestion;
use App\Models\RecruitmentRegistration;
use App\Models\StudentActivity;
use App\Models\StudentRole;
use App\Models\Student;
use App\Models\StudentOrganization;
use App\Models\SubRole;
use App\Models\StudentRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MailInviteController extends Controller
{
    public function index()
    {
        // Assuming the User model has a 'student_number' column
        // If your logic is different (e.g., User->student->student_number), adjust accordingly.
        $userStudentNumber = Auth::user()->student_number;

        $invites = MailInvite::with('activity') // Eager load activity details
            ->where('student_number', $userStudentNumber)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.invites', compact('invites'));
    }

    public function respond(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:accept,decline',
        ]);

        $invite = MailInvite::findOrFail($id);

        // Security Check: Ensure current user owns this invite
        if ($invite->student_number !== Auth::user()->student_number) {
            abort(403, 'Unauthorized action.');
        }

        $invite->update([
            'status' => $request->status,
        ]);

        if ($request->status === 'accept') {
            // Cari data student berdasarkan NIM dari invite
                $student = Student::where('student_number', $invite->student_number)->firstOrFail();

                // Cari Role Default (Misal: "Anggota")
                // Jika tidak ada role 'Anggota', fallback ke ID 1 (sesuaikan dengan seeder Anda)
                // $defaultRole = StudentRole::where('role_name', 'Anggota')->first();
                // $roleId = $defaultRole ? $defaultRole->student_role_id : 1; 

                // Simpan ke tabel kepanitiaan
                ActivityStructure::firstOrCreate(
                    [
                        'student_activity_id' => $invite->student_activity_id,
                        'student_id'          => $student->student_id,
                    ],
                    [
                        'student_role_id'     => null, // Default: Anggota
                        'sub_role_id'         => null,    // Default: Belum ada divisi (bisa diatur ketua nanti)
                        'structure_name'      => 'Member via Invitation',
                    ]
                );
        }

        $message = $request->status === 'accept' ? 'Invitation accepted!' : 'Invitation declined.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * API: Cari Mahasiswa berdasarkan NRP
     */
    public function searchStudent(Request $request)
    {
        if ($request->has('q')) {
            $student = Student::where('student_number', $request->q)->first();
            
            if ($student) {
                return response()->json([
                    'status' => 'success',
                    'data' => $student
                ]);
            }
        }
        
        return response()->json(['status' => 'not_found'], 404);
    }

    /**
     * Store: Simpan Undangan Baru
     */
    public function storeInvite(Request $request, $activityCode)
    {
        // 1. Validasi ID (Form tetap mengirim student_id karena itu primary key tabel students)
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
        ]);

        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();
        
        // 2. AMBIL DATA MAHASISWA
        // Kita butuh object mahasiswa untuk mendapatkan 'student_number' (NIM)-nya
        $student = Student::findOrFail($request->student_id);

        // 3. CEK INVITE (MODIFIKASI LOGIKA)
        // Cek apakah mahasiswa ini sedang dalam status 'pending' atau sudah 'accept'
        // Jika status sebelumnya 'decline', query ini tidak akan menemukannya (false), sehingga bisa di-invite lagi.
        $existingInvite = MailInvite::where('student_number', $student->student_number) 
            ->where('student_activity_id', $activity->student_activity_id)
            ->whereIn('status', ['pending', 'accept']) 
            ->exists();

        // 4. CEK MEMBER AKTIF
        // Cek di activity_structures (tabel ini pakai student_id, jadi tidak perlu diubah)
        $isMember = ActivityStructure::where('student_id', $student->student_id)
            ->where('student_activity_id', $activity->student_activity_id)
            ->exists();

        if ($existingInvite) {
            return back()->with('error', 'Mahasiswa ini sedang diundang (Pending) atau sudah menerima (Accept).');
        }

        if ($isMember) {
            return back()->with('error', 'Mahasiswa ini sudah menjadi panitia.');
        }

        // 5. SIMPAN INVITE (PERBAIKAN DISINI)
        MailInvite::create([
            'student_number'      => $student->student_number, // <--- Gunakan NIM
            'student_activity_id' => $activity->student_activity_id,
            'status'              => 'pending'
        ]);

        return back()->with('success', 'Undangan berhasil dikirim ke ' . $student->full_name);
    }
}
