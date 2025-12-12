<?php

namespace App\Http\Middleware;

use App\Models\ActivityStructure;
use App\Models\StudentActivity;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActivityLead
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Get the current user
        $user = Auth::user();

        if (!$user) {
            return redirect('login'); // or abort(401);
        }

        // 2. Get the 'activityCode' from the Route URL
        $activityCode = $request->route('activityCode');

        // 3. Find the activity to get its ID
        $activity = StudentActivity::where('activity_code', $activityCode)->first();

        // If activity doesn't exist, show 404
        if (!$activity) {
            abort(404, 'Activity not found.');
        }

        // 4. Check if the user is in the ActivityStructure for this activity
        // Assuming your User model's ID maps to 'student_id' in ActivityStructure
        $isMember = ActivityStructure::where('student_activity_id', $activity->student_activity_id)
            ->where('student_id', $user->student->student_id)->with('role')
            ->firstOrFail();

        if (!$isMember || ($isMember->role->role_code != "LEAD")) {
            // 5. If not a member, deny access
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}
