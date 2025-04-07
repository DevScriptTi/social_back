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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('birth_certificate');
            $table->string('spouse_birth_certificate');
            $table->string('family_individual_certificate');
            $table->string('applicant_national_id');
            $table->string('spouse_national_id');
            $table->string('residence_certificate');
            $table->string('employment_unemployment_certificate');
            $table->string('spouse_employment_certificate');
            $table->string('spouse_salary_certificate');
            $table->string('applicant_salary_certificate');
            $table->string('non_real_estate_ownership_certificate');
            $table->string('medical_certificate');
            $table->string('death_divorce_certificate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
