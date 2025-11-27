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

            // Foreign Key to Student Number (String)
            // Note: Ensure 'student_number' in 'students' table is indexed or unique
            $table->string('student_number')->nullable();
            $table->unsignedInteger('student_activity_id');


            $table->foreign('student_number')
                ->references('student_number') // Kolom di tabel students
                ->on('students')
                ->onDelete('cascade');

            // Foreign Key to Activity
            $table->foreign('student_activity_id')
                ->references('student_activity_id') // Adjust if your PK is just 'id'
                ->on('student_activities')
                ->onDelete('cascade');

            // Status Enum
            $table->enum('status', ['pending', 'accept', 'decline'])->default('pending');

            $table->timestamps();
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
