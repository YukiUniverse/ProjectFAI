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
        // 1. Organizations (Dibutuhkan oleh student_activities)
        Schema::create('student_organizations', function (Blueprint $table) {
            $table->increments('student_organization_id');
            $table->string('organization_name');
            $table->timestamps();
        });

        // 2. Departments (Dibutuhkan oleh students)
        Schema::create('academic_departments', function (Blueprint $table) {
            $table->increments('department_id');
            $table->string('department_name');
            $table->timestamps();
        });

        // 3. Students (Paten)
        Schema::create('students', function (Blueprint $table) {
            $table->increments('student_id');
            $table->string('student_number', 11)->unique();
            $table->string('full_name', 200);
            $table->integer('points_balance')->default(0);
            $table->char('class_group', 1);
            $table->unsignedInteger('department_id');
            $table->timestamps();

            $table->foreign('department_id')->references('department_id')->on('academic_departments');
        });

        // 4. Lecturers (Paten)
        Schema::create('lecturers', function (Blueprint $table) {
            $table->increments('lecturer_id');
            $table->string('lecturer_code', 10)->unique();
            $table->string('lecturer_name', 255);
            $table->string('employee_nip', 11);
            $table->string('nidn', 10)->nullable();
            $table->string('employment_status', 20)->default('active');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('is_certified')->default(0);
            $table->timestamps();
        });

        // 5. Roles (Paten)
        Schema::create('student_roles', function (Blueprint $table) {
            $table->increments('student_role_id');
            $table->string('role_code', 10)->unique();
            $table->string('role_name', 255);
            $table->timestamps();
        });


        // 7. Users (Login System)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('student_number')->nullable();
            $table->string('lecturer_code')->nullable();
            $table->string('role');

            $table->rememberToken();
            $table->timestamps();

            // Foreign Key-nya harus nembak ke kolom unik di tabel sebelah
            // Pastikan di tabel 'students', kolom 'student_number' itu UNIQUE
            $table->foreign('student_number')
                ->references('student_number') // Kolom di tabel students
                ->on('students')
                ->onDelete('cascade');

            $table->foreign('lecturer_code')
                ->references('lecturer_code') // Kolom di tabel lecturers
                ->on('lecturers')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('student_roles');
        Schema::dropIfExists('lecturers');
        Schema::dropIfExists('students');
        Schema::dropIfExists('academic_departments');
        Schema::dropIfExists('student_organizations');
    }
};
