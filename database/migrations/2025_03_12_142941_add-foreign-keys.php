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
        Schema::table('gurdians', function (Blueprint $table) {
            $table->foreignId('baladya_id')->nullable()->constrained('baladyas')->nullOnDelete();
        });

        Schema::table('childrens', function (Blueprint $table) {
            $table->foreignId('gurdian_id')->constrained('gurdians')->onDelete('cascade');
            $table->foreignId('baladya_id')->nullable()->constrained('baladyas')->nullOnDelete();
        });
        Schema::table('braclets', function (Blueprint $table) {
            $table->foreignId('children_id')->constrained('childrens')->onDelete('cascade');
        });

        Schema::table('baladyas', function (Blueprint $table) {
            $table->foreignId('wilaya_id')->constrained('wilayas')->onDelete('cascade');
        });
        Schema::table('circles', function (Blueprint $table) {
            $table->foreignId('braclet_id')->constrained('braclets')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
