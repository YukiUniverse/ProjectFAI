<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecruitmentQuestion extends Model
{
    protected $fillable = [
        'student_activity_id', // Soal ini untuk acara apa
        'sub_role_id',         // (Nullable) Kalau null berarti soal umum, kalau ada isi berarti soal divisi
        'question',            // Isi pertanyaannya
    ];

    // Jika soal khusus divisi tertentu
    public function subRole()
    {
        return $this->belongsTo(SubRole::class, 'sub_role_id', 'sub_role_id');
    }
}
