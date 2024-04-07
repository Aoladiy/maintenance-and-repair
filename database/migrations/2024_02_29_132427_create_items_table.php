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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('site')->nullable();
            $table->string('equipment_name')->nullable();
            $table->string('inventory_number')->nullable();
            $table->string('node')->nullable();
            $table->text('component')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('operation')->nullable();
            $table->unsignedInteger('service_duration_in_seconds')->nullable();
            $table->integer('service_period_in_days')->nullable();
            $table->unsignedInteger('service_period_in_engine_hours')->nullable();
            $table->unsignedInteger('engine_hours_on_the_datetime_of_last_service')->nullable();
            $table->unsignedInteger('mileage')->nullable();
            $table->unsignedInteger('mileage_on_the_datetime_of_last_service')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->dateTime('datetime_of_last_service')->nullable();
            $table->dateTime('datetime_of_next_service')->nullable();
            $table->unsignedInteger('alert_time_in_hours')->nullable();
            $table->unsignedInteger('alert_time_in_engine_hours')->nullable();
            $table->unsignedInteger('alert_time_in_mileage')->nullable();
            $table->boolean('alert')->default(false);
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('items')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
