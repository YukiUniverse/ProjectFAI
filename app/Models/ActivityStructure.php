<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityStructure extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'activity_structure_id';
    

    protected $fillable = [
        'student_activity_id',
        'student_id',
        'student_role_id',        // Jabatan (Ketua, Anggota, dll)
        'sub_role_id',            // Divisi (Acara, Humas, dll)
        'structure_name',         // Nama jabatan custom (misal: Koordinator Acara)
        'structure_points',       // Poin dasar SKP
        'final_point_percentage', // Tambahan: Hasil rating (misal: 90, 100, 85)
        'final_review',           // Tambahan: Alasan/Review akhir dari ketua
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function activity()
    {
        return $this->belongsTo(StudentActivity::class, 'student_activity_id', 'student_activity_id');
    }

    public function role()
    {
        return $this->belongsTo(StudentRole::class, 'student_role_id', 'student_role_id');
    }

    public function subRole()
    {
        return $this->belongsTo(SubRole::class, 'sub_role_id', 'sub_role_id');
    }
}
