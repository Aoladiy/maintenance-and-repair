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
        Schema::create('component_operation_pivot', function (Blueprint $table) {
            $table->unsignedBigInteger('component_id');
            $table->unsignedBigInteger('operation_id');

            $table->foreign('component_id')->references('id')->on('components')->cascadeOnDelete();
            $table->foreign('operation_id')->references('id')->on('operations')->cascadeOnDelete();

            $table->primary(['component_id', 'operation_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('component_operation_pivot');
    }
};
