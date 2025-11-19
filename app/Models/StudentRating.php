<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRating extends Model
{
    protected $fillable = [
        'student_activity_id',
        'rater_student_id',
        'rated_student_id',
        'stars',
        'reason'
    ];

    // Siapa yang memberi nilai
    public function rater()
    {
        return $this->belongsTo(Student::class, 'rater_student_id', 'student_id');
    }

    // Siapa yang dinilai
    public function rated()
    {
        return $this->belongsTo(Student::class, 'rated_student_id', 'student_id');
    }
}
