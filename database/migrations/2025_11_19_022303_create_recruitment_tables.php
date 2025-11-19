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
        // 1. Questions (Bank Soal)
        Schema::create('recruitment_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_activity_id');
            $table->unsignedInteger('sub_role_id')->nullable(); // Null = Soal Umum
            $table->text('question');
            $table->timestamps();

            $table->foreign('student_activity_id')->references('student_activity_id')->on('student_activities');
            $table->foreign('sub_role_id')->references('sub_role_id')->on('sub_roles');
        });

        // 2. Registrations (Pendaftaran Peserta)
        Schema::create('recruitment_registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_activity_id');
            $table->unsignedInteger('student_id');

            // Pilihan Divisi
            $table->unsignedInteger('choice_1_sub_role_id');
            $table->text('reason_1');
            $table->unsignedInteger('choice_2_sub_role_id')->nullable();
            $table->text('reason_2')->nullable();

            // Status & Keputusan Akhir
            $table->enum('status', ['pending', 'interview', 'accepted', 'rejected'])->default('pending');
            $table->text('decision_reason')->nullable(); // <--- ALASAN FINAL KETUA DISINI

            $table->timestamps();

            $table->foreign('student_activity_id')->references('student_activity_id')->on('student_activities');
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('choice_1_sub_role_id')->references('sub_role_id')->on('sub_roles');
        });

        // 3. Answers (Jawaban Interview & Catatan Sekretaris)
        Schema::create('recruitment_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruitment_registration_id');
            $table->unsignedBigInteger('question_id');
            $table->text('answer_text')->nullable();
            $table->text('interviewer_note')->nullable(); // Note tambahan
            $table->timestamps();

            $table->foreign('recruitment_registration_id')->references('id')->on('recruitment_registrations');
            $table->foreign('question_id')->references('id')->on('recruitment_questions');
        });

        // 4. Decisions (Voting BPH)
        Schema::create('recruitment_decisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recruitment_registration_id');
            $table->unsignedInteger('judge_student_id'); // BPH yang menilai
            $table->enum('verdict', ['accept', 'reject']);
            $table->text('reason'); // Alasan personal BPH
            $table->timestamps();

            $table->foreign('recruitment_registration_id')->references('id')->on('recruitment_registrations');
            $table->foreign('judge_student_id')->references('student_id')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recruitment_decisions');
        Schema::dropIfExists('recruitment_answers');
        Schema::dropIfExists('recruitment_registrations');
        Schema::dropIfExists('recruitment_questions');
    }
};
