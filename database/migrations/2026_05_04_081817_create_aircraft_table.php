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
        Schema::create('aircraft', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable(); // type of aircraft [single, multi, jet, twinjet, turboprop, twinturboprop]
            $table->string('make')->nullable()->index(); // make of aircraft
            $table->string('model')->nullable(); // model of aircraft
            $table->string('description')->nullable(); // general details on the aircraft
            $table->string('registration')->unique(); // ICAO Registration Code
            $table->foreignId('engine_type_id')
                ->nullable()
                ->constrained('engine_types')
                ->nullOnDelete(); // engine types can change so we need to allow for null
            $table->decimal('rental_price_per_hour')->default(0);
            $table->boolean('in_service')->default(true); // is the aircraft serviceable
            $table->integer('current_hours')->default(0); // this is the current hours of the aircraft
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aircraft');
    }
};
