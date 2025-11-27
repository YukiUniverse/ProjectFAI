<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailInvite extends Model
{
    protected $fillable = [
        'student_id',
        'student_activity_id',
        'status'
    ];
    public $timestamps = true;
    public function activity()
    {
        // Make sure to match the column name 'student_activity_id'
        return $this->belongsTo(StudentActivity::class, 'student_activity_id', 'student_activity_id');
    }
}
