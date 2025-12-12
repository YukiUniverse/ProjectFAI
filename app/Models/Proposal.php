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
        'reject_reason',
        'start_datetime',
        'end_datetime',
        'student_organization_id'
    ];

    // Siapa ketua yang mengajukan
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    // Activity yang terbentuk dari proposal ini
    public function activity()
    {
        return $this->hasOne(StudentActivity::class, 'proposal_id', 'id');
    }

    // Organisasi yang mengajukan proposal (Relasi Baru)
    public function studentOrganization()
    {
        // Parameter ke-2: FK di tabel proposals
        // Parameter ke-3: PK di tabel student_organizations
        return $this->belongsTo(StudentOrganization::class, 'student_organization_id', 'student_organization_id');
    }
}
