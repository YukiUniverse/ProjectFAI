<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proposal extends Model
{
    protected $fillable = [
        'student_id',
        'title',
        'description',
        'status',
        'reject_reason'
    ];

    // Siapa ketua yang mengajukan
    public function proposer()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Activity yang terbentuk dari proposal ini
    public function activity()
    {
        return $this->hasOne(StudentActivity::class, 'proposal_id', 'id');
    }
}
