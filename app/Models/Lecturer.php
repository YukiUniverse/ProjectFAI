<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    // Karena primary key di tabel bukan 'id'
    protected $primaryKey = 'lecturer_id';

    protected $fillable = [
        'lecturer_code',    // Kode unik, misal L001
        'lecturer_name',
        'employee_nip',     // NIP
        'nidn',             // NIDN (boleh null)
        'employment_status', // active/inactive
        'start_date',
        'end_date',
        'is_certified',     // boolean 0/1
    ];

    // Konversi tipe data otomatis biar enak dipake
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_certified' => 'boolean',
    ];

    // Relasi ke User Login (One to One)
    public function user()
    {
        return $this->hasOne(User::class, 'lecturer_id', 'lecturer_id');
    }
}
