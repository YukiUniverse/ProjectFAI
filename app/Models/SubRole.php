<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubRole extends Model
{
    use HasFactory;

    // Karena nama PK di database 'sub_role_id'
    protected $primaryKey = 'sub_role_id';

    protected $fillable = [
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
}
