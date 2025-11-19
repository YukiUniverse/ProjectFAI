<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruitmentRegistration extends Model
{
    protected $fillable = [
        'student_activity_id',
        'student_id',
        'choice_1_sub_role_id',
        'reason_1',
        'choice_2_sub_role_id',
        'reason_2',
        'status', // pending, interview, accepted, rejected
        'decision_reason'
    ];

    // Mahasiswa yang daftar
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Pilihan Divisi 1
    public function firstChoice()
    {
        return $this->belongsTo(SubRole::class, 'choice_1_sub_role_id', 'sub_role_id');
    }

    // Pilihan Divisi 2
    public function secondChoice()
    {
        return $this->belongsTo(SubRole::class, 'choice_2_sub_role_id', 'sub_role_id');
    }

    // Ambil jawaban interview peserta ini
    public function answers()
    {
        return $this->hasMany(RecruitmentAnswer::class, 'recruitment_registration_id', 'id');
    }

    // Ambil hasil voting BPH untuk peserta ini
    public function decisions()
    {
        return $this->hasMany(RecruitmentDecision::class, 'recruitment_registration_id', 'id');
    }
}
