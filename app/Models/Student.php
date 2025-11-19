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

    // Relasi ke User Login
    public function user()
    {
        return $this->hasOne(User::class, 'student_id', 'student_id');
    }

    // Relasi ke kepanitiaan yang diikuti (Activity Structure)
    public function activities()
    {
        return $this->hasMany(ActivityStructure::class, 'student_id', 'student_id');
    }
}
