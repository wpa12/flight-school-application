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
        Schema::create('engine_types', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique();
            $table->string('description')->nullable();
            $table->foreignId('fuel_type_id')
                ->nullable()
                ->constrained('fuel_types')
                ->nullOnDelete(); // if the fuel type is accidentally deleted it won't delete the engine type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engine_types');
    }
};
