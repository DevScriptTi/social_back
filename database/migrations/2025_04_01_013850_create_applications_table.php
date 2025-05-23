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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->enum('status', ['pending', 'denied', 'on-review', 'accepted', 'not-classed'])->default('pending');
            $table->string('classment')->nullable();
            $table->string('key', 10)->unique();
            $table->string('grade')->nullable();
            $table->text('description')->nullable();
            $table->json('errors')->nullable();
            $table->integer('step')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
