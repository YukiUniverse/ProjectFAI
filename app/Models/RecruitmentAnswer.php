<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruitmentAnswer extends Model
{
    protected $fillable = [
        'recruitment_registration_id',
        'question_id',
        'answer_text',
        'interviewer_note'
    ];

    // Jawaban ini untuk pertanyaan apa
    public function question()
    {
        return $this->belongsTo(RecruitmentQuestion::class, 'question_id', 'id');
    }
}
