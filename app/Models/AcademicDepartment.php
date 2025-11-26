<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicDepartment extends Model
{
    // Sesuaikan dengan nama primary key di database Anda
    protected $primaryKey = 'department_id';

    protected $fillable = [
        'department_name',
    ];

    // Relasi balik ke students (Opsional)
    public function students()
    {
        return $this->hasMany(Student::class, 'department_id', 'department_id');
    }
}
