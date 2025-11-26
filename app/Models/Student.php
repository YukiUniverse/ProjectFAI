<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $primaryKey = 'student_id'; // Wajib karena bukan 'id'
    protected $fillable = [
        'student_number', // NRP (Unik)
        'full_name',
        'points_balance', // Saldo poin saat ini
        'class_group',    // Kelas A/B/C
        'department_id',  // Jurusan
    ];

// --- PERBAIKAN 1: Relasi ke User Login ---
    public function user()
    {
        // Di database, tabel users terhubung lewat 'student_number', bukan 'student_id'
        return $this->hasOne(User::class, 'student_number', 'student_number');
    }

    // --- PERBAIKAN 2: Relasi ke Jurusan (Wajib untuk Laporan KPI Dosen) ---
    public function department()
    {
        return $this->belongsTo(AcademicDepartment::class, 'department_id', 'department_id');
    }
    
    // Relasi ke kepanitiaan yang diikuti (Activity Structure)
    public function activities()
    {
        return $this->hasMany(ActivityStructure::class, 'student_id', 'student_id');
    }
}
