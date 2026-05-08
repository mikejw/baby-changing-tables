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
        Schema::create('feeds', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('nappy_wet')->default(false);
            $table->boolean('nappy_poo')->default(false);
            $table->boolean('breast_fed')->default(false);
            $table->foreignId('changed_by')->nullable()->constrained('users');
            $table->foreignId('fed_by')->nullable()->constrained('users');
            $table->foreignId('skin_to_skin_with')->nullable()->constrained('users');
            $table->unsignedSmallInteger('skin_to_skin_minutes')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('formula_ounces', 4, 2)->nullable();
            $table->unsignedTinyInteger('cry_level')->default(0);
            $table->decimal('temperature', 4, 2)->nullable();
            $table->boolean('change_of_clothes')->default(false);
            $table->boolean('table_wee')->default(false);
            $table->boolean('table_poo')->default(false);
            $table->decimal('time_in_sun', 2, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feeds');
    }
};
