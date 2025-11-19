<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruitmentDecision extends Model
{
    protected $fillable = [
        'recruitment_registration_id',
        'judge_student_id',
        'verdict', // accept / reject
        'reason'
    ];

    // Siapa BPH yang menilai
    public function judge()
    {
        return $this->belongsTo(Student::class, 'judge_student_id', 'student_id');
    }
}
