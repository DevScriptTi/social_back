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
            $table->string('birth_certificate')->nullable();
            $table->string('spouse_birth_certificate')->nullable();
            $table->string('family_individual_certificate')->nullable();
            $table->string('applicant_national_id')->nullable();
            $table->string('spouse_national_id')->nullable();
            $table->string('residence_certificate')->nullable();
            $table->string('employment_unemployment_certificate')->nullable();
            $table->string('spouse_employment_certificate')->nullable();
            $table->string('spouse_salary_certificate')->nullable();
            $table->string('applicant_salary_certificate')->nullable();
            $table->string('non_real_estate_ownership_certificate')->nullable();
            $table->string('medical_certificate')->nullable();
            $table->string('death_divorce_certificate')->nullable();
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
