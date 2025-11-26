<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitySchedule extends Model
{
    protected $table = 'activity_schedules'; // Pastikan nama tabel sesuai migration

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'student_activity_id',
        'title',
        'start_time',
        'end_time', // Opsional, bisa null
        'location',
        'description',
        'status' // Tambahan agar kolom status di UI bisa disimpan
    ];

    // Relasi balik ke Activity (PENTING untuk redirect)
    public function activity()
    {
        return $this->belongsTo(StudentActivity::class, 'student_activity_id', 'student_activity_id');
    }
}