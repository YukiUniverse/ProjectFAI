<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivitySchedule;
use App\Models\StudentActivity;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Simpan Jadwal Baru
     */
    public function store(Request $request, $activityCode)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'location' => 'required|string|max:255',
        ]);

        // Cari ID Activity berdasarkan Code
        $activity = StudentActivity::where('activity_code', $activityCode)->firstOrFail();

        ActivitySchedule::create([
            'student_activity_id' => $activity->student_activity_id,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'status' => 'pending', // Default status
            'description' => '-'   // Default description
        ]);

        return back()->with('success', 'Jadwal kegiatan berhasil ditambahkan!');
    }

    /**
     * Tampilkan Halaman Edit
     */
    public function edit($id)
    {
        // Ambil jadwal beserta data activity-nya
        $schedule = ActivitySchedule::with('activity')->findOrFail($id);
        
        return view('siswa.jadwal-edit', compact('schedule'));
    }

    /**
     * Update Data Jadwal
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'location' => 'required|string|max:255',
            'status' => 'required|in:pending,completed', // Sesuaikan dengan enum di DB
        ]);

        $schedule = ActivitySchedule::findOrFail($id);

        $schedule->update([
            'title' => $request->title,
            'start_time' => $request->start_time,
            'location' => $request->location,
            'status' => $request->status
        ]);

        // Redirect kembali ke halaman detail panitia (menggunakan relasi activity)
        return redirect()->route('siswa.panitia-detail', $schedule->activity->activity_code)
                         ->with('success', 'Jadwal berhasil diperbarui!');
    }

    /**
     * Hapus Jadwal
     */
    public function destroy($id)
    {
        $schedule = ActivitySchedule::findOrFail($id);
        $schedule->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }
}