<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivitySchedule extends Model
{
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $fillable = [
        'student_activity_id', // Jadwal milik acara mana
        'title',               // Judul rapat/agenda
        'start_time',
        'end_time',
        'location',            // Ruangan/Tempat
        'description',         // Deskripsi singkat
    ];
}
