<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Import Trait

class SubRole extends Model
{
    use HasFactory, SoftDeletes;

    // Karena nama PK di database 'sub_role_id'
    protected $primaryKey = 'sub_role_id';

    protected $fillable = [
        'student_activity_id', 
        'sub_role_code',    // Contoh: SR01
        'sub_role_name',    // Contoh: Koordinator
        'sub_role_name_en', // Contoh: Coordinator
    ];

    // (Opsional) Relasi ke ActivityStructure
    // Buat ngecek divisi ini isinya siapa aja
    public function activityStructures()
    {
        return $this->hasMany(ActivityStructure::class, 'sub_role_id', 'sub_role_id');
    }
    public function activityQuestions()
    {
        return $this->hasMany(RecruitmentQuestion::class, 'sub_role_id', 'sub_role_id');
    }

    public function activity()
    {
        return $this->belongsTo(StudentActivity::class, 'student_activity_id', 'student_activity_id');
    }
}
