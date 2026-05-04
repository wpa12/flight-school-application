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
        Schema::create('airports', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // name of the airport
            $table->text('description')->nullable(); // description of the airport
            $table->string('icao_code')->unique(); // ICAO Code for airport
            $table->decimal('landing_fee')->default(0); // landing fee at the airport
            $table->decimal('avgas_price_per_litre')->default(0); // avgas price per litre at the airport
            $table->decimal('jetA1_price_per_litre')->default(0); // jetA1 price per litre at the airport
            $table->foreignId('address_id')->nullable()->nullOnDelete(); // if the address is accidentally deleted it won't delete the airport
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airports');
    }
};
