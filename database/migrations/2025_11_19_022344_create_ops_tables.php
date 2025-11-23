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
        // 1. Schedule (Step 3)
        Schema::create('activity_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_activity_id');
            $table->string('title');
            $table->dateTime('start_time');
            $table->string('location');
            $table->enum('status', ['pending', 'completed'])->default('pending');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('student_activity_id')->references('student_activity_id')->on('student_activities');
        });

        // 2. Ratings (Step 4)
        Schema::create('student_ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_activity_id');
            $table->unsignedInteger('rater_student_id'); // Yang memberi rating
            $table->unsignedInteger('rated_student_id'); // Yang dirating
            $table->integer('stars'); // 1-4
            $table->text('reason');
            $table->timestamps();

            $table->foreign('student_activity_id')->references('student_activity_id')->on('student_activities');
            $table->foreign('rater_student_id')->references('student_id')->on('students');
            $table->foreign('rated_student_id')->references('student_id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_ratings');
        Schema::dropIfExists('activity_schedules');
    }
};
