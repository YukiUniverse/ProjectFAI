<?php

namespace App\Http\Controllers;

use App\Models\ActivityStructure;
use App\Models\RecruitmentAnswer;
use App\Models\RecruitmentDecision;
use App\Models\RecruitmentRegistration;
use App\Models\StudentActivity;
use App\Models\StudentRating;
use App\Models\SubRole;
use Auth;
use Illuminate\Http\Request;

class OpenRecruitmentController extends Controller
{
    //
    public function panitiaPendaftar($activityCode)
    {
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();
        $listPendaftar = RecruitmentRegistration::with(['student', 'firstChoice', 'secondChoice', 'decisions'])->where('student_activity_id', $activity->student_activity_id)->get();
        return view('siswa.oprec.list_pendaftar', compact('activity', 'listPendaftar'));
    }
    public function detailPendaftar($activityCode, $registrationID)
    {
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();
        $currentStudent = RecruitmentRegistration::with(['student', 'firstChoice', 'secondChoice', 'decisions'])->where('id', $registrationID)->first();
        $studentId = $currentStudent->student_id;

        $histories = ActivityStructure::with(['activity', 'role', 'subRole'])
            ->where('student_id', $studentId) // Adjust ID based on your relation
            ->whereHas('activity', function ($q) {
                $q->where('status', 'finished');
            })
            ->get()
            // Sort by the related activity's date
            ->sortByDesc(function ($structure) {
                return $structure->activity->start_datetime;
            })
            ->take(5);
        foreach ($histories as $h) {
            $avgStars = StudentRating::where('student_activity_id', $h->student_activity_id)
                ->where('rated_student_id', $studentId)
                ->avg('stars');

            $h->kpi_score = $avgStars ? number_format($avgStars, 1) : 0;
        }

        // $allDivisions = SubRole::all();
        $previousDecisions = $currentStudent->decisions()->with('judge')->get();

        $allDivisions = SubRole::join('activity_sub_roles', 'sub_roles.sub_role_id', '=', 'activity_sub_roles.sub_role_id')
            ->where('activity_sub_roles.student_activity_id', $activity->student_activity_id)
            ->whereNull('activity_sub_roles.deleted_at') // Cek Soft Delete (karena tabel pivot Anda pakai softDeletes)
            ->select('sub_roles.*') // Hanya ambil kolom data divisi
            ->get();

        $currUserInActivity = ActivityStructure::with(['role', 'subRole']) // Load both relationships
            ->whereHas('activity', function ($query) use ($activityCode) {
                $query->where('activity_code', $activityCode);
            })
            ->where('student_id', Auth::user()->student->student_id)
            ->firstOrFail();

        return view(
            'siswa.oprec.detail-pendaftar',
            compact(
                'activity',
                'currentStudent',
                'histories',
                'allDivisions',
                'previousDecisions',
                'currUserInActivity',
            )
        );
    }
    public function showInterview($activityCode, $registrationId)
    {
        // 1. Get the Activity ID from the Code
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();
        $studentActivityId = $activity->student_activity_id;

        // 2. Get the Student's Choices from Registration
        $registration = RecruitmentRegistration::findOrFail($registrationId);

        // 3. Define which Divisions (SubRoles) we want to see:
        // ID 1 (General/BPH), Choice 1, and Choice 2 (if exists)
        $targetSubRoleIds = [1, $registration->choice_1_sub_role_id];

        if ($registration->choice_2_sub_role_id) {
            $targetSubRoleIds[] = $registration->choice_2_sub_role_id;
        }

        // 4. Fetch SubRoles and Eager Load Questions
        // We use whereIn to get only the relevant divisions
        $listPertanyaanUntukDivisi = SubRole::whereIn('sub_role_id', $targetSubRoleIds)
            ->with([
                'activityQuestions' => function ($query) use ($studentActivityId) {
                    $query->where('student_activity_id', $studentActivityId);
                    // Optional: Load existing answers for this specific registration
                    // allowing the interviewer to edit previous saves
                }
            ])
            ->get();

        // 5. Retrieve existing answers to repopulate the form (optional but recommended)
        // Key the answers by question_id for easy access in Blade
        $existingData = RecruitmentAnswer::where('recruitment_registration_id', $registrationId)
            ->get()
            ->keyBy('question_id');

        return view('siswa.oprec.list-tanya-jawab-wawancara', compact(
            'listPertanyaanUntukDivisi',
            'activityCode',
            'registrationId',
            'registration',
            'existingData'
        ));
    }

    public function storeInterview(Request $request, $activityCode, $registrationId)
    {
        // Validate inputs
        $request->validate([
            'answers' => 'array',
            'answers.*' => 'nullable|string',
            'notes' => 'array',            // Validate notes array
            'notes.*' => 'nullable|string',
        ]);

        // Loop through the answers array: Key = Question ID, Value = The Answer Text
        $questionIds = array_unique(array_merge(
            array_keys($request->answers ?? []),
            array_keys($request->notes ?? [])
        ));

        foreach ($questionIds as $questionId) {
            RecruitmentAnswer::updateOrCreate(
                [
                    'recruitment_registration_id' => $registrationId,
                    'question_id' => $questionId,
                ],
                [
                    // Save both fields. Use null coalescing operator (??) 
                    // in case one field was left untouched/empty.
                    'answer_text' => $request->answers[$questionId] ?? null,
                    'interviewer_note' => $request->notes[$questionId] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Interview answers saved successfully!');
    }

    public function storeInterviewerDecision(Request $request, $activityCode, $registrationId)
    {
        $request->validate([
            'verdict' => 'required|in:accept,reject',
            'reason' => 'required|string|min:5',
        ]);

        // Create a record for this specific interviewer's vote
        RecruitmentDecision::updateOrCreate([
            'recruitment_registration_id' => $registrationId,
            'judge_student_id' => auth()->id(), // Assuming logged in user
        ], [
            'verdict' => $request->verdict,
            'reason' => $request->reason,
        ]);

        return redirect()->back()->with('success', 'Your recommendation has been submitted.');
    }

    // --- FUNCTION B: POST LEADER FINAL DECISION ---
    public function storeFinalDecision(Request $request, $activityCode, $registrationId)
    {
        $request->validate([
            'final_division_id' => 'required_if:final_status,accepted|exists:sub_roles,sub_role_id',
            'final_reason' => 'required|string',
            'final_status' => 'required|in:accepted,rejected',
        ]);

        $registration = RecruitmentRegistration::findOrFail($registrationId);

        // Update the main registration record
        $registration->update([
            'status' => $request->final_status,
            'choice_1_sub_role_id' => $request->final_status === 'accepted' ? $request->final_division_id : $registration->choice_1_sub_role_id,
            'decision_reason' => $request->final_reason, // Saving the compiled reason
        ]);

        return redirect()->back()
            ->with('success', 'Final decision successfully posted!');
    }
}
