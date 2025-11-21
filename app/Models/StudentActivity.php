<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentActivity extends Model
{
    protected $primaryKey = 'student_activity_id'; // Wajib
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    protected $fillable = [
        'activity_code',           // Unik, misal: ACT1001
        'activity_catalog_code',   // EVT, WKS, CMP
        'student_organization_id', // Ormawa penyelenggara
        'activity_name',           // Nama acara
        'activity_description',           // Nama acara
        'start_datetime',
        'end_datetime',
        'status',      // Tambahan: preparation, open_recruitment, active, finished
        'proposal_id', // Tambahan: link ke proposal pengajuan
    ];

    // Ambil Proposalnya
    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'proposal_id', 'id');
    }

    // Ambil daftar anggota resmi (ActivityStructure)
    public function members()
    {
        return $this->hasMany(ActivityStructure::class, 'student_activity_id', 'student_activity_id');
    }

    // Ambil daftar pendaftar (Recruitment)
    public function registrations()
    {
        return $this->hasMany(RecruitmentRegistration::class, 'student_activity_id', 'student_activity_id');
    }

    // Ambil jadwal (Schedule)
    public function schedules()
    {
        return $this->hasMany(ActivitySchedule::class, 'student_activity_id', 'student_activity_id');
    }
}
