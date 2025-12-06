<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivitySubRole extends Model
{
    use HasFactory, SoftDeletes;

    // Sesuaikan dengan nama tabel baru
    protected $table = 'activity_sub_roles';
    protected $primaryKey = 'activity_sub_roles_id';

    protected $fillable = [
        'student_activity_id',
        'sub_role_id',
    ];

    public function activity()
    {
        return $this->belongsTo(StudentActivity::class, 'student_activity_id', 'student_activity_id');
    }

    public function subRole()
    {
        return $this->belongsTo(SubRole::class, 'sub_role_id', 'sub_role_id');
    }
}