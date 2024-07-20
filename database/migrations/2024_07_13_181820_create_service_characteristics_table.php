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
        Schema::create('service_characteristics', function (Blueprint $table) {
            $table->id();


            $table->unsignedInteger('service_duration_in_seconds')->nullable();

            $table->integer('service_period_in_days')->nullable();

            $table->unsignedInteger('service_period_in_engine_hours')->nullable();
            $table->unsignedInteger('engine_hours_by_the_datetime_of_last_service')->nullable();

            $table->unsignedInteger('mileage')->nullable();
            $table->unsignedInteger('mileage_by_the_datetime_of_last_service')->nullable();

            $table->dateTime('datetime_of_last_service')->nullable();
            $table->dateTime('datetime_of_next_service')->nullable();


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
        Schema::dropIfExists('service_characteristics');
    }
};
