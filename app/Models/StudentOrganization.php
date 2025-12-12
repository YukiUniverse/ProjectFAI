<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentOrganization extends Model
{
    use HasFactory;

    // 1. Nama Tabel (Opsional jika ikut konvensi, tapi lebih aman ditulis)
    protected $table = 'student_organizations';

    // 2. Primary Key (WAJIB ditulis karena nama kolomnya bukan 'id')
    protected $primaryKey = 'student_organization_id';

    // 3. Mass Assignment (Kolom yang boleh diisi)
    protected $fillable = [
        'organization_name',
    ];

    /**
     * Relasi: Satu Organisasi memiliki banyak Kegiatan (Activities)
     */
    public function activities()
    {
        // Param 2: Foreign Key di tabel student_activities
        // Param 3: Primary Key di tabel student_organizations
        return $this->hasMany(StudentActivity::class, 'student_organization_id', 'student_organization_id');
    }

    public function proposals()
    {
        // Param 2: Foreign Key di tabel proposals
        // Param 3: Primary Key di tabel student_organizations
        return $this->hasMany(Proposal::class, 'student_organization_id', 'student_organization_id');
    }
}