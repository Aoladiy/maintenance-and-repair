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
            $table->string('component')->nullable();
            $table->string('vendor_code')->nullable();
            $table->string('operation')->nullable();
            $table->string('service_period_in_days')->nullable();
            $table->unsignedInteger('service_period_in_engine_hours')->nullable();
            $table->unsignedInteger('mileage')->nullable();
            $table->unsignedInteger('amount')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('items');
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
