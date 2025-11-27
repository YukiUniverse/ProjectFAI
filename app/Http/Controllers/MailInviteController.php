<?php

namespace App\Http\Controllers;

use App\Models\MailInvite;
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

        }

        $message = $request->status === 'accept' ? 'Invitation accepted!' : 'Invitation declined.';

        return redirect()->back()->with('success', $message);
    }
}
