<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alert_characteristics', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('alert_in_advance_in_hours')->nullable();
            $table->unsignedInteger('alert_in_advance_in_engine_hours')->nullable();
            $table->unsignedInteger('alert_in_advance_in_mileage')->nullable();
            $table->boolean('alert')->default(false);

            $table->timestamps();


            $table->unsignedBigInteger('component_id')->unique()->index();
            $table->foreign('component_id')->references('id')->on('components')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_characteristics');
    }
};
