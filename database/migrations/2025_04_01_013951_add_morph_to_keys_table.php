<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // add_foreign_keys_to_dairas.php
        Schema::table('dairas', function (Blueprint $table) {
            $table->foreignId('wilaya_id')->constrained('wilayas')->onDelete('cascade');
        });

        // add_foreign_keys_to_users.php
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('key_id')->constrained('keys')->onDelete('cascade');
        });

        // add_foreign_keys_to_committees.php
        Schema::table('committees', function (Blueprint $table) {
            $table->foreignId('daira_id')->constrained('dairas')->onDelete('cascade');
        });

        // add_foreign_keys_to_employees.php
        Schema::table('employees', function (Blueprint $table) {
            $table->foreignId('daira_id')->constrained('dairas')->onDelete('cascade');
            $table->foreignId('committee_id')->constrained('committees')->onDelete('cascade');
        });

        // add_foreign_keys_to_applicants.php
        Schema::table('applicants', function (Blueprint $table) {
            $table->foreignId('committee_id')->constrained('committees')->onDelete('cascade');
        });

        // add_foreign_keys_to_wives.php
        Schema::table('wives', function (Blueprint $table) {
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
        });

        // add_foreign_keys_to_applications.php
        Schema::table('applications', function (Blueprint $table) {
            $table->foreignId('committee_id')->nullable()->constrained('committees')->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('applicants')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
        });

        // add_foreign_keys_to_professionals.php
        Schema::table('professionals', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
        });

        // add_foreign_keys_to_housings.php
        Schema::table('housings', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
        });

        // add_foreign_keys_to_files.php
        Schema::table('files', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
        });

        // add_foreign_keys_to_healths.php
        Schema::table('healths', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
        });

        // add_foreign_keys_to_grades.php
        Schema::table('grades', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
        });

        // add_foreign_keys_to_qrcodes.php
        Schema::table('qr_codes', function (Blueprint $table) {
            $table->foreignId('application_id')->constrained('applications')->onDelete('cascade');
        });

        // add_foreign_keys_to_socials.php


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('keys', function (Blueprint $table) {
            // Add logic here if needed or remove this block entirely if unused
        });
    }
};
