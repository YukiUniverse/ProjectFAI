<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRole extends Model
{
    use HasFactory;

    // Karena nama PK di database 'student_role_id', bukan 'id'
    protected $primaryKey = 'student_role_id';

    protected $fillable = [
        'role_code', // Contoh: LEAD, NOTE, MEBR
        'role_name', // Contoh: Team Lead, Notetaker
    ];

    // (Opsional) Relasi ke ActivityStructure
    // Buat ngecek role ini dipake siapa aja
    public function activityStructures()
    {
        return $this->hasMany(ActivityStructure::class, 'student_role_id', 'student_role_id');
    }
}
