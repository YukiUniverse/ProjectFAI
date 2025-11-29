<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('mail_invites', function (Blueprint $table) {
            $table->id();
            
            // PERBAIKAN: Ubah menjadi string agar cocok dengan tabel 'students'
            // Foreign Key harus sama persis tipe datanya dengan tabel induk
            $table->string('student_number'); 
            
            $table->unsignedInteger('student_activity_id');
            
            // Update enum values to match your application logic ('accept' instead of 'accepted')
            $table->enum('status', ['pending', 'accept', 'decline'])->default('pending');
            $table->timestamps();

            // Foreign Key ke Student Number
            $table->foreign('student_number')
                  ->references('student_number')
                  ->on('students')
                  ->onDelete('cascade');

            // Foreign Key ke Activity
            $table->foreign('student_activity_id')
                  ->references('student_activity_id')
                  ->on('student_activities')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invite');
    }
};
