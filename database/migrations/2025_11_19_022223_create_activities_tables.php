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
        // 1. Proposal (Awal Mula)
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id'); // Ketua Pengaju
            $table->string('title');
            $table->text('description');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->text('reject_reason')->nullable();
            $table->timestamps();

            $table->foreign('student_id')->references('student_id')->on('students');
        });

        // 2. Student Activities (Paten + Modifikasi Status & Link Proposal)
        Schema::create('student_activities', function (Blueprint $table) {
            $table->increments('student_activity_id');
            $table->unsignedBigInteger('proposal_id')->nullable(); // Link ke proposal
            $table->string('activity_code', 25)->unique();
            $table->string('activity_catalog_code', 10);
            $table->unsignedInteger('student_organization_id');
            $table->string('activity_name', 255);
            $table->text('activity_description')->nullable();
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime')->nullable();

            // Kolom tambahan untuk kontrol alur
            $table->enum('status', ['preparation', 'open_recruitment', 'interview', 'active', 'grading_1', 'grading_2', 'finished'])->default('preparation');

            $table->timestamps();

            $table->foreign('proposal_id')->references('id')->on('proposals');
            $table->foreign('student_organization_id')->references('student_organization_id')->on('student_organizations');
        });

        Schema::create('sub_roles', function (Blueprint $table) {
            $table->increments('sub_role_id');
            $table->string('sub_role_code', 10)->nullable();

            $table->string('sub_role_name', 255);
            $table->string('sub_role_name_en', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

        });

        Schema::create('activity_sub_roles', function (Blueprint $table) {
            // 1. Primary Key (Incremental)
            $table->increments('activity_sub_roles_id');

            // 2. Foreign Key ke Student Activity
            $table->unsignedInteger('student_activity_id');

            // 3. Foreign Key ke Sub Roles (Master Divisi)
            // Saya namakan 'sub_role_id' (singular) agar sesuai standar Laravel relasi ke 'sub_role_id'
            // Jika Anda wajib pakai 'sub_roles_id' (plural), ubah parameter pertama di bawah.
            $table->unsignedInteger('sub_role_id'); 

            $table->timestamps();
            $table->softDeletes(); // <--- Added Soft Deletes

            // DEFINISI FOREIGN KEYS
            $table->foreign('student_activity_id')
                  ->references('student_activity_id')
                  ->on('student_activities');
     

            $table->foreign('sub_role_id')
                  ->references('sub_role_id') // Kolom id di tabel sub_roles
                  ->on('sub_roles');

        });

        // 3. Activity Structures (Paten + Modifikasi Nilai Akhir)
        Schema::create('activity_structures', function (Blueprint $table) {
            $table->increments('activity_structure_id');
            $table->unsignedInteger('student_activity_id');
            $table->unsignedInteger('student_id');
            $table->unsignedInteger('student_role_id')->nullable();
            $table->unsignedInteger('sub_role_id')->nullable();
            $table->string('structure_name', 255)->nullable();
            $table->integer('structure_points')->nullable();

            // Kolom tambahan untuk Step 4 (Grading)
            $table->float('final_point_percentage')->nullable(); 
            $table->text('final_review')->nullable(); // Review ketua
            $table->softDeletes();

            $table->timestamps();

            $table->foreign('student_activity_id')->references('student_activity_id')->on('student_activities');
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('student_role_id')->references('student_role_id')->on('student_roles');
            $table->foreign('sub_role_id')->references('sub_role_id')->on('sub_roles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_structures');
        Schema::dropIfExists('sub_roles');
        Schema::dropIfExists('student_activities');
        Schema::dropIfExists('proposals');
        Schema::dropIfExists('activity_sub_roles');
    }
};
