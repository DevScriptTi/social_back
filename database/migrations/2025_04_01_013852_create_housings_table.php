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
        Schema::create('housings', function (Blueprint $table) {
            $table->id();
            $table->enum('current_housing_type', [
                'non_residential_place',
                'collapsing_communal',
                'collapsing_private',
                'with_relatives_or_rented',
                'functional_housing'
            ])->nullable();
            $table->enum('previously_benefited', ['yes', 'no'])->nullable();
            $table->decimal('housing_area', 8, 2)->nullable();
            $table->text('other_properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housings');
    }
};
