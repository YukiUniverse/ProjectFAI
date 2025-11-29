<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailInvite extends Model
{
    protected $table = 'mail_invites';

    protected $fillable = [
        'student_number', // <--- GANTI INI (Bukan student_id)
        'student_activity_id',
        'status'
    ];

    public $timestamps = true;

    // Relasi ke Activity
    public function activity()
    {
        return $this->belongsTo(StudentActivity::class, 'student_activity_id', 'student_activity_id');
    }

    // Relasi ke Student (PENTING: Definisikan key-nya)
    public function student()
    {
        // Parameter 2: Foreign Key di tabel mail_invites (student_number)
        // Parameter 3: Owner Key di tabel students (student_number)
        return $this->belongsTo(Student::class, 'student_number', 'student_number');
    }
}