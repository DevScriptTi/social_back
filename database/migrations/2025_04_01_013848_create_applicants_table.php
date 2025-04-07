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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('national_id_number')->unique();
            $table->string('residence_place');
            $table->string('email');
            $table->string('phone');
            $table->enum('gender', ['male', 'female']);
            $table->enum('status', ['single', 'married', 'divorced', 'widowed']);
            $table->unsignedSmallInteger('children_number');
            $table->string('key', 10)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
